<?php 
	/*
	* https://www.jqueryscript.net/demo/character-counter-vanilla/
	*/
?>
<style type="text/css">
    table.transliterate{
        background: #000000;
        color: #fff;
    }

    table.transliterate h3{
        background: #000000;
        color: #fff;
    }

    table.transliterate .error{
        display: block;
        color: #990000;
        font-size: 0.9em;
        float: none;
        cursor: default;
    }    

    table.transliterate .result{
        display: block;
        color: #b6e925;
        font-size: 25px;
        float: none;
        cursor: default;
        text-transform: capitalize;
    }
    table.transliterate td{
        text-align: center;
    }
    
    table.transliterate td.c-header{
        color: #b1e526;
        font-family: oswald,Sans-serif;
        font-size: 18px;
        font-weight: 700;
        text-transform: uppercase;
    }

    table.transliterate textarea{
        height: 300px;
        width: 100%;
        font-size: 18px !important;
        padding: 5px;
    }

    table.transliterate input{
        font-size: 30px !important;
        padding: 5px;
    }


</style>
<table class="transliterate">
	<tr>
		<td class="c-header"><p>Total characters: <span class="counter">0</span></p></td>
	</tr>	

	<tr>
		<td>
			<textarea class="textarea-demo" placeholder="Enter text here"></textarea>
		</td>
	</tr>	
</table>


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
