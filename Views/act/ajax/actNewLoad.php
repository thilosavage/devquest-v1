<?php
echo "<div class='action-header'>Create New Act</div>";
$data['genre-vars'] = $genres;
$data['genre-vals'] = $genres;
echo "<div class='act-form'>";
echo inc::form('act',$data);
echo "</div>";
?>