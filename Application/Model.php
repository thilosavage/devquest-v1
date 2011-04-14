<?php
abstract class Model {
	protected $id;
	protected $table;
	protected $id_field;
	protected $name_field;
	protected $order_by;
	
	var $values = '';
	var $field = '';
	var $logic = '';
	var $limit = '';
	var $sort_order = '';
	var $use_id_values = true;

	public $set = array();
	public $data = array();
	public $row = array();
	public $query = '';
	
	function __construct($values='', $id_field = ''){
		
		if ($values){
			if ($values == 'all') {
				$this->values = array($this->id_field.'>'=>'0');
			}
			else if (is_array($values)){
				$this->values = $values;
			}
			else {
				$args = func_get_args();
				foreach ($args as $arg){
					$vals[] = $arg;
				}
				$this->values = $vals;
			}
			if ($id_field) {
				$this->id_field = $id_field;
			}
			$this->load();
		}
	}
	
	function load($values = '', $query = ''){
		
		if ($values){
			if (is_array($values)){
				$this->values = $values;
			}
			else {
				$args = func_get_args();
				foreach ($args as $arg){
					$args[] = $arg;
				}
				$this->values = $args;
			}
		}
		
		$database = database::db();
		$query = $this->query?$this->query:$this->build();
		$q = $database->query($query);
		//echo mysql_error();
		while ($row = @mysql_fetch_assoc($q)){
			$row_id = $row[$this->id_field];
			
			if ($this->custom_id) {
				$customId = $row[$this->custom_id];
				$this->data[$customId] = $row;
			}
			else if ($this->use_id_values) {
				$this->data[$row_id] = $row;
			}
			else {
				$this->data[] = $row;
			}
		}
		
		//if (count($this->data) == 1){
		if ($this->data) {
			foreach ($this->data as $data){
				$this->row = $data;
			}
		}
	}
	
	/*
	WORK IN PROGRESS
	
	function random($number,$row = '') {
		$database = database::db();
		$q = $database->query('SELECT `'.$this->esc($).'` FROM table ORDER BY RAND() LIMIT 5');
		while ($row = mysql_fetch_assoc($q)){
			$row_id = $row[$this->id_field];
			$this->data[$row_id] = $row;
		}	
		
	
	}
	*/
	function custom($query){
		
		$database = database::db();
	
		$args = func_get_args();
		
		if (count($args) > 1){
			unset($args[0]);
			
			$sprintfStr = '$escapedQuery = sprintf("'.$query.'", ';
			$i = 1;
			foreach ($args as $arg){
				
				if (count($args) !== $i){
					$sprintfStr .= $arg.', ';
				}
				else {
					$sprintfStr .= $arg.');';
				}
				$i++;
			}
			
			eval($sprintfStr);
			
			$this->query = $escapedQuery;
		}
		else {

			//$q = $database->query($query);
			$this->query = $query;
		}
		
		//echo $this->query;
		$this->load();
	
	}
	
	
	function build(){
		if (!$this->logic && is_array($this->values)){
			$this->logic = 'OR';
			while (list($fieldName,$fieldValue) = each($this->values)){
				if (!is_numeric($fieldName)){
					$this->logic = 'AND';
				}
				$oldField = $fieldName;
			}
		}
		
		$defaultField = $this->field ? $this->field : $this->id_field;
		if (is_array($this->values)){
			$coun = count($this->values) - 1;
			foreach ($this->values as $key => $value){
				$field = $this->esc(!is_numeric($key)?$key:$defaultField);
				$qe .= $this->esc($field)."='".$this->esc($value)."'";
				if ($coun>0) {
					$qe .= ' '.$this->esc($this->logic).' ';
				}
				$coun = $coun - 1;
			}
			$q = "SELECT * FROM `".$this->esc($this->table)."` WHERE ".$qe;
		}
		else {
			$value = $this->esc($this->values);
			$field = $this->esc($defaultField);
			$q = "SELECT * FROM `".$this->table."` WHERE ".$defaultField." = ".$value;
		}
		if ($this->sort_order){
			$q .= ' ORDER BY '.$this->esc($this->sort_order);
		}
		else {
			$q .= ' ORDER BY '.$this->esc($this->order_by);
		}
		
		
		if ($this->limit){
			$q .= ' LIMIT '.$this->limit;
		}
		
		$this->query = site::debug?$q:'';
		return $q;
	}	
	
	
	function save(){
		if ($this->set[$this->id_field]) {
			$this->update();
			return $this->set[$this->id_field];
		}
		else {
			$this->insert();
			return mysql_insert_id();
		}
	}
	function insert() {
		$database = database::db();
		$insert = 'INSERT INTO `'.$this->esc($this->table).'` SET '.$this->_fields();
		$database->query($insert);
		
		$this->query = $insert;
		
		return $ret;
	}
	function update() {
		$database = database::db();
		$update .= 'UPDATE `'.$this->table.'` SET '.$this->_fields();
		$update .= sprintf(' WHERE '.$this->esc($this->id_field).'=%s', $this->esc($this->set[$this->id_field]));
		$database->query($update);
		
		$this->query = $update;
		
		return $ret;
	}
	function _fields(){

		while (list ($fieldName, $fieldValue) = each($this->set)) {
			
			if (!is_numeric($fieldName)){
			
				if (!strcmp($fieldName, $this->id_field)) {
					continue;
				}
				if ($fields) {
					$fields .= ', ';
				}
				$fields .= sprintf('`'.$this->esc($fieldName).'`=\'%s\'', $this->esc($fieldValue));
			}
		}
		return $fields;
	}
	
	
	function esc($val) {
		return mysql_real_escape_string($val);
	}
	
	function delete($value='') {
		$database = database::db();
		$value = $value?$value:$this->set[$this->id_field];
		$q = sprintf('DELETE FROM '.$this->esc($this->table).' WHERE `'.$this->esc($this->id_field).'`=%s',$this->esc($value));
		$database->query($q);
	}
	
	function getFields() {
		$database = database::db();
		$res = $database->query('SHOW COLUMNS FROM '.$this->table);
		$fields = array ();
		while ($row = @ mysql_fetch_object($res)) {
			$fields[$row->Field] = $row->Type;
		}
		mysql_free_result($res);
		return $fields;
	}
	
	function getAll(){
		$this->values = array($this->id_field.'>'=>'0');
		$this->load();
		return $this->data;
	}
	
	function scaffoldInfo($id) {
		$this->load($id);
		return $this->data;
	}

	function truncate(){
		$database = database::db();
		$database->query('TRUNCATE TABLE `blurbys`');
	}
	
	function clean(){

	}
	function rowHandler($array){
		return $array;
	}
	
	function clear(){
		
		$this->row = null;
		$this->data = null;
		$this->query = '';
		$this->values = null;
		$this->set = null;
		
	}
}
?>