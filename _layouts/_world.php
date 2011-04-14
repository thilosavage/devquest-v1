<?php inc::js('jquery.js','_library/',false);?>
<?php inc::js();?>
<?php inc::css();?>
<html>
<body>
<div style='text-align: center;'>
	<div id='world'>
		<div id='loc'>
			<div style='position: absolute; width: 720px; height: 400px;'>
				<div id='bg' style='position: absolute; width: 20px; top: 40px;'>
					<img style='position: absolute; top: 0px; left: 0px;' id='background'>


				</div>
			</div>
			<div id='hud'>
				<div id='hud-top'>
				
				
					<div id='me'>
					
						<span id='hud-level'><span style='font-size: 9px;'></span><span id='level'><?php echo $level;?></span></span>
						
						<?php
						echo "<div style='background-color: black; position: absolute; border: black solid 3px;' bot_id='me'>";
						?>
							
						<?php

							echo "<span style='position: absolute; text-align: center;'><img src='https://graph.facebook.com/".$_SESSION['user']['fbid']."/picture?type=square'></span>";
							//echo "<span style='background-color: gray; color: white; font-size: 12px; padding: 2px; position: absolute; top: 88px;'>";
							//echo $_SESSION['user']['name'];
							//echo "</span><br>";

							//echo "<span style='background-color: gray; color: yellow; padding: 5px; position: absolute; top: 3px; left: 80px; '></span>";
						echo "</div>";
						?>
						
					</div>				
				
				
					<!--
					<span id='hud-name'><span id='name'><?php echo $_SESSION['user']['fbid'];?></span></span>
					-->
					
					<span id='hud-money'>$<span id='money'><?php echo $money;?></span></span>
					<span id='hud-exp'>Exp:<span id='exp'><?php echo $exp;?></span></span>
					
					
					<span id='hud-ram'>RAM:<span id='ram'><?php echo $ram;?></span>/<span id='max_ram'><?php echo $max_ram;?></span></span>
					
					<!--
					<span id='hud-hp'>HP:<span id='hp'><?php echo $hp;?></span>/<span id='max_hp'><?php echo $max_hp;?></span></span>
					-->
					
					<div id='hud-hp-bar'  style='position: absolute; z-index: 20;'>
						<span class='me_max_hp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: black;'></span>
						<span class='me_hp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: green;'></span>
					</div>
					
					<div id='hud-ram-bar'  style='position: absolute; z-index: 20;'>
						<span class='me_max_ram' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: black;'></span>
						<span class='me_ram' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: purple;'></span>
					</div>

					<div id='hud-exp-bar'  style='position: absolute; z-index: 20;'>
						<span class='me_max_exp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: black;'></span>
						<span class='me_exp' style='position: absolute; top: 0px; left: 0px; height: 6px; width: 608px; background-color: #99ccff;'></span>
					</div>					
					
					
					<span id='hud-logout' class='worldLogoutProcess fakelink'>Log out</span>
					
					
				</div>
			</div>
			<div id='panel'>
				<div id='bots'></div>
			</div>

			<div id='skills' style='display: none;'>
				<?php echo inc::module('weapons', $data);?>
			</div>
				
			<div id='action' style='padding: 5px 30px 30px; margin: 0px; z-index: 3;'>	
			
			<div id='zname' style='padding: 5px; background-color: blue; color: white; border: 1px solid black;'></div>
			<div id='desc' style='border: 1px solid black;'></div>
			
			<div id='message' style='border: 1px solid black;'></div>
			<div id='bot-talk'>

			</div>
			<div id='gig'></div>
			<div id='job'></div>
			<div id='store'></div>			
			
			
		</div>


			
		<div id='status' style='position: absolute; top: 400px;'></div>
		

		<div id='tools'>
			
			<span d="l" class="fakelink worldTurnProcess" id="turn-l"><img src='<?php echo site::url;?>_images/hud/left.png'></span>
			<span d="n" id="mover-forward" class="fakelink worldMoverProcess"><img src='<?php echo site::url;?>_images/hud/move_blur.png'></span>
			<span d="r" class="fakelink worldTurnProcess" id="turn-r"><img src='<?php echo site::url;?>_images/hud/right.png'></span>

			<span id='bag'><span class='fakelink bagUtilityOpen'><img src='<?php echo site::url;?>_images/hud/tools_04.png'></span></span>
			<span id='minimap'><span class='fakelink mapUtilityOpen'><img src='<?php echo site::url;?>_images/hud/tools_05.png'></span></span>
			<span id='stats'><span class='fakelink statsUtilityOpen'><img src='<?php echo site::url;?>_images/hud/tools_06.png'></span></span>
			

			<span id='stats'><span class='fakelink pcUtilityOpen'><img src='<?php echo site::url;?>_images/hud/pc.png'></span></span>
			
			<div id='utility-contents'></div>
		
		</div>
		
	</div>
</div>
<div id='fb-root'></div>

<?php $this->render_view(); ?>
</body>
</html>

<span id='store' class='storeWindowOpen fakelink'></span>