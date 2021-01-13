<?php 
	/*
	* https://www.jqueryscript.net/demo/character-counter-vanilla/
	*/
?>

<p>Total characters: <span class="counter">0</span></p>

<textarea class="textarea-demo" placeholder="Enter text here">
</textarea>

<script type="text/javascript">
	let getInput = jQuery('textarea');
	const getspan = jQuery('span');

	function calculate() {
	  let innerInput 	= getInput[0].value;
	  let calc 			= innerInput.length;
	  getspan.text(calc);
	  }

	getInput.on('input', calculate);	
</script>
