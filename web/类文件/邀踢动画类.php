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
		$���� = $���ݿ�->��ѯ���ת��(mb_convert_encoding($����, 'gbk', 'utf-8'));
		$�û���� = intval($�û����);
		$Ƭʱ = intval($Ƭʱ);
		$��ɫ = intval($��ɫ);
		$ģʽ = intval($ģʽ);
		$��С = intval($��С);
		$�ٶ� = intval($�ٶ�);
		if(!$�ٶ�) $�ٶ� = FLY_SPEED_DEFAULT;

		$��� = "INSERT INTO ��Ļ(�������,�û����,����,����ʱ��,�ֺ�,��ɫ,ģʽ,�ٶ�)VALUES($�������,$�û����,'$����',$Ƭʱ,$��С,$��ɫ,$ģʽ,$�ٶ�)";
		$���ݿ�->��ѯ($���);
	}

	function _��ȡӰƬ��Ϣ($ҳ���ַ){
		//$Դ�� = file_get_contents("http://www.flvxz.com/getFlv.php?url=$ҳ���ַ");
		//���뷢��Cookie���ܻ�ȡ��ַ��
		$xmlhttp = new com('MSXML2.ServerXMLHTTP');
		$xmlhttp->open('GET', 'http://www.flvxz.net', false);
		$xmlhttp->setRequestHeader('Referer', 'http://www.flvxz.com/');
		$xmlhttp->send();
		$xmlhttp->open('GET', "http://www.flvxz.net/getFlv.php?url=$ҳ���ַ", false);
		$xmlhttp->setRequestHeader('Referer', 'http://www.flvxz.com/');
		$xmlhttp->send();
		$Դ�� = $xmlhttp->responseText;
		
		$��� = array();

		//die($Դ��);

		//if( preg_match('/(.+)<br.+"(http.+?)"/mi', $Դ��, $���) == 0 ) return null;
		if( preg_match('/<a href=\'(http.+?)\'.+;\'>(.+?)\.flv/mi', $Դ��, $���) == 0 ) return null;

		$���[1] = �١�������ת��($���[1]);
		return array(
					'����' => $���[2],
					'��ַ' => $���[1]
					);
	}
	
	function _��ȡ4sharedӰƬ��Ϣ($ҳ���ַ) {
		$curl = curl_init();
		curl_setopt_array($curl, array( CURLOPT_URL => $ҳ���ַ,
										CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
										CURLOPT_RETURNTRANSFER => 1
								));
		$Դ�� = curl_exec($curl);
		
		$��ַ����ʽ = '/playMedia\(document,\'(.+?)\',/mi';
		$��������ʽ = '/<meta name="title" content="(.+?)" \/>/mi';
		
		if (preg_match($��ַ����ʽ, $Դ��, $��ַ���) == 0) return null;
		if (preg_match($��������ʽ, $Դ��, $������) == 0) return null;
		
		return array(
					'����' => $������[1],
					'��ַ' => $��ַ���[1]
					);
		}
	
	public function �½���������($����, $˵��, $Դҳ��, $����ͼ){
		global $���ݿ�;
		
		if (stripos($Դҳ��, '4shared', 0) === FALSE) {
			$ӰƬ��Ϣ = $this->_��ȡӰƬ��Ϣ($Դҳ��);
		}
		else {
			$ӰƬ��Ϣ = $this->_��ȡ4sharedӰƬ��Ϣ($Դҳ��);
		}
		if(!$ӰƬ��Ϣ) return false;

		$��ַ = $ӰƬ��Ϣ['��ַ'];
		if($���� == '') $���� = $ӰƬ��Ϣ['����'];

		$˵�� = $���ݿ�->��ѯ���ת��($˵��);
		$��ַ = $���ݿ�->��ѯ���ת��($��ַ);
		$���� = $���ݿ�->��ѯ���ת��($����);
		$����ͼ = $���ݿ�->��ѯ���ת��($����ͼ);

		if(!strpos($Դҳ��, '.youku.') && !strpos($Դҳ��, '.tudou.')) $���� = mb_convert_encoding($����, 'gbk', 'utf-8');	//���˵ı�����utf-8�����

		$��� = "INSERT INTO ����(Դҳ��,��ַ,����,˵��,����ͼ·��,�û����) VALUES ( '$Դҳ��', '$��ַ', '$����', '$˵��', '$����ͼ', " . $this->�û�->��� . ")";

		$���ݿ�->��ѯ($���);

		//����������ӵĶ������ͷ��������ı��
		$��� = 'SELECT MAX(���) AS ��� FROM ����';
		$��� = $���ݿ�->��ѯ($���);
		return $���;
	}

	public function ����($��Ϣ){
		ob_clean();
		$��� = file_get_contents('ģ��/����.xml');
		$��� = str_replace('{$������Ϣ}', htmlspecialchars($��Ϣ), $���);
		header('Content-Type: text/xml; charset=utf-8');
		echo mb_convert_encoding($���, 'utf-8', 'gb2312');
		exit();
	}
}


function �١�������ת��($str){
	//���Ĵ�����Դ��http://blog.csdn.net/leinchu/archive/2008/02/27/2124810.aspx
	$str = preg_replace("|&#([0-9]{1,5});|", "\"._u2utf82gb(\\1).\"", $str);
	$str = "\$str=\"$str\";";
	eval($str);
	return  $str;
}
function _u2utf82gb($c){
    $str="";
    if ($c < 0x80) {
         $str.=$c;
    } else if ($c < 0x800) {
         $str.=chr(0xC0 | $c>>6);
         $str.=chr(0x80 | $c & 0x3F);
    } else if ($c < 0x10000) {
         $str.=chr(0xE0 | $c>>12);
         $str.=chr(0x80 | $c>>6 & 0x3F);
         $str.=chr(0x80 | $c & 0x3F);
    } else if ($c < 0x200000) {
         $str.=chr(0xF0 | $c>>18);
         $str.=chr(0x80 | $c>>12 & 0x3F);
         $str.=chr(0x80 | $c>>6 & 0x3F);
         $str.=chr(0x80 | $c & 0x3F);
    }
    return iconv('UTF-8', 'GB2312', $str);
}

?>