<?php
require('db.php');

class ���ݿ������ extends ���ݿ���{
	private $���Ӷ���;

	public function ����(){
		if(!$���Ӷ���) $���Ӷ��� = new com('ADODB.Connection');
		echo("Provider=DMOLEDB; User ID='$this->�û���'; Password=$this->����; Catalog=$this->ģʽ");
		$���Ӷ���->open("Provider=DMOLEDB; User ID=$this->�û���; Password=$this->����; Catalog=$this->ģʽ");
		$�Ƿ����� = true;
	}
	
	public function ��ѯ($���){
		if(!$�Ƿ�����) this->����();
		$��� = $���Ӷ���->execute($���, $this->Ӱ������);

		var $���� = array();
		while($���->bof){
			$���� = $ֵ = array();
			for($i = 0; $i < $���->fields->count; $i++){
				array_push($����, $���->fields[$i]->name);
				array_push($ֵ, $���->fields[$i]->value);
			}
			array_push($����, array_combine($����, $ֵ));
		}

		return $����;
	}

	public function �Ͽ�(){
		$���Ӷ���->close();
		$�Ƿ����� = false;
	}

}
?>
