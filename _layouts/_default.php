<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<?php inc::js('jquery.js','_library/',false);?>
<?php inc::js();?>
</head>
<body>

<div id="fb-root"></div>

<div id='login-error'></div>

<?php
echo "<p>".$_SESSION['message']."</p>";
?>
<?php $this->render_view(); ?>
</body>
</html>