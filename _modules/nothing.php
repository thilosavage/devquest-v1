<?php

echo "<div id='bot-talk-content' style='border: 1px solid black; background-color: yellow; padding: 0px; margin-top: 20px; height: 338px;'>";

echo "<span style='position: absolute; top: 45px; left: 45px;'><img src='https://graph.facebook.com/".$data['bot']['fbid']."/picture?type=large'></span>";

echo "<h5 style='position: absolute; top: 44px; left: 309px;'>What do you want? Go away.</h5>";

echo "<div id='sells' style='position: absolute; top: 117px; left: 40px; width: 507px; height: 235px; background: url(".site::url."_images/hud/sell-bg.jpg); z-index: 4;'>";

echo "</div>";

echo "<span id='leave-fight' style='position: absolute; left: 644px; top: 333px; width: 126px;' class='fakelink fightCloseProcess'>Walk away</span>";

echo "</div>";

?>