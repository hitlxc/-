<?php
$myfile = fopen("HumanDO.obo", "r") or die("Unable to open file!");
$human =  fread($myfile,filesize("HumanDO.obo"));
$each_human = explode('[Term]',$human);
array_shift($each_human);   //删除前面那段没用的话
$tree = array();
for ($x=0; $x<=90000; $x++) {
  $tree[$x] = array();
} 
//记录数组，下标为父节点，值为所有子节点构成的数组

foreach( $each_human as $u)
{
	
	$u = substr($u,10); 
	$p = '/is_a: DOID:/';
	$self_id = intval($u);  			//获取它自己的id
	if (preg_match($p, $u))				//如果有父节点
	{
		$father = explode('is_a: DOID:',$u);
		$father_id = intval($father[1]);//父节点的id
	}
	else $father_id = 0;   			    //如果没有父节点，父节点计做0
	$p = '/is_obsolete: true/';
	if (preg_match($p, $u)) $is_obsolete = 1;
	else $is_obsolete = -1;			    //判定是否具有is_obsolete属性,不存在有爹还obsolete的情况，但是存在一个没爹没obsolete的点，4号点
	$tree[$father_id][] = $self_id;  	//把子节点的id写入父节点下标的数组
	if($father_id==0 && $is_obsolete == -1)$tree[90000][] = $self_id;
	//print_r($tree[$father_id]);
	//tree[$father_id] = $son;
	//echo $self_id.' '.$father_id.' '.$is_obsolete.'<br/>'.'<br/>';		
}
echo json_encode($tree);
//var_dump ($tree);

//print_r($tree);
fclose($myfile);

?>