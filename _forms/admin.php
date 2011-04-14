<?php
echo form::start(site::url.'admin/index');
echo "Username: ".form::input('name', '')."<br>";
echo "Password: ".form::input('pass', '')."<br>";
echo form::submit('submit','login');
echo "</form>";
?>