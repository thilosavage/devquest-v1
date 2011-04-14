<?php
echo form::start(site::url.'login/process');
echo "Username: ".form::input('name', '')."<br>";
echo "Password: ".form::input('password', '')."<br>";
echo form::submit('submit','login');
echo "</form>";
?>