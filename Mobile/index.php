<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>

<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=0"/>
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" media="handheld">
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<?php
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1") && ($_POST["Search"] != "")) {
  mysql_select_db($database_dbs, $dbs);
  $string = $_POST['Search'];
  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM child WHERE LastName LIKE '%$string%' OR FirstName LIKE '%$string%' OR ChildID LIKE '%$string' ORDER BY ChildID ASC"; 
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());

}
?>
<?php 
function getCellPhone1($passedParentID, $database_dbs2, $dbs2){
//get the parents phone cell phone numbers
	mysql_select_db($database_dbs2, $dbs2); //database already selected
	$query_Sort2 = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
	$Sort2 = mysql_query($query_Sort2, $dbs2) or die(mysql_error());
	//$totalRows2 = mysql_num_rows($Sort2);
	$row_Sort2 = mysql_fetch_assoc($Sort2);
	
  //all we care about is returning the CellPhone1
  return $row_Sort2['CellPhone1'];
  //getchilds($row_Sort['ParentID1'], $database_dbs, $dbs);
} 
?>

<div id="web"><!--start web -->
<?php //include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	<h2 id="pageName" align="center">Sunnybrook Kids Mobile</h2>
		<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
		<table width="300" border="0" class="table">
		  <tr>
		    <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
		    <td nowrap="true">Search in First-Last Name or ChildID</td> 
		  </tr>
		  <tr>
		    <td><input type="text" class="textbox" name="Search" size="26"></td>
		  </tr>
		  <tr>
		    <td><input type="submit" value="GO!" class="button"></td>
		    <input type="hidden" name="MM_search" value="form1">  
		  </tr>
		</table>
		</form>
			<?php if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
				while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				  <table border="1" class="table">
				    <tr>
					<td width="70">&nbsp;</td>
					<td width="70">&nbsp;</td>
					<td width="70">&nbsp;</td>
					<td width="70">&nbsp;</td>
				    </tr>
				    <tr>
					<td colspan=2 align="left"><img height="100" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
					<td><?php echo $row_Sort['ChildID']; ?>&nbsp;<br><?php echo $row_Sort['FirstName']; ?>&nbsp;<br><?php echo $row_Sort['LastName']; ?>&nbsp;<br></td>
					<td width="70">
					<?php
					  //call and get both parent phone numbers
					  $P1Cell = "";
					  $P2Cell = "";
					  $SMS = "Hello, ".$row_Sort['FirstName']." needs your attention. SCC Volunteer";
					  if($row_Sort['ParentID1']!=""){
					    $P1Cell =& getCellPhone1($row_Sort['ParentID1'], $database_dbs, $dbs);
					    //echo 'test';
					  }
					  if($row_Sort['ParentID2']!=""){
					    $P2Cell =& getCellPhone1($row_Sort['ParentID2'], $database_dbs, $dbs);
					  }
					  if(($P1Cell == $P2Cell) && (strlen($P1Cell) > 6)){
					    //only print one cell number if they are the same
					    //<a href="sms:1234567890?body=Hello">Send Hello via SMS to 1234567890</a>
					    echo '<a href="sms:'.$P1Cell.'?body='.$SMS.'">Send SMS</a>';
					  }
					  else if((strlen($P1Cell) > 6) && (strlen($P2Cell) > 6)){
					    //Print both numbers if they are both greater than 6
					    echo '<a href="sms:'.$P1Cell.';'.$P2Cell.'?body='.$SMS.'">Send SMS</a>';
					  }
					  
					  else if(strlen($P1Cell) > 6) {
					    //Print one cell that is greater than 6
					    echo '<a href="sms:'.$P1Cell.'?body='.$SMS.'">Send SMS</a>';
					  }
					  else if(strlen($P2Cell) > 6) {
					    //Print one cell that is greater than 6
					    echo '<a href="sms:'.$P2Cell.'?body='.$SMS.'">Send SMS</a>';
					  }
					  else { echo "no cell";}

					  ?>
					</td>
				    </tr>
				    <tr>
					<td colspan=2 align="left"><?php if($row_Sort['ParentID1']!=""){echo '<img height="100" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg">';}?>&nbsp;</td>
					<td colspan=2 align="left"><?php if($row_Sort['ParentID2']!=""){echo '<img height="100" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg">';}?>&nbsp;</td>
				    </tr>
				  </tr>
				</table>
			<?php } } //first close while, close if  ?>

	<SCRIPT language="JavaScript">
		document.form1.Search.focus();
	</SCRIPT> 
	</div> <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php //include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>