<?php
require('db.php');

class ���ݿ������ extends ���ݿ���{
	private $���Ӷ���;

	public function ����(){
		if($this->�Ƿ�����) return true;

		mysql_connect('localhost', $this->�û���, $this->����);
		mysql_select_db($this->ģʽ);
		
		$this->�Ƿ����� = true;
	}
	
	public function ��ѯ($���){
		if(!$this->�Ƿ�����) $this->����();

		$��� = mysql_query($���) or die(mysql_error() . "<strong>$���</strong>");
		$this->Ӱ������ = @mysql_affected_rows($���);
		
		//�������SELECT֮������Ͳ��÷��ؽ������
		if($this->Ӱ������ > 0 && mysql_num_rows($���) == 0) return $this->Ӱ������;

		$���� = array();
		while($���н�� = mysql_fetch_array($���)){
			array_push($����, $���н��);
		}

		return count($����) == 0 ? null : $����;
	}

	public function �Ͽ�(){
		mysql_close();
		$this->�Ƿ����� = false;
	}

	public function ��ѯ���ת��($���){
		return str_replace("'", "''", $���);
	}

}
?>
