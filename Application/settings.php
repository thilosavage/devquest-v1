<?php

class settings {

	const initial_home = 2;
	const initial_bearing = 'n';
	const initial_money = .10;
	const initial_max_energy = 15;
	const initial_max_battery = 15;
	const initial_max_hp = 37;
	const initial_max_ram = 15;
	
	
	// store settings
	
	// the number of potentially repeated
	// items -
	// 0 will have no dupes
	// 1 will have about 1/2 items duped
	// 2 will have about 1/3 items duped
	const store_item_dupes = 2;
	
	// 1 will yield all items
	// 2 will yield half
	// 3 will yield 33%, etc
	const store_item_probability = 3;

	// percent of an items value to resell
	const store_resell_percentage = .6;
	
	
	static $attribs = array('speed','charisma','efficiency','hacking','wisdom','max_hp','max_ram');
	static $stattribs = array('speed','wisdom','hacking','exp','efficiency');
	
	
}

?>