var currentRequest = null;    

var conversion_callback = function(){
	
	var currencyAmountValue 	= jQuery('#fiatAmount').val();	
	var currencyCodeValue 		= jQuery('#fiatCurrency').val();	
	var cryptocurrencyCodeValue = jQuery('#cryptoCurrency').val();	
	var countryValue 			= jQuery('#country-value').val();
	var cryptocurrencytext	    = jQuery('#cryptoCurrency').find(':selected').attr('data-name');
	
	jQuery('#cryptocurrency-error').html("");
	jQuery('#transak_response').html("");
	if(currencyAmountValue == 0){
		jQuery('#cryptocurrency-error').html("<span id='error_msg'>Amount is too small</span>");
		return true;
	}

	jQuery('#buy-now-text-change').html('Buy '+cryptocurrencyCodeValue+' Now');
	jQuery('#buy-now-header-text-change').html('Buy '+cryptocurrencytext+' (<span style="text-transform:uppercase">'+cryptocurrencyCodeValue+'</span>)');
	
	currentRequest = jQuery.ajax({
					    type: 'POST',
					    dataType : "json",
					    data: {
					    		action					: "transak_conversion_call", 
					    		currencyAmountValue 	: currencyAmountValue, 
					    		currencyCodeValue 		: currencyCodeValue,
								cryptocurrencyCodeValue : cryptocurrencyCodeValue,
								countryValue 			: countryValue,    		
					    	},
					    url: transakObj.ajax_url,
					    beforeSend : function()    {           
					        jQuery('#cryptoAmount').val('...');
					        if(currentRequest != null) {
					            currentRequest.abort();
					        }
					    },
					    success: function(data) {
					        console.log(data);
					        var currencies_quote;
					        currencies_quote = data.currencies_quote;
					        if(currencies_quote.error){
				        		/*Handling Error here in future*/
					        	var message = currencies_quote.error.message;
					        	jQuery('#cryptocurrency-error').html("<span id='error_msg'>"+message+"</span>");
					        	jQuery('button.buy-now-button').attr("disabled", "disabled");
					        	jQuery('#cryptoAmount').val('0');
					        	jQuery('#transak_response').html('');
					        	
					        	

					        }else{
					        	jQuery('#cryptocurrency-error').html('');
					        	jQuery('button.buy-now-button').removeAttr("disabled", "disabled");
					        	jQuery('#cryptoAmount').val(currencies_quote.cryptoAmount);
					        	jQuery('#transak_response').html(data.html);

					        }
					    },
					    error:function(e){
					      	jQuery('#cryptoAmount').val('0');
					    }
					});
  	
};


jQuery(document).ready(function(e){
	/*Conversion Form Callback Functions*/	
	conversion_callback();
	jQuery('body').on("keyup", ".fiatAmount", function(){
	    conversion_callback()
  	});

  	jQuery('body').on("change", ".t-conversion", function(){
	    conversion_callback()
  	});
});