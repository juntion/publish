<?php
/**
 * 
 * @param string $sql
 * @param string $columns like array('products_id','products_name')
 * @replaces array like array(0=>array('target'=>':products_id:','replacement'=>'80002','type'=>'integer'))
 * @return array $returns like array(0=>array(1,'aaa'),1=>array(2,'bbb'))
 */
function zen_get_data_from_db($sql,$columns,$replaces=array()){
	global $db;
	
	$returns = array();
	//replace variable in $sql
	if (sizeof($replaces)) {
		foreach ($replaces as $i => $field){
			$sql = $db->bindVars($sql, (string)$field['target'], $field['replacement'], $field['type']);
		}
	}
	
	$result = $db->Execute($sql);	
	if ($result->RecordCount()) {
		while (!$result->EOF) {
			$temp = array();
			foreach ($columns as $column){
				$temp [] = $result->fields[$column] ;
			}
			$returns [] = $temp;
			$result->MoveNext();
		}
	}
	return $returns;
}