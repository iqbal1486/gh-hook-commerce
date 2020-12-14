var currentRequest = null;    

var conversion_callback = function(){
	
	var currencyAmountValue 	= jQuery('#currency-amount-value').val();	
	var currencyCodeValue 		= jQuery('#currency-code-value').val();	
	var cryptocurrencyCodeValue = jQuery('#cryptocurrency-code-value').val();	
	var countryValue 			= jQuery('#country-value').val();
	var cryptocurrencytext	    = jQuery('#cryptocurrency-code-value').find(':selected').attr('data-name');
	
	jQuery('#cryptocurrency-error').html("");
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
					        jQuery('#cryptocurrency-amount-value').val('...');
					        if(currentRequest != null) {
					            currentRequest.abort();
					        }
					    },
					    success: function(data) {
					        console.log(data);
					        var currencies_quote;
					        currencies_quote = data.currencies_quote.response;
					        if(currencies_quote.error){
				        		/*Handling Error here in future*/
					        	var message = currencies_quote.error.message;
					        	jQuery('#cryptocurrency-error').html("<span id='error_msg'>"+message+"</span>");
					        	jQuery('button.buy-now-button').attr("disabled", "disabled");
					        	jQuery('#cryptocurrency-amount-value').val('0');
					        	

					        }else{
					        	jQuery('#cryptocurrency-error').html('');
					        	jQuery('button.buy-now-button').removeAttr("disabled", "disabled");
					        	jQuery('#cryptocurrency-amount-value').val(currencies_quote.cryptoAmount);
					        }
					    },
					    error:function(e){
					      	jQuery('#cryptocurrency-amount-value').val('0');
					    }
					});
  	
};


jQuery(document).ready(function(e){
	
	/*Conversion Form Callback Functions*/	
	conversion_callback();

	jQuery('body').on("keyup", ".currency-amount-value", function(){
	    conversion_callback()
  	});

  	jQuery('body').on("change", ".t-conversion", function(){
  		/*
  		if(jQuery(this).find(':selected').attr('data-currency')){
	    	jQuery("#currency-code-value").val(jQuery(this).find(':selected').attr('data-currency'));
	    	if (!jQuery("#currency-code-value option:selected").length) {
	    		jQuery("#currency-code-value").val('usd');
			}
	    }
	    */
	    conversion_callback()
  	});
  //jQuery('body').on('change', '#expected_number_of_guests', budget_calc_callback);

});