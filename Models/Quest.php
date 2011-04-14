<?php 
class Quest extends Model {

	protected $table = 'quest';
	protected $id_field = 'quest_id';
	protected $name_field = 'name';
	protected $order_by = 'quest_id DESC';

}
?>