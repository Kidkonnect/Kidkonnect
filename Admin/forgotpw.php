<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Did you forget your password? Please try again.</h2>
		  <div class="feature">
			  <form ACTION= "/Admin/index.php"  METHOD="POST" name="logonfield"> 
			   <table width="150px"> 
				 <tr><td>Username<br><input name="username" id="txtboxLogin" value=""       type="text"      size=18></td></tr> 
				 <tr><td>Password<br><input name="password" id="txtboxLogin" value=""       type="password"  size=18></td></tr> 
				 <tr><td>&nbsp;<input       name="Submit"   id="txtboxLogin" value="Log In" type="submit"           ></td></tr> 
			   </table> 
			 </form
		  </div>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


