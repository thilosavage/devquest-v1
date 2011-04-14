<?php 
class Store extends Model {

	protected $table = 'store';
	protected $id_field = 'store_id';
	protected $name_field = 'name';
	protected $order_by = 'store_id DESC';

}
?>