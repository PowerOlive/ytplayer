<?php
/**
 * @param $filepath ����ļ�·��
 * @return ����������Զ�ά������ʽ���档�����ֶ����Ʒֱ�Ϊ��Ƭʱ���ٶȣ�����
 */
function ����ļ�����($���·��){
	$content = file_get_contents(realpath($���·��));
	if ($content == '') return NULL;

	// ��񻯸�ʵķ��У���ɾ�����п���
	$content = str_replace("\r\n", "\n", $content);
	$content = str_replace("\r", "\n", $content);
	while (stripos($content, "\n\n") !== FALSE) {
		$content = str_replace("\n\n", "\n", $content);
	}

	$line = explode("\n", $content);
	$result = array();

	for ($i = 0; $i < count($line, COUNT_RECURSIVE); $i++) {
		$lineresult = lrc_analysis_line($line[$i]);
		if ($lineresult == NULL) continue;
		
		$namedresult = array('Ƭʱ' => lrc_timestr2milli($lineresult[1]),
							'����' => $lineresult[2],
							'�ٶ�' => 0
						);

		if ($lineresult !== NULL) array_push($result, $namedresult);
	}

	$result = lrc_calculate_speed($result);
	$result = lrc_delete_emptyline($result);

	return $result;
}


function lrc_analysis_line($line){
	$matches = null;

	preg_match('/\[([0-9:\.]+?)\](.+)?/mi', $line, $matches);
	if (count($matches) < 3) array_push($matches, '');
	
	if (count($matches) < 3) return NULL;

	return $matches;
}


function lrc_calculate_speed($res){
	for ($i = 0; $i < count($res) - 1; $i++) {
		$res[$i]['�ٶ�'] = $res[$i + 1]['Ƭʱ'] - $res[$i]['Ƭʱ'];
		if ($res[$i]['�ٶ�'] <= 0) $res[$i]['�ٶ�'] = 3000;
	}

	// �������һ����Ļ�����Ϊ�������ӣ�����Ͱ���Ĭ�ϵ�3��
	if ($res[$i]['����'] != '') $res[$i]['�ٶ�'] = 3000;

	return $res;
}

function lrc_timestr2milli($timestr){
	$times = explode('.', str_replace(':', '.', $timestr));

	$milli = 0;
	$jinvi = array(1, 1000, 60 * 1000, 60 * 60 * 1000);
	for ($i = count($times); $i > 0; $i--) {
		$milli += (intval($times[$i - 1]) * $jinvi[count($times) - $i]);
	}

	return $milli;
}


function lrc_delete_emptyline($res){
	$ret = array();
	for ($i = 0; $i < count($res); $i++) {
		if ($res[$i]['����'] != '') array_push($ret, $res[$i]);
	}

	return $ret;
}
?>
	