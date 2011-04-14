<?php 
class Level extends Model {

	protected $table = 'level';
	protected $id_field = 'level_id';
	protected $name_field = 'name';
	protected $order_by = 'level_id DESC';

	function get_levelup($exp){

		$this->logic = 'AND';
		$this->sort_order = 'level ASC';
		$this->load(array(
			'level>'=>$_SESSION['user']['level'],
			'exp<'=>$exp
			));
		
		
		$ret['levels'] = $this->data;
		$ret['newLevel'] = $this->row['level'];
		
		return $ret;
	}
}
?>