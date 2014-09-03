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
//select the database ParentID
if (isset($_GET['passedParentID'])&&($_GET['passedParentID']!='')) {
	$passedParentID=$_GET['passedParentID'];
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
}
if (isset($_POST['passedParentID'])&&($_POST['passedParentID']!='')) {
	$passedParentID=$_POST['passedParentID'];
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
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
			  <td><!--Picture --> <?php echo '<img width="300" src = "/ParentPictures/', $row_Sort['ParentID'], '.jpg">';?></td>
			  <td ><!--Status --> <?php include ('/var/www/statusv.php'); ?></td> 
			 </tr>
			 <tr>
			   <td><!--Child --> <?php //include ('/var/www/childdata.php'); ?></td>
			   <td><!--Parents --><?php //include ('/var/www/parentdata.php'); ?></td> 
			 </tr>
			 <tr>
			   <td><!--Printer --> <?php //include ('/var/www/printer.php'); ?></td>
			 </tr>
			</table>
		    </form>
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
<div id="printchildlabels">
  <?php if ((isset($_GET["PrintVBadge"])) && ($_GET["PrintVBadge"] != "")) {
          include ('/var/www/printerv.php');
        } //see statusv.php
        else {
          include ('/var/www/printerparentid.php'); 
        }//see statusv.php ?>
</div>

</body>
</html>
