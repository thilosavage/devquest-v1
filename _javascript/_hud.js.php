<script>


function hudHpCalculate(hp) {

	
		if (hp > 0) {
			$('.me_hp').animate({'width':hp},200);
		}
		else {
			$('.me_hp').css('width',hp);
		}	
		
		if (hp < 326) {
			$('.me_hp').css('background-color','red');
		}
		else if (hp < 110) {
			$('.me_hp').css('background-color','yellow');
				
		}
		else {
			$('.me_hp').css('background-color','green');
		}
}


function hudRamCalculate(ram) {

	
		if (ram > 0) {
			$('.me_ram').animate({'width':ram},200);
		}
		else {
			$('.me_ram').css('width',ram);
		}	
		
		if (ram < 326) {
			$('.me_ram').css('background-color','red');
		}
		else if (ram < 110) {
			$('.me_ram').css('background-color','yellow');
				
		}
		else {
			$('.me_ram').css('background-color','green');
		}
}



function hudExpCalculate(exp) {

	
		if (exp > 0) {
			$('.me_exp').animate({'width':exp},200);
		}
		else {
			$('.me_exp').css('width',exp);
		}	
		
		if (exp < 326) {
			$('.me_exp').css('background-color','red');
		}
		else if (exp < 110) {
			$('.me_exp').css('background-color','yellow');
				
		}
		else {
			$('.me_exp').css('background-color','green');
		}
}



</script>