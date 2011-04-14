<?php 
class History extends Model {

	protected $table = 'history';
	protected $id_field = 'history_id';
	protected $name_field = 'history';
	protected $order_by = 'history_id DESC';
	
	function entry($entry, $time){
	
		$this->set['user_id'] = $_SESSION['user']['user_id'];
		$this->set['entry'] = $entry;
		$this->set['time'] = $time;
		$this->save();
		
	}
}
?>