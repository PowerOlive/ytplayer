	<fieldset class="GeCiShangChuan">
		<legend>�������ϴ�lrc����ļ���Ϊ�ײ���Ļ</legend>
		<form enctype="multipart/form-data" action="uploadlrc.php?id=<?php echo $_GET['id'];?>" method="POST">
			
			<div>�����ϵ�еĵ�Ļ����һ�����֣�<input type="text" name="groupname" value="" /></div>
			<div>��Ļ��ɫ��������ʮ�����Ƶ���ɫֵ��<input type="text" name="color" value="ffffff" /></div>
			<div>ѡ��LRC����ļ���<input name="lrc" type="file" /></div>
			
			<input type="hidden" name="id" value="<?php echo $_GET['id'];?>" />
			<input type="submit" value="�ϴ��ļ�" />
		</form>
	</fieldset>





<?php

if (isset($_GET['id']) == 0) die('');

require_once('���ļ�/ͷ.php');
require_once('���ļ�/���߶���������ļ�����.php');


$id = intval($_GET['id']);
$groupname = $_POST['groupname'];
$color = $_POST['color'];
$color = hexdec(str_replace('#', '', $color));

$savepath = realpath('./lrcs') . '/';

// ȷ������·��
if (!file_exists($savepath . $_FILES['lrc']['name'])) {
	$savepath = $savepath . $_FILES['lrc']['name'];
}
else {
	$afternum = 1;
	while (file_exists($savepath . $_FILES['lrc']['name'] . '.' . $afternum)) $afternum++;
	$savepath = $savepath . $_FILES['lrc']['name'] . '.' . $afternum;
}

move_uploaded_file($_FILES['lrc']['tmp_name'], $savepath);

$savepath_s = $���ݿ�->��ѯ���ת��($savepath);
$groupname_s = $���ݿ�->��ѯ���ת��($groupname);

$���ݿ�->��ѯ("INSERT INTO ��Ļ���� (�������,�û����,����,�ļ���ַ)VALUES($id," .  $���߶���->�û�->��� . ",'$groupname_s','$savepath_s')");
$result = $���ݿ�->��ѯ('SELECT MAX(���) AS m FROM ��Ļ����');
$maxid = $result[0]['m'];

$sql = '';
$lrcs = ����ļ�����($savepath);

for ($i = 0; $i < count($lrcs); $i++) {
	$���� = $maxid;
	$�û���� = $���߶���->�û�->���;
	$���� = $���ݿ�->��ѯ���ת��($lrcs[$i]['����']);
	$Ƭʱ = $lrcs[$i]['Ƭʱ'];
	$��С = FLY_FONTSIZE_SMALL;
	$��ɫ = $color;
	$ģʽ = FLY_MODE_BOTTOM;
	$�ٶ� = $lrcs[$i]['�ٶ�'];

	$sql .= "INSERT INTO ���鵯Ļ(����,�û����,����,����ʱ��,�ֺ�,��ɫ,ģʽ,�ٶ�)VALUES($����,$�û����,'$����',$Ƭʱ,$��С,$��ɫ,$ģʽ,$�ٶ�);";
}
$���ݿ�->��ѯ($sql);

ob_clean();
die('����ϴ��ɹ����������' . count($lrcs) . '����Ļ');

?>


