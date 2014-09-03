<?php include ('E:\terraverdetech.com\wwwroot\Templates\database.php'); ?>
<?php include ('E:\terraverdetech.com\wwwroot\Templates\javamenus.php'); ?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>TerraVerde Technologies - TerraHawk Description</title>
<link rel="stylesheet" href="/tvt.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">
</head>
<body>
<div id="web"><!--start web -->
<?php include ('E:\terraverdetech.com\wwwroot\Templates\masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb"> 
		<a href="/index.php">TerraVerdeTech</a> / Admin</div> 
	  <h2 id="pageName">Not Admin</h2> 
	  <div class="feature" align="justify" >
		<p>Access Denied: Sorry, this page is restricted to TerraVerde admin. The user name you are logged in under does not have admin permissions.</p>
    
	  </div><!--end feature -->
	<?php include ('E:\terraverdetech.com\wwwroot\Templates\siteinfo.php'); ?>
  </div> <!--end content -->
   <div id="navBar"><!--start navBar -->
  <?php include ('E:\terraverdetech.com\wwwroot\Templates\navbar.php'); ?>
  	  <div id="whiteBar"></div>
	  <div class="relatedLinks"><!--start relatedLinks -->
	  	<?php include ('E:\terraverdetech.com\wwwroot\Templates\headlines.php'); ?>
 	</div><!--end relatedLinks -->
  </div>
  <!--end navBar -->
  
 
  <script language="JavaScript1.2">mmLoadMenus();</script> <!--used to write the menus. needs to be last so menus will be on top -->
</div><!--end web -->
</body>
</html>


