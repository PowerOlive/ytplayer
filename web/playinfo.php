<?php
require_once('���ļ�/ͷ.php');

$����չ������ԡ�����Ԫ�� = '';
$����չ������� = '';
$�������� = $��Ļ���� = null;

//����ģ��
$����չ�������ģ�塣����Ԫ�� = file_get_contents('ģ��/����Ļ���ݡ�����Ԫ��.xml');
$����չ�������ģ�� = file_get_contents('ģ��/����Ļ����.xml');

//��ȡ��������
$�Ƿ��ض�λ = ($_GET['relocate'] == 1);
$������� = intval($_GET['id']);

//����Ļ�Ͷ�������
if(!$�������){	//����Դҳ��
	$Դҳ��ת�� = $���ݿ�->��ѯ���ת��($_GET['source']);
	if($Դҳ��ת�� == '') over('id��sourceȫδ����');

	$��� = "SELECT ���,������,����,˵��,����ͼ·��,��ַ,Դҳ�� FROM ���� WHERE Դҳ��='$Դҳ��ת��'";
	$�������� = $���ݿ�->��ѯ($���);
	if($��������){
		$������� = $��������[0]['���'];
	}
}
else{	 
	//���ݱ��
	//if(!$���߶���->�½���������('', '', $_GET['source'], '')) over('ָ������Ƶ������');
	$��� = "SELECT ��� FROM ���� WHERE ���=$�������";
	$��� = $���ݿ�->��ѯ($���);
	if(!$���) over('�޴˶���');
}


$���һ = "SELECT ������,����,˵��,����ͼ·��,��ַ,Դҳ�� FROM ���� WHERE ���=$�������";
$���� = "SELECT ����,����ʱ��,����ʱ��,��ɫ,�ֺ�,�ٶ�,ģʽ,��� FROM ��Ļ WHERE �������=$������� ORDER BY ����ʱ�� ASC";

if(!$��������) $�������� = $���ݿ�->��ѯ($���һ);

$��Ļ���� = $���ݿ�->��ѯ($����);

$ӰƬ��ַ = $��������[0]['��ַ'];
$���Ŵ��� = $��������[0]['������'];
$���� = $��������[0]['����'];
$˵�� = $��������[0]['˵��'];

//�ض�λ����
if($�Ƿ��ض�λ){
	�ض�λ����();
	exit();
}

//������Ļ�����XML
for($i = 0; $i < count($��Ļ����); $i++){
	//$��Ļ����[$i]['����ʱ��'] = strtotime($��Ļ����[$i]['����ʱ��']);
	$����ʱ�� = strtotime($��Ļ����[$i]['����ʱ��']);
	$�ٶ� = 'normal';
	$�ֺ� = $��Ļ����[$i]['�ֺ�'];
	$ģʽ = $��Ļ����[$i]['ģʽ'];
	$�Ƿ���Ļ = false;
	switch($ģʽ){
		case FLY_MODE_FLY:
			$ģʽ = 'fly';
			break;
		case FLY_MODE_TOP:
			$ģʽ = 'top';
			break;
		case FLY_MODE_BOTTOM:
			$ģʽ = 'bottom';
			break;
		case FLY_MODE_SUBTITLE:
			$�Ƿ���Ļ = true;
			$ģʽ = 'bottom';
			break;
		default:
			$ģʽ = 'fly';
			break;
	}

	$����չ������ԡ�����Ԫ�� .= sprintf($����չ�������ģ�塣����Ԫ��,
															$��Ļ����[$i]['���'],
															$�ֺ�,
															$�ٶ�,
															$��Ļ����[$i]['��ɫ'],
															$ģʽ,
															$�Ƿ���Ļ,
															$��Ļ����[$i]['����ʱ��'] / 1000,
															$����ʱ��,
															htmlspecialchars($��Ļ����[$i]['����'])
												);
															
}

$����չ������� = sprintf($����չ�������ģ��, 
										$�������,
										htmlspecialchars($ӰƬ��ַ),
										$���Ŵ���,
										htmlspecialchars($����),
										htmlspecialchars($˵��),
										$����չ������ԡ�����Ԫ��
									);

//echo htmlspecialchars($����չ�������);
ob_clean();
header("Content-Type: text/xml; charset=utf-8"); 
header("Cache-Control: no-cache, must-revalidate");
echo mb_convert_encoding($����չ�������, 'utf-8', 'gb2312');

/*********************************************/

function �ض�λ����(){
	global $��������;
	global $���߶���;
	global $���ݿ�;
	global $�������;

	$ӰƬ���� = $���߶���->_��ȡӰƬ��Ϣ($��������[0]['Դҳ��']);
	$�µ�ַ = $ӰƬ����['��ַ'];

	if($�µ�ַ){
		$��� = "UPDATE ���� SET ��ַ='$�µ�ַ' WHERE ���=$�������";
		$���ݿ�->��ѯ($���);
	}
	else{
		$�µ�ַ = '';
	}

	$�ض�λ����ģ�� = file_get_contents('ģ��/�ض�λ����.xml');
	$�ض�λ���� = sprintf($�ض�λ����ģ��, $�µ�ַ);
	
	ob_clean();
	header("Content-Type: text/xml; charset=utf-8"); 
	echo mb_convert_encoding($�ض�λ����, 'utf-8', 'gb2312');
}


function over($��Ϣ){
	ob_clean();
	header("Content-Type: text/xml; charset=utf-8"); 
	$��� =  '<?xml version="1.0" encoding="utf-8"?>';
	$��� .= '<ytp><error>' . htmlspecialchars($��Ϣ) . '</error></ytp>';
	$��� = mb_convert_encoding($���, 'utf-8', 'gb2312');
	echo $���;
	exit();
}

?>