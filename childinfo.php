<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
 <!--sets page break for lables -->
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<!-- print.css are located in the status.php -->
<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">

<!-- Find what variable was set in the index.php file -->
<?php
//select the database 
if (isset($_GET['passedChildID'])&&($_GET['passedChildID']!='')) {
	$passedChildID=$_GET['passedChildID'];
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID = '".$passedChildID."'"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
}
if (isset($_POST['passedChildID'])&&($_POST['passedChildID']!='')) {
	$passedChildID=$_POST['passedChildID'];
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID = '".$passedChildID."'"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
	
}
else {
	$totalRows = 0;
}
?>
</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Kids</h2>
		  <div class="feature">
		     <form action="" method="get">
			<table border="0" class="table">
			 <tr>
			  <td><!--Picture --> <?php echo '<img width="300" src = "/ChildPictures/', $row_Sort['ChildID'], '.jpg">';?></td>
			  <td ><!--Status --> <?php include ('/var/www/childinfostatus.php'); ?></td> 
			 </tr>
			 <tr>
			   <td valign="top"><!--Child --> <?php include ('/var/www/childinfodata.php'); ?></td>
			   <td><!--Parents --><?php include ('/var/www/childinfoparents.php'); ?></td> 
			 </tr>
			 <tr>
			   <td><!--Printer --> <?php //include ('/var/www/printer.php'); ?></td>
			 </tr>
			</table>
		    </form>
		  </div>
		  <!--end feature -->
	<SCRIPT language="JavaScript">
		document.form1.Status.focus();
	</SCRIPT> 
  </div> 
  <!--end content -->

   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->



</body>

<div id="printchildlabels">
  <?php include ('/var/www/printer.php'); ?>
</div>
</html>
