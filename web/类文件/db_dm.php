<?php
require('db.php');

class ���ݿ������ extends ���ݿ���{
	private $���Ӷ���;

	public function ����(){
		if($this->�Ƿ�����) return true;

		if(!$this->���Ӷ���) $this->���Ӷ��� = new com('ADODB.Connection');
		if($this->����Դ == ''){
			$��� = "Provider=DMOLEDB; User ID=$this->�û���; Password=$this->����; Catalog=$this->ģʽ; Data Source=127.0.0.1";
		}
		else{
			$��� = "DSN=$this->����Դ";
		}
		$this->���Ӷ���->open($���);
		$this->�Ƿ����� = true;
	}
	
	public function ��ѯ($���){
		if(!$this->�Ƿ�����) $this->����();
		echo $��� . '<hr />';
		$��� = $this->���Ӷ���->execute($���, $this->Ӱ������);
		
		//�������SELECT֮������Ͳ��÷��ؽ������
		if($���->state == 0) return $this->Ӱ������;

		$���� = array();
		while(!$���->eof){
			$���� = $ֵ = array();
			for($i = 0; $i < $���->fields->count; $i++){
				array_push($����, $���->fields[$i]->name);
				array_push($ֵ, $���->fields[$i]->value);
			}
			array_push($����, array_combine($����, $ֵ));
			$���->MoveNext();
		}

		return count($����) == 0 ? null : $����;
	}

	public function �Ͽ�(){
		$this->���Ӷ���->close();
		$this->�Ƿ����� = false;
	}

	public function ��ѯ���ת��($���){
		return str_replace("'", "''", $���);
	}

}
?>
