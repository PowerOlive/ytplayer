<?php

class ���߶�����{
	public $�û�;

	function __construct(){
		require('���߶������û���.php');
		$this->�û� = new ���߶������û���;
	}

	function ���浯Ļ($�������, $����, $�û����, $Ƭʱ, $��ɫ, $ģʽ, $��С){
		global $���ݿ�;

		$������� = intval($�������);
		$���� = $���ݿ�->��ѯ���ת��($����);
		$�û���� = intval($�û����);
		$Ƭʱ = intval($Ƭʱ);
		$��ɫ = intval($��ɫ);
		$ģʽ = intval($ģʽ);
		$��С = intval($��С);

		$��� = "INSERT INTO ��Ļ(�������,�û����,����,����ʱ��,�ֺ�,��ɫ,ģʽ)VALUES($�������,$�û����,'$����',$Ƭʱ,$��С,$��ɫ,$ģʽ)";
		$���ݿ�->��ѯ($���);
	}

	function _��ȡӰƬ��ַ($ҳ���ַ){
		$Դ�� = file_get_contents("http://www.flvxz.com/getFlv.php?url=$ҳ���ַ");
		$��� = array();

		if( preg_match('/"(http.+?)"/mi', $Դ��, $���) == 0 ) return null;

		return $���[1];
	}

}

?>