<?php
class ���߶������û���{
	public $���;
	public $��������ַ;
	public $��ʶ����;
	public $����;

	public function __construct(){
		$this->_��ʼ���û���Ϣ();
	}


	private function _��ʼ���û���Ϣ(){
		$this->��������ַ = $this->_��ȡ��������ַ();
		$this->��ʶ���� = $_COOKIE['idenseq'];
		$this->���� = $_COOKIE['name'];
		if($this->��ʶ���� == ''){
			$this->��ʶ���� = $this->_�����ʶ����();
		}
		else{
			//����Ƿ��ǵ�¼�û�

		}
	}

	private function _��ȡ��������ַ(){
		$��ַ = $this->_��ȡ��������ַ�ִ�();
		return $this->_��������ַת��($��ַ);
	}

	private function _��ȡ��������ַ�ִ�(){
		$��ַ = $_SERVER['HTTP_X_FORWARDED_FOR'];
		return $��ַ != '' ? $��ַ : $_SERVER['REMOTE_ADDR'];
	}

	private function _��������ַת��($��ַ){
		if(is_int($��ַ)){
			$��ַ�ִ� = $��ַ >> 24;
			$��ַ�ִ� .= '.';
			$��ַ�ִ� .= ($��ַ & 0x00ff0000) >> 16;
			$��ַ�ִ� .= '.';
			$��ַ�ִ� .= ($��ַ & 0x0000ff00) >> 8 . '.';
			$��ַ�ִ� .= '.';
			$��ַ�ִ� .= ($��ַ & 0x000000ff);
			return $��ַ�ִ�;
		}
		else{
			$��ַ���� = explode('.', $��ַ);
			return ($��ַ����[0] << 24) + ($��ַ����[1] << 16) + ($��ַ����[2] << 8) + $��ַ����[3];
		}
	}

	private function _�����ʶ����(){



}
?>