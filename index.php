<?php
include('pd.php');

$page = array();

pd('pages')->build('html', array('file' => 'header', 'page' => $page));
?>

		<div id="right-col">
			<div id="home-page-top-banner">
				<a href="services.php">
					<img src="img/px.png"/>
				</a>
			</div>
			<div id="home-page-middle-banner">
				<img src="img/home-page/middle-banner.png"/>
			</div>
			<div id="home-page-middle-copy">
				<div id="home-page-middle-copy-title">
					Why should you care?
				</div>
				<ul id="home-page-middle-copy-list">	
					<li>
						<img src="img/home-page/list-bullet-check.png"/>
						We're a customer friendly marketing company.
					</li>
					<li>	
						<img src="img/home-page/list-bullet-check.png"/>
						We fuse technology with creative campaigns to build awesome relationships with your customers, improve brand awareness, and increase your revenues.
					</li>
				</ul>	
			</div>	
			<div id="home-page-services-scroller">
				<div id="home-page-services-header">
					Check out how we can help you...</div>
				<ul id="home-page-services-scroller-items">
					<li id="home-page-service-lead-gen">
						<a href="services.php">						
							<div class="home-page-service-title">
								Lead Generation
							</div>
							<div class="home-page-service-copy">
								Are you looking for new customers but unsure where to look? 
							</div>	
						</a>		
					</li>	
					<li id="home-page-service-social">
						<a href="services.php">						
							<div class="home-page-service-title">
								Social Media
							</div>
							<div class="home-page-service-copy">
								Social media has changed the name of the marketing game forever.  
							</div>		
						</a>	
					</li>
					<li id="home-page-service-mobile">
						<a href="services.php">
							<div class="home-page-service-title">
								Mobile Apps
							</div>
							<div class="home-page-service-copy">
								Consumers are expecting to find you in their pocket, purse, or backpack. 
							</div>		
						</a>	
					</li>										
				</ul>
			</div>			
		</div>		
	</div>	

<?php
pd('pages')->build('html', array('file' => 'footer', 'page' => $page));
?>