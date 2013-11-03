<?php
/*
================================================================
index.php

include: includes/index_welcome.php
		 includes/index_logined.php

The index page of new users(index_welcome.php) and old users(index_welcome.php)

Whenever you changed this page, please leave a log here.
The log includes time and changed content.
Just like the following:

#---------------------------------------------------------------
#Last updated: 11.1.2013 by Wang Sijie
#What's new: The first vision.
================================================================
 */ 

$is_logged_in = $this->session->userdata('is_logged_in');
if ((isset($is_logged_in) && $is_logged_in == true) || @$_GET["from"] == "welcome"): 
	// Display the welcome page.
	include("includes/index_logined.php"); 
else:
	// Display the normal index.
	include("includes/index_welcome.php"); 

endif; 

?>