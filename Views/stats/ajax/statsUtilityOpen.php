<?php

$utility = "<h3>Stats</h3>";
$utility .= "Exp: ".$user['exp']."<br>";
$utility .= "Level: ".$user['level']."<br>";

$attribs = array('speed','charisma','awareness','hacking','wisdom','max_hp');


foreach ($attribs as $attrib) {
	$name = ucwords(str_replace('_','',$attrib));
	$utility .= $name.": ".$user[$attrib]."<br>";
}

$utility .= "<table style='border: solid 1px black;'><tr><td valign='top'>";

$utility .= "<h3>Skills</h3>";
$utility .= "<table border='1' cellpadding='8' cellspacing='0'>";
if ($skills) {
	foreach ($skills as $skill) {
		$utility .= "<tr>";
		$utility .= "<td><img src='".site::url."_images/skills/".$skill['skill_id'].".png'></td>";
		$utility .= "<td>".$skill['ability']." at ".$skill['name']."</td>";
		$utility .= "</tr>";
	}
}
$utility .= "</table>";

$utility .= "</td><td valign='top'>";

$utility .= "<h3>Software</h3>";
$utility .= "<table border='1' cellpadding='8' cellspacing='0'>";
if ($softwares) {
	foreach ($softwares as $software) {
		$utility .= "<tr>";
		$utility .= "<td><img src='".site::url."_images/software/".$software['software_id'].".png'></td>";
		$utility .= "<td>".$software['name']." Version ".$software['version']."</td>";
		$utility .= "</tr>";
	}
}
$utility .= "</table>";

$utility .= "</td></tr></table>";

$data['utility'] = $utility;

$data['ram'] = $user['ram'];
$data['max_ram'] = $user['max_ram'];
$data['hp'] = $user['hp'];
$data['max_hp'] = $user['max_hp'];


echo json_encode($data);
?>