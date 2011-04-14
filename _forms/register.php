Create a new character

<?php

if ($message){
	echo $message;
}

echo form::start(site::url.'register/process');
echo "Username: ".form::input('name', '')."<br>";
echo "Password: ".form::input('password', '')."<br>";
echo form::submit('submit','register');
echo "</form>";
?>