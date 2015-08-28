/*===============================================================
//	HIGH FIVE DIGITAL MARKETING
//	Alexander Rolek (c) 2011
//	a.rolek at gmail dot com	
//==============================================================*/

$(function(){
	function contactToggle(){
		$('#contact-us-form-container').slideDown();
		$('#contact-us-btn').hide();
	};
	
	$('#contact-us-btn, .service-link').click(function(){
		contactToggle();
	});		
	
	//accordion slider toggle
	$('.accordion-header').click(function(){
		$(this).next().slideToggle();
	});
	
	var currentCard = 'step-1';	
	$('#science-process-tabs li').click(function(){
		var newCard = $(this).attr('card');
		if(currentCard != newCard) {
			$('#' + newCard).fadeIn('fast',function(){
				$('#' + currentCard).fadeOut('fast');
				currentCard = newCard;
			})
						
		}
		console.log($(this).attr('card'));
	});
});
