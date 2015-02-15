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
$editFormAction = $_SERVER['PHP_SELF'];
$newstatus = "x";
$row_Sort2 = "";
//select the database 
  //echo 'the start';
  //echo $_POST["passedChildID"];
  //echo $_POST["MM_update"];

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
 //code to print tags
 	mysql_select_db($database_dbs, $dbs); //database already selected
	$query_Sort2 = "SELECT * FROM parent WHERE NFCID = '".$_POST['passedNFCID']."'"; 
	$Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
	$totalRows2 = mysql_num_rows($Sort2);
	$row_Sort2 = mysql_fetch_assoc($Sort2);
	
  //echo $row_Sort2['FirstName'];
  //echo $row_Sort2['SelfChildID1'];
  //echo $row_Sort2['ChildID1'];
}
?>
</head>
<body>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Self Check In</h2>
		  <div class="feature">
		     <form action="self.php" METHOD="POST" name="form1">
			<input type="hidden" name="MM_update" value="form1">
			<table width="400" border="0" class="table">
			  <tr>
			    <td width="150" nowrap="true">Parent's&nbsp;NFCID<br></td>
			    <td><input name="passedNFCID" id="textbox" value="" type="text" size=26></td>
			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Status" value="Print Tags"></font></td>
			  </tr> 
			</table>
		      </form>
		  </div>
		  <!--end feature -->
	<SCRIPT language="JavaScript">
		document.form1.passedNFCID.focus();
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
  <?php include ('/var/www/printselfcheckin.php'); ?>
</div>
</html>
