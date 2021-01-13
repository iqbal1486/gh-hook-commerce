<main>
   <div data-component=pretty-print data-on-load=app.setup class=flex-columns>
      <div>
         <h3>JSON input:</h3>
         <textarea data-smart-update=app.processJson rows="5" placeholder="Enter some JSON" autofocus></textarea>
         <p id=error-message></p>
      </div>
      <br />
      <br />
      <div>
         <h3>Output:</h3>
         <pre><output></output></pre>
         <i data-icon=copy data-click=app.copyToClipboard></i><br />
         <label><input type=checkbox data-change=app.processJson>Quote map keys</label>

      </div>
   </div>
</main>




<script src=https://cdn.jsdelivr.net/npm/jquery@3.5/dist/jquery.min.js></script>
<script src=https://cdn.jsdelivr.net/npm/dna.js@1.7/dist/dna.min.js></script>
<script src=https://cdn.jsdelivr.net/npm/web-ignition@1.3/dist/library.min.js></script>
<script src=https://cdn.jsdelivr.net/npm/pretty-print-json@0.4/dist/pretty-print-json.js></script>
<script>
   const app = {
      processJson(target, event, component) {
         const elem = {
            textarea: component.find('textarea'),
            message:  component.find('#error-message').fadeOut(),
            output:   component.find('output'),
            checkbox: component.find('input[type=checkbox]'),
            };
         try {
            const data = elem.textarea.val().trim().length ? JSON.parse(elem.textarea.val()) : null;
            const options = { quoteKeys: elem.checkbox.is(':checked') };
            const html = data ? prettyPrintJson.toHtml(data, options) : '[EMPTY]';
            elem.output.html(html);
            }
         catch(e) {
            elem.message.text('Invalid JSON').finish().fadeIn();
            }
         },
      copyToClipboard(icon, event, component) {
         const output =    component.find('output');
         const selection = window.getSelection();
         const range =     document.createRange();
         library.animate.jiggleIt(icon);
         range.selectNode(output[0]);
         selection.empty();
         selection.addRange(range);
         document.execCommand('copy');
         },
      setup(component) {
         const intro = {
            message: 'Put some JSON in the text box.',
            error:   null,
            year:    new Date().getFullYear(),
            ios:     library.browser.iOS(),
            space:   '🪐🚀✨',
            fancy:   'https://json5.org/?' + Date.now() % 20,
            };
         component.find('textarea').val(JSON.stringify(intro)).trigger('change');
         $('.version-number').text(prettyPrintJson.version);
         },
      };
</script>
