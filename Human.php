<?php
$myfile = fopen("HumanDO.obo", "r") or die("Unable to open file!");
$human =  fread($myfile,filesize("HumanDO.obo"));
$each_human = explode('[Term]',$human);
array_shift($each_human);   //ɾ��ǰ���Ƕ�û�õĻ�
$tree = array();
for ($x=0; $x<=90000; $x++) {
  $tree[$x] = array();
} 
//��¼���飬�±�Ϊ���ڵ㣬ֵΪ�����ӽڵ㹹�ɵ�����

foreach( $each_human as $u)
{
	
	$u = substr($u,10); 
	$p = '/is_a: DOID:/';
	$self_id = intval($u);  			//��ȡ���Լ���id
	if (preg_match($p, $u))				//����и��ڵ�
	{
		$father = explode('is_a: DOID:',$u);
		$father_id = intval($father[1]);//���ڵ��id
	}
	else $father_id = 0;   			    //���û�и��ڵ㣬���ڵ����0
	$p = '/is_obsolete: true/';
	if (preg_match($p, $u)) $is_obsolete = 1;
	else $is_obsolete = -1;			    //�ж��Ƿ����is_obsolete����,�������е���obsolete����������Ǵ���һ��û��ûobsolete�ĵ㣬4�ŵ�
	$tree[$father_id][] = $self_id;  	//���ӽڵ��idд�븸�ڵ��±������
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