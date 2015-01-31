<?php include ('/var/www/Templates/database.php'); ?>
<?php include ('/var/www/Access/accessadmin.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin Admin pages</title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<?php
//start building query sort
$query_Sort = "SELECT * FROM child WHERE"; 

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  //reset all other filters
  $passedFilter = "";
  //check to see what boxes were checked
  if (isset($_POST['Kindergarten'])){ 
    $query_Sort = $query_Sort." Grade='Kindergarten' OR"; 
  }
  if (isset($_POST['1st_Grade'])){ 
    $query_Sort = $query_Sort." Grade='1st_Grade' OR"; 
  }
  if (isset($_POST['2nd_Grade'])){ 
    $query_Sort = $query_Sort." Grade='2nd_Grade' OR"; 
  }
  if (isset($_POST['3rd_Grade'])){ 
    $query_Sort = $query_Sort." Grade='3rd_Grade' OR"; 
  }
  if (isset($_POST['4th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='4th_Grade' OR"; 
  }
  if (isset($_POST['5th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='5th_Grade' OR"; 
  }
  if (isset($_POST['6th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='6th_Grade' OR"; 
  }
  if (isset($_POST['7th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='7th_Grade' OR"; 
  }
  if (isset($_POST['8th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='8th_Grade' OR"; 
  }
  if (isset($_POST['9th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='9th_Grade' OR"; 
  }
  if (isset($_POST['10th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='10th_Grade' OR"; 
  }
  if (isset($_POST['11th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='11th_Grade' OR"; 
  }
  if (isset($_POST['12th_Grade'])){ 
    $query_Sort = $query_Sort." Grade='12th_Grade' OR"; 
  }
}
else if (strlen($query_Sort) < 30){
  //echo "1 No slection has been made.";
}
else {
  //echo "2 No slection has been made.";
}

mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if (strlen($query_Sort) > 30){
  //set default page load
  $query_Sort = $query_Sort."DER BY Grade DESC"; 
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  //echo $query_Sort;
}
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
		     <form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
			<input type="hidden" name="MM_update" value="form2">
			<table width="800" border="1" class="table"><tr><td>
			<table width="800"  class="table" border="0">
			  
			  <tr>	<td> <input name="Kindergarten" id="textbox" <?php if (isset($_POST['Kindergarten'])){echo 'checked="checked"';}?> type="checkbox" size=26>Kindergarten</td>    <td>&nbsp;</td>
				<td> <input name="1st_Grade" id="textbox" <?php if (isset($_POST['1st_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>1st_Grade</td>    <td>&nbsp;</td>
				<td> <input name="2nd_Grade" id="textbox" <?php if (isset($_POST['2nd_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>2nd_Grade</td>    <td>&nbsp;</td>
				<td> <input name="3rd_Grade" id="textbox" <?php if (isset($_POST['3rd_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>3rd_Grade</td>    <td>&nbsp;</td>
				<td> <input name="4th_Grade" id="textbox" <?php if (isset($_POST['4th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>4th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="5th_Grade" id="textbox" <?php if (isset($_POST['5th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>5th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="6th_Grade" id="textbox" <?php if (isset($_POST['6th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>6th_Grade</td>    <td>&nbsp;</td> </tr>

			  <tr>	<td> <input name="7th_Grade" id="textbox" <?php if (isset($_POST['7th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>7th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="8th_Grade" id="textbox" <?php if (isset($_POST['8th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>8th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="9th_Grade" id="textbox" <?php if (isset($_POST['9th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>9th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="10th_Grade" id="textbox" <?php if (isset($_POST['10th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>10th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="11th_Grade" id="textbox" <?php if (isset($_POST['11th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>11th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="12th_Grade" id="textbox" <?php if (isset($_POST['12th_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>12th_Grade</td>    <td>&nbsp;</td> </tr>

			  <td colspan="10"><font>&nbsp;<input style="font-size: 28px;" type="submit" name="Promote" id="textbox" value="Promote"></font>Note: start with 12th Grade and work down.</td>

			</table>

			</td></tr></table>
		    </form>
			<table class="table" border="0">
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) {
			  //find what grade we are looking at and Promote the child
			  //also change the Agegroup
			  $Grade = $row_Sort['Grade'];
			  $AgeGroup = $row_Sort['AgeGroup'];
			  if ($row_Sort['Grade'] == 'Kindergarten'){ $Grade = "1st_Grade"; $AgeGroup = "K-5";}
			  if ($row_Sort['Grade'] == '1st_Grade'){ $Grade = "2nd_Grade"; $AgeGroup = "K-5";}
			  if ($row_Sort['Grade'] == '2nd_Grade'){ $Grade = "3rd_Grade"; $AgeGroup = "K-5";}
			  if ($row_Sort['Grade'] == '3rd_Grade'){ $Grade = "4th_Grade"; $AgeGroup = "K-5";}
			  if ($row_Sort['Grade'] == '4th_Grade'){ $Grade = "5th_Grade"; $AgeGroup = "K-5";}
			  if ($row_Sort['Grade'] == '5th_Grade'){ $Grade = "6th_Grade"; $AgeGroup = "6-8";}
			  if ($row_Sort['Grade'] == '6th_Grade'){ $Grade = "7th_Grade"; $AgeGroup = "6-8";}
			  if ($row_Sort['Grade'] == '7th_Grade'){ $Grade = "8th_Grade"; $AgeGroup = "6-8";}
			  if ($row_Sort['Grade'] == '8th_Grade'){ $Grade = "9th_Grade"; $AgeGroup = "9-12";}
			  if ($row_Sort['Grade'] == '9th_Grade'){ $Grade = "10th_Grade"; $AgeGroup = "9-12";}
			  if ($row_Sort['Grade'] == '10th_Grade'){ $Grade = "11th_Grade"; $AgeGroup = "9-12";}
			  if ($row_Sort['Grade'] == '11th_Grade'){ $Grade = "12th_Grade"; $AgeGroup = "9-12";}
			  if ($row_Sort['Grade'] == '12th_Grade'){ $Grade = "College"; $AgeGroup = "Coll";}

			  //now we need to update the child data base
				  $updateSQL = sprintf("UPDATE child SET Grade=%s, AgeGroup=%s WHERE ChildID=%s",
		                       GetSQLValueString($Grade, "text"),
		                       GetSQLValueString($AgeGroup, "text"),
		                       GetSQLValueString($row_Sort['ChildID'], "text"));

				  mysql_select_db($database_dbs, $dbs);
				  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
			?>	
				<tr>
				<td align="left" nowrap="true"><?php echo $row_Sort['ChildID']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Grade']; ?>&nbsp;</td>
				<td align="left" nowrap="true">-->&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $Grade; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['AgeGroup']; ?>&nbsp;</td>
				<td align="left" nowrap="true">-->&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $AgeGroup; ?>&nbsp;</td>
				</tr>

			
			<?php } 
				if (strlen($query_Sort) < 30){
				   echo "<tr><td>No slection has been made.</td></tr>";
				}//close while?>
			</table>
		  <SCRIPT language="JavaScript">
			document.form1.Search.focus();
		  </SCRIPT> 
		  </div>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
		<?php //include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


