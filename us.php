<?php
include('pd.php');

$page = array();

pd('pages')->build('html', array('file' => 'header', 'page' => $page));
?>
<div id="right-col">
			<div id="us-page-top-banner">
				<img src="img/us-banner.jpg"/>
			</div>
			<div class="inner-header">
				@HighFiveDigital
			</div>
			<div class="inner-p">
				We believe the success of a business is completely dependent upon  
				the relationship it has with its customers, which is two-fold.  Your 
				brand must deliver on promise, and you must actively listen to the 
				ever-changing marketplace- remaining conscious of your customer's 
				needs and feedback.
			</div>
			<div class="inner-p">	
				HighFive is a customer friendly, digital marketing company. We really 
				do love high fives, seriously, just ask for one! We're a team of 
				passionate, tech loving entrepreneurs who have been on both sides of 
				the table. We learned early on that the core value of business resides 
				in building strong relationships.
			</div>
			<div class="inner-p">	
				Your brand will <strong>be seen</strong>, your voice <strong>be heard</strong>, and you will <strong>connect</strong> 
				with your most important asset, your customers.  
			</div>
			<div class="inner-p">	
				If you're ready, give us a call and <a href="javascript://contact" class="service-link"><span class="red">let's chat today so we can schedule 
				your first HighFive.</span></a>
			</div>
			<div class="inner-p">
				<div class="us-profile" style="margin-right: 11px;">
					<div class="us-profile-pic">
						<img src="img/us/scott-fetters.png"/>
					</div>	
					<div class="us-profile-details">
						<div class="us-profile-name">
							Scott Fetters
						</div>
						<div class="us-profile-title">
							PARTNER
						</div>
						<div class="us-profile-linked-in">
							<a href="http://www.linkedin.com/in/scottfetters"><img src="img/us/linked-in-icon.png"/>Scott on LinkedIn</a>
						</div>		
					</div>	
				</div>
				<div class="us-profile">
					<div class="us-profile-pic">
						<img src="img/us/guenter-bergmann.png"/>
					</div>	
					<div class="us-profile-details">
						<div class="us-profile-name">
							Guenter Bergmann
						</div>
						<div class="us-profile-title">
							PARTNER
						</div>
						<div class="us-profile-linked-in">
							<a href="http://www.linkedin.com/in/guenterbergmann"><img src="img/us/linked-in-icon.png"/> Guenter on LinkedIn</a>
						</div>		
					</div>	
				</div>					
			</div>			
		</div>		
	</div>	 
  
  <?php
pd('pages')->build('html', array('file' => 'footer', 'page' => $page));
?>