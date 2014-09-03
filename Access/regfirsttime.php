<?php include ('E:\terraverdetech.com\wwwroot\Templates\database.php'); ?>
<?php include ('E:\terraverdetech.com\wwwroot\Templates\javamenus.php'); ?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>TerraVerde Technologies - Welcome</title>
<link rel="stylesheet" href="/tvt.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">
</head>
<body>
<?php
$colname_rsUser = "1";
if (isset($_SESSION['MM_Username'])) {
  $colname_rsUser = (get_magic_quotes_gpc()) ? $_SESSION['MM_Username'] : addslashes($_SESSION['MM_Username']);
}
mysql_select_db($database_tvt, $tvt);
$query_rsUser = sprintf("SELECT * FROM userinfo WHERE email = '%s'", $colname_rsUser);
$rsUser = mysql_query($query_rsUser, $tvt) or die(mysql_error());
$row_rsUser = mysql_fetch_assoc($rsUser);
$totalRows_rsUser = mysql_num_rows($rsUser);

mysql_free_result($rsUser);
?>

<div id="web"><!--start web -->
<?php include ('E:\terraverdetech.com\wwwroot\Templates\masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb"> 
		<a href="/index.php">TerraVerdeTech</a> 
	  </div> 
	    <h2 id="pageName"><?php echo '&nbsp;Welcome '.$MM_FirstName.'!';?></h2>
	  <div class="feature" align="center">
          <table width="500" border="1" class="table">
		  	<tr>
			  <td colspan="2"><b>Thank you for registering with us. You will find more options to the left of the screen.</b></td>
			</tr>
            <tr>
              <td width="140">Email:</td>
              <td width="272"><?php echo $row_rsUser['email']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>Password:</td>
              <td><?php echo $row_rsUser['password']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>First Name:</td>
              <td><?php echo $row_rsUser['first_name']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>Last Name:</td>
              <td><?php echo $row_rsUser['last_name']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>Company Name:</td>
              <td><?php echo $row_rsUser['company_name']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>Company Address:</td>
              <td><?php echo $row_rsUser['company_address']; ?>&nbsp;</td>
            </tr>
			<tr>
              <td>Company City:</td>
              <td><?php echo $row_rsUser['company_city']; ?>&nbsp;</td>
            </tr>
			<tr>
              <td>Company state:</td>
              <td><?php echo $row_rsUser['company_state']; ?>&nbsp;</td>
            </tr>
            <tr>
              <td>Company Phone:</td>
              <td><?php echo $row_rsUser['company_phone']; ?>&nbsp;</td>
            </tr>
			<tr>
              <td>Company Website:</td>
              <td><?php echo $row_rsUser['company_web']; ?>&nbsp;</td>
            </tr>
        </table>
	  </div> <!--end feature -->	
	  <p>
        <?php include ('E:\terraverdetech.com\wwwroot\Templates\siteinfo.php'); ?>
      </p>
  </div> <!--end content -->
  <div id="navBar"><!--start navBar -->
  <?php include ('E:\terraverdetech.com\wwwroot\Templates\navbar.php'); ?>
  	  <div id="whiteBar"></div>
	  <div class="relatedLinks">
	      <?php include ('E:\terraverdetech.com\wwwroot\Templates\headlines.php'); ?>
	    </div> 
  </div><!--end navBar -->
  
 
  <script language="JavaScript1.2">mmLoadMenus();</script> <!--used to write the menus. needs to be last so menus will be on top -->
</div><!--end web -->
</body>
</html>


