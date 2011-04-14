<?php 
class Loc extends Model {

	protected $table = 'loc';
	protected $id_field = 'loc_id';
	protected $name_field = 'name';
	protected $order_by = 'loc_id DESC';
	
	var $loc_id = '';
	var $oldX = '';
	var $oldY = '';
	var $newX = '';
	var $newY = '';
	
	var $lastLoc = '';
	var $newLoc = '';
	var $loctype = '';
	var $level = '';
	

	

	function get_next_loc($loc_id,$bearing){
	
		$this->clear();
		$this->load($loc_id);

		$this->oldX = $this->row['x'];
		$this->oldY = $this->row['y'];	
	
		$this->newX = $this->oldX;
		$this->newY = $this->oldY;

		
		if ($bearing == 'n'){
			$this->newY = $this->newY -1;
		}
		if ($bearing == 's'){
			$this->newY = $this->newY + 1;
		}
		if ($bearing == 'e'){
			$this->newX = $this->newX + 1;
		}
		if ($bearing == 'w'){
			$this->newX = $this->newX - 1;
		}

		$this->clear();
		
		$this->logic = 'AND';
		$this->load(array('x'=>$this->newX,'y'=>$this->newY));

		
		if ($this->row){
			return $this->row;
		}
		else {
			return null;
		}
		
	}

	function get_right_loc($loc_id,$bearing){
	
		$this->clear();
		$this->load($loc_id);

		$this->oldX = $this->row['x'];
		$this->oldY = $this->row['y'];	

		$this->newX = $this->oldX;
		$this->newY = $this->oldY;
		
		
		if ($bearing == 'n'){
			$this->newX = $this->newX + 1;
		}
		if ($bearing == 's'){
			$this->newX = $this->newX - 1;
		}
		if ($bearing == 'e'){
			$this->newY = $this->newY + 1;
		}
		if ($bearing == 'w'){
			$this->newY = $this->newY - 1;
		}

		$this->clear();
		
		$this->logic = 'AND';
		$this->load(array('x'=>$this->newX,'y'=>$this->newY));

		
		if ($this->row){
			return true;
			//return $this->row;
		}
		else {
			return null;
		}
		
	}

	function get_left_loc($loc_id,$bearing){
	
		$this->clear();
		$this->load($loc_id);

		$this->oldX = $this->row['x'];
		$this->oldY = $this->row['y'];	

		$this->newX = $this->oldX;
		$this->newY = $this->oldY;
		
		
		if ($bearing == 'n'){
			$this->newX = $this->newX - 1;
		}
		if ($bearing == 's'){
			$this->newX = $this->newX + 1;
		}
		if ($bearing == 'e'){
			$this->newY = $this->newY - 1;
		}
		if ($bearing == 'w'){
			$this->newY = $this->newY + 1;
		}

		$this->clear();
		
		$this->logic = 'AND';
		$this->load(array('x'=>$this->newX,'y'=>$this->newY));

		
		if ($this->row){
			return true;
			//return $this->row;
		}
		else {
			return null;
		}
		
	}


	

	function get_this_loc($loc_id,$bearing){
	
		$this->clear();
		$this->load($loc_id);
		
		$this->oldX = $this->row['x'];
		$this->oldY = $this->row['y'];	
	
		$this->newX = $this->oldX;
		$this->newY = $this->oldY;

		
		if ($bearing == 'n'){
			$this->newY = $this->newY -1;
		}
		if ($bearing == 's'){
			$this->newY = $this->newY + 1;
		}
		if ($bearing == 'e'){
			$this->newX = $this->newX + 1;
		}
		if ($bearing == 'w'){
			$this->newX = $this->newX - 1;
		}

		$this->clear();
		$this->logic = 'AND';
		$this->load(array('x'=>$this->newX,'y'=>$this->newY));
	
		
		if ($this->row){
			return $this->row;
		}
		else {
			return null;
		}
		
	}
	
	
	

	function generateMap($level){
		
		if ($level) {
			$this->load(array(
			'loc_id>'=>'0',
			'level<'=>$level
			));
		}
		else {
			$this->load(array('loc_id>'=>'0'));
		}
		
		
		//echo $this->query;
		foreach ($this->data as $loc){
			$coordsX = $loc['x'];
			$coordsY = $loc['y'];
			
			$xs[$coordsX][$coordsY] = $loc;
		}
		
		return $xs;
	}	
	
	
	
	function map(){
		
		$this->load(array('loc_id>'=>'0'));
		
		foreach ($this->data as $loc){
			$coordsX = $loc['x'];
			$coordsY = $loc['y'];
			
			$xs[$coordsX][$coordsY] = $loc;
		}
		
		
		$ret .=  "<table>";
		for ($y=1;$y<=8;$y++) {
		
			$ret .=  "<tr>";
			
			for ($x=1;$x<=17;$x++) {
				if ($xs[$x][$y]['name']) {
					$ret .=  "<td style='font-size: 8px; width: 25px; height: 25px; padding: 4px; border: 1px solid black;' class='locEditOpen' x=".$x." y=".$y." loc_id='".$xs[$x][$y]['loc_id']."'>";
					$ret .=  "<div '>";
					$ret .=  substr($xs[$x][$y]['name'],0,8);
					$ret .=  "</div>";
					$ret .=  "</td>";
				}
				else {
					$ret .=  "<td style='font-size: 8px; width: 25px; height: 25px; padding: 4px; border: 0px solid #222222;' class='locEditOpen' x=".$x." y=".$y." loc_id='".$xs[$x][$y]['loc_id']."'>";
					$ret .=  "<div '>";
					
					$ret .=  "</div>";
					$ret .=  "</td>";
				}
				
			
			}
			$ret .=  "</tr>";
		}
		$ret .=  "</table>";
		
		return $ret;
	}	
}
?>