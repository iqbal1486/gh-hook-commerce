<?php 
	/*
		https://developers.google.com/transliterate/v1/getting_started#transliterationControl
		AMHARIC
		ARABIC
		BENGALI
		CHINESE
		GREEK
		GUJARATI
		HINDI
		KANNADA
		MALAYALAM
		MARATHI
		NEPALI
		ORIYA
		PERSIAN
		PUNJABI
		RUSSIAN
		SANSKRIT
		SERBIAN
		SINHALESE
		TAMIL
		TELUGU
		TIGRINYA
		URDU
	*/
	$language = $a['language'];
?>
<script type="text/javascript" src="<?php echo WPGP_PLUGIN_URL . 'assets/js/transliterate.js' ?>"></script>
<script type="text/javascript">
    // Load the Google Transliterate API
    google.load("elements", "1", {
          packages: "transliteration"
        });
    
    function onLoad() {
      var options = {
          sourceLanguage:
              google.elements.transliteration.LanguageCode.ENGLISH,
          destinationLanguage:
              [google.elements.transliteration.LanguageCode.<?php echo $language; ?>],
          shortcutKey: 'ctrl+g',
          transliterationEnabled: true
      };
    
      // Create an instance on TransliterationControl with the required
      // options.
      var control =
          new google.elements.transliteration.TransliterationControl(options);
    
      // Enable transliteration in the textbox with id
      // 'transliterateTextarea'.
      control.makeTransliteratable(['textarea_data']);
    control.c.qc.t13n.c[3].c.d.keyup[0].ia.F.p = 'https://www.google.com';
    }
    google.setOnLoadCallback(onLoad);
    
    
</script> 
<style type="text/css">
	table.transliterate{
		background: #000000;
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
    	font-size: 30px !important;
    	padding: 5px;
	}
	
	table.transliterate .charCountNoSpace,  table.transliterate .totalChars,  table.transliterate .wordCount{
		color: #b6e925;
	    font-size: 12px;
	    text-transform: uppercase;
	    letter-spacing: 1px;
	    font-weight: 700;
	}

    table.transliterate .button{
	    border-style: solid;
	    border-top-width: 2px;
	    border-right-width: 2px;
	    border-left-width: 2px;
	    border-bottom-width: 2px;
	    color: #ffffff;
	    border-color: #ffffff;
	    background-color: rgba(0,0,0,0);
	    border-radius: 0;
	    padding-top: 14px;
	    padding-right: 38px;
	    padding-bottom: 14px;
	    padding-left: 38px;
	    font-family: 'Oswald',sans-serif;
	    font-weight: 800;
	    font-size: 14px;
	    font-size: 0.875rem;
	    line-height: 1;
	    text-transform: uppercase;
	    letter-spacing: 2px;
	    width: 100%;
	}

	table.transliterate .button, table.transliterate .button:visited {
	    color: #ffffff;
	}

	table.transliterate .button:hover, table.transliterate .button:focus {
	    color: #0f0f0f;
	    background-color: #ffffff;
	    border-color: #ffffff;
	}

</style>
<div class="item-page">
    <div id="container">
        <table class="transliterate">
            <tbody>
                <tr>
                    <td colspan="6" class="c-header">Type in English and Press SpaceBar to get in <?php echo $language; ?></td>
                </tr>
                <tr>
                    <td colspan="2" class="wordCount">Total Words: <span id="wordCount">0</span></td>
                    <td colspan="2" class="totalChars">Total Characters: <span id="totalChars">0</span></td>
                    <td colspan="2" class="charCountNoSpace"><span>Character:<br><span style="text-transform:lowercase">(Excluding Space)</span></span> <span id="charCountNoSpace" style="position: absolute;margin-top: -22px;">0</span></td>
                </tr>
                <tr>
                    <td colspan="6">
                        <form id="etoh">
                            <textarea id="textarea_data" class="js-copytextarea" name="textarea_data" autofocus="" placeholder="Start Typing in English Here ..."></textarea>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button class="button textarea_data_copybtn">Copy</button>
                    </td>    
                    <td colspan="2">
                    	<button class="button" name="print" onClick="print_textarea_data();" type="button" value="print">Print</button>
                    </td>
                    <td colspan="2">
                    	<input class="button" type="button" onClick="reset_textarea_data();" value="Reset" />
                    </td>
                </tr>

                <tr>
                    <td colspan="3">
                        <button onClick="save_as_text_file();" class="button" >Save as Text File</button>
                    </td>    
                    <td colspan="3">
                        <button onClick="save_as_doc_file();" class="button" >Save as Doc File</button>
					</td>	                        
                </tr>

            </tbody>
        </table>
    </div>
    <script type="text/javascript">

        function print_textarea_data() {
		    childWindow = window.open('', 'childWindow', 'location=yes, menubar=yes, toolbar=yes');
		    childWindow.document.open();
		    childWindow.document.write('<html><head></head><body>');
		    childWindow.document.write(document.getElementById('textarea_data').value.replace(/\n/gi, '<br>'));
		    childWindow.document.write('</body></html>');
		    childWindow.print();
		    childWindow.document.close();
		    childWindow.close();
		}

		function textarea_data_processing_init(idarray) {
		    for (var i = 0; i < idarray.length; i++) {
		        var el = document.getElementById(idarray[i])
		        if (!/(text)/.test(el.type)) //skip to next element if it isn't a input type="text" or textarea element
		            continue
		        if (el.addBehavior && !window.sessionStorage) { //use IE behaviors to store info?
		            el.style.behavior = 'url(#default#userData)'
		            el.load("userentereddata")
		        }
		        var persisteddata = (window.sessionStorage) ? sessionStorage[idarray[i] + 'textarea_data'] : (el.addBehavior) ? el.getAttribute('dataattr') : null
		        if (persisteddata) //if rescued textarea_data found for this element
		            el.value = persisteddata
		        el.onkeyup = function() {
		            if (window.sessionStorage)
		                sessionStorage[this.id + 'textarea_data'] = this.value
		            else if (this.addBehavior) {
		                this.setAttribute("dataattr", this.value)
		                this.save("userentereddata")
		            }
		        } //onkeyup
		    } //for loop
		}

		function reset_textarea_data() {
		    document.getElementById("etoh").reset();
		    document.getElementById("textarea_data").focus();
		    document.getElementById('charCountNoSpace').innerHTML = 0;
		    document.getElementById('wordCount').innerHTML = 0;
		    document.getElementById('totalChars').innerHTML = 0;
		}

		function save_as_text_file() {
		    var textToSave = document.getElementById("textarea_data").value;

		    textToSave += "\r\n";
		    textToSave += "\r\n";
		    var about_link = 'This content is downloaded from - ';
		    about_link += "\r\n";
		    about_link = about_link + 'http://geekerhub.com/';
		    textToSave = textToSave + about_link;

		    var textToSaveAsBlob = new Blob([textToSave], {
		        type: "text/plain"
		    });
		    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);

		    var fileNameToSaveAs = "indiatyping.txt";

		    var downloadLink = document.createElement("a");
		    downloadLink.download = fileNameToSaveAs;
		    downloadLink.innerHTML = "Download File";
		    downloadLink.href = textToSaveAsURL;
		    downloadLink.onclick = destroyClickedElement;
		    downloadLink.style.display = "none";
		    document.body.appendChild(downloadLink);

		    downloadLink.click();
		}

		// for save as doc file

		function save_as_doc_file() {
		    var textToSave = document.getElementById("textarea_data").value;
		    textToSave += "\r\n";
		    textToSave += "\r\n";
		    var about_link = 'This content is downloaded from - ';
		    about_link += "\r\n";
		    about_link = about_link + 'http://geekerhub.com/';
		    textToSave = textToSave + about_link;
		    var textToSaveAsBlob = new Blob([textToSave], {
		        type: "text/Doc"
		    });
		    var textToSaveAsURL = window.URL.createObjectURL(textToSaveAsBlob);

		    var fileNameToSaveAs = "indiatyping.doc";

		    var downloadLink = document.createElement("a");
		    downloadLink.download = fileNameToSaveAs;
		    downloadLink.innerHTML = "Download File";
		    downloadLink.href = textToSaveAsURL;
		    downloadLink.onclick = destroyClickedElement;
		    downloadLink.style.display = "none";
		    document.body.appendChild(downloadLink);

		    downloadLink.click();
		}


		function destroyClickedElement(event) {
		    document.body.removeChild(event.target);
		}

		// for copy text 
		var copy_textarea_data_btn = document.querySelector('.textarea_data_copybtn');

		copy_textarea_data_btn.addEventListener('click', function(event) {
		    var copyTextarea = document.querySelector('.js-copytextarea');
		    copyTextarea.select();

		    try {
		        var successful = document.execCommand('copy');
		        var msg = successful ? 'successful' : 'unsuccessful';
		    } catch (err) {
		        console.log('Oops, unable to copy');
		    }
		});

		data_counter = function() {
		    var value = document.getElementById('textarea_data').value;
		    if (value.length == 0) {
		        document.getElementById('wordCount').innerHTML = 0;
		        document.getElementById('totalChars').innerHTML = 0;

		        document.getElementById('charCountNoSpace').innerHTML = 0;

		        return;
		    }

		    var regex = /\s+/gi;
		    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
		    var totalChars = value.length;
		    var charCount = value.trim().length;
		    var charCountNoSpace = value.replace(regex, '').length;
		    document.getElementById('charCountNoSpace').innerHTML = charCountNoSpace;
		    document.getElementById('wordCount').innerHTML = wordCount;
		    document.getElementById('totalChars').innerHTML = totalChars;
		};

		function dataLoaded() {
		    function init() {
		        if (localStorage["textarea_data"]) {
		            document.getElementById('textarea_data').value = localStorage["textarea_data"];
		            data_counter();
		        }
		    }
		    init();
		    textarea_data.addEventListener('keypress', data_counter);
		}

        function send_textarea_data() {
		    localStorage[document.getElementById('textarea_data').getAttribute('name')] = document.getElementById('textarea_data').value;
		}

		textarea_data_processing_init(['textarea_data'])
		dataLoaded();
		textarea_data.addEventListener('keyup', send_textarea_data);
    </script>
</div>
