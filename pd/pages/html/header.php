<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>High Five Digital Marketing</title>
	<link rel="stylesheet" href="css/highfive.css" type="text/css" media="screen" title="High Five Styles" charset="utf-8">	
	<meta name="fo-verify" content="efceccfe-74d2-498f-aae8-b6601bb7f25e">	
	<meta name="author" content="Alex Rolek">
  	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script> 
	<!-- Date: 2011-01-13 -->
  	<?php pd('ajax')->build('js', array('file' => 'main')); ?>
</head>
<body>
	<div id="page-conatiner">
		<div id="left-col">
			<div id="logo">
				<img src="img/logo.png"/>
				<div id="logo-copy">
					Be Seen. Be Heard. <span class="red">Connect</span>
				</div>
			</div>
			<ul id="left-col-menu-container">
				<li>
					<a href="index.php">
						<img src="img/px.png" class="home-icon"/>
						<span class="left-col-menu-copy">
							Home
						</span>	
					</a>
				</li>	
				<li>
					<a href="science.php">
						<img src="img/px.png" class="science-icon"/>
						<span class="left-col-menu-copy">
							Science
						</span>	
					</a>
				</li>	
				<li>
					<a href="services.php">
						<img src="img/px.png" class="services-icon"/>
						<span class="left-col-menu-copy">
							Services
						</span>	
					</a>
				</li>	
				<li class="list-last">
					<a href="us.php">
						<img src="img/px.png" class="us-icon"/>
						<span class="left-col-menu-copy">
							Us
						</span>	
					</a>
				</li>	
			</ul>
			<div id="contact-us-form-container">
				<div class="contact-header">
					Let's chat about <br />your first HighFive
				</div>
        <div <?php pd('write')->str(pd('contact', 'ajax')->get_container_attr(array('container' => 'contact'))); ?>>
        <?php
          pd('contact')->build('html', array('file' => 'submit'));
        ?>
        </div>
			</div>
			<a href="javascript://contact us" id="contact-us">
				<img src="img/main-menu/contact-us.png" id="contact-us-btn"/>
			</a>	
		</div>
