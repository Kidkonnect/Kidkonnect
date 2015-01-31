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
$editFormAction = $_SERVER['PHP_SELF'];

//$query_Sort = "Declare Variable";
//$query_Sort = "SELECT * FROM child WHERE LastName LIKE '%the%'"; 

//$passedSort = $_GET['Sort'];
//if (!isset($passedSort)) {
 // $passedSort = "LastName";
//}
//$passedAgeGroup = $_GET['AgeGroup'];
//if (!isset($passedAgeGroup)) {
//  $passedAgeGroup = "";
//}

//echo 'top';


mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
//echo 'test1';
  //get all child IDs that have the selected grade 
  //create string for query sort
  $query_Sort = "SELECT * FROM child WHERE ";
  if (isset($_POST['Nursery'])){ $query_Sort .="Grade='Nursery' OR ";}
  if (isset($_POST['1YearOlds'])){ $query_Sort .="Grade='1YearOlds' OR ";}
  if (isset($_POST['2YearOlds'])){ $query_Sort .="Grade='2YearOlds' OR ";}
  if (isset($_POST['3YearOlds'])){ $query_Sort .="Grade='3YearOlds' OR ";}
  if (isset($_POST['4YearOlds'])){ $query_Sort .="Grade='4YearOlds' OR ";}
  if (isset($_POST['5YearOlds'])){ $query_Sort .="Grade='5YearOlds' OR ";}
  if (isset($_POST['Kindergarten'])){ $query_Sort .="Grade='Kindergarten' OR ";}
  if (isset($_POST['1st_Grade'])){ $query_Sort .="Grade='1st_Grade' OR ";}
  if (isset($_POST['2nd_Grade'])){ $query_Sort .="Grade='2nd_Grade' OR ";}
  if (isset($_POST['3rd_Grade'])){ $query_Sort .="Grade='3rd_Grade' OR ";}
  if (isset($_POST['4th_Grade'])){ $query_Sort .="Grade='4th_Grade' OR ";}
  if (isset($_POST['5th_Grade'])){ $query_Sort .="Grade='5th_Grade' OR ";}
  if (isset($_POST['6th_Grade'])){ $query_Sort .="Grade='6th_Grade' OR ";}
  if (isset($_POST['7th_Grade'])){ $query_Sort .="Grade='7th_Grade' OR ";}
  if (isset($_POST['8th_Grade'])){ $query_Sort .="Grade='8th_Grade' OR ";}
  if (isset($_POST['9th_Grade'])){ $query_Sort .="Grade='9th_Grade' OR ";}
  if (isset($_POST['10th_Grade'])){ $query_Sort .="Grade='10th_Grade' OR ";}
  if (isset($_POST['11th_Grade'])){ $query_Sort .="Grade='11th_Grade' OR ";}
  if (isset($_POST['12th_Grade'])){ $query_Sort .="Grade='12th_Grade' OR ";}
  if (isset($_POST['N-K'])){ $query_Sort .="AgeGroup='N-K' OR ";}
  if (isset($_POST['K-5'])){ $query_Sort .="AgeGroup='K-5' OR ";}
  if (isset($_POST['6-8'])){ $query_Sort .="AgeGroup='6-8' OR ";}
  if (isset($_POST['9-12'])){ $query_Sort .="AgeGroup='9-12' OR ";}
  //remove the last "OR "
  $lenght = strlen($query_Sort);
  $query_Sort = substr($query_Sort, 0, $lenght-3);  // returns "yy"
  $query_Sort .="ORDER BY Grade ASC";
//echo $query_Sort; //used for test 
  //now, get a list of all parent IDs that are tied to the child (the child's parents)
//echo $_POST['GetEmails'];
//echo 'test2';
//echo $_POST['EmailGroup'];

  //make sure they make a selection
  if ($lenght > 40){
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  }
}

function get_parent_email($passedChildID, $passedParentID, $database_dbs3, $dbs3){
//get the data from the parent
/*
mysql_select_db($database_tvt, $tvt);
$query_computerdata = sprintf("SELECT * FROM computerdata WHERE TerrahawkSN = '%s'", $colname_computerdata);
$computerdata = mysql_query($query_computerdata, $tvt) or die(mysql_error());
$row_computerdata = mysql_fetch_assoc($computerdata);
$totalRows_computerdata = mysql_num_rows($computerdata);
*/
//echo "passedParentID=$passedParentID";
	mysql_select_db($database_dbs3, $dbs3); //database already selected
	$query_Sort3 = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
	$Sort3 = mysql_query($query_Sort3, $dbs3) or die(mysql_error());
	$totalRows3 = mysql_num_rows($Sort3);
	$row_Sort3 = mysql_fetch_assoc($Sort3);
//Put the data on the sreen
  if (($row_Sort3['Email'] != "") && ($row_Sort3['Email'] != "none") && ($row_Sort3['Email'] != "Email")) {

//  echo "passedChildID=$passedChildID";
//  echo "passedParentID=$passedParentID";
  //echo $row_Sort3['FirstName'].' '. $row_Sort3['LastName'].'('.$row_Sort3['Email'].'); ';
    if (isset($_POST['Windows2'])){
      echo $row_Sort3['Email'].'; ';
    }
    else{ 
      echo $row_Sort3['Email'].', ';
    }
//  echo '<br>';
  }
//echo $row_Sort3['Email'];
  //echo $totalRows2;
  //echo $row_Sort3['FirstName'];
  //echo $row_Sort3['LastName'];

}

?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
		     <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
			<input type="hidden" name="MM_update" value="form1">
			<table width="800"  class="table" border="0">
			  <tr><td colspan="12">This will get the email addresses of the parents of the selected age groups</td></tr>
			  <tr>	<td> <input name="Nursery" id="textbox" <?php if (isset($_POST['Nursery'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>Nursery</td>    <td>&nbsp;</td>
				<td> <input name="1YearOlds" id="textbox" <?php if (isset($_POST['1YearOlds'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>1YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="2YearOlds" id="textbox" <?php if (isset($_POST['2YearOlds'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>2YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="3YearOlds" id="textbox" <?php if (isset($_POST['3YearOlds'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>3YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="4YearOlds" id="textbox" <?php if (isset($_POST['4YearOlds'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>4YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="5YearOlds" id="textbox" <?php if (isset($_POST['5YearOlds'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>5YearOlds</td>    <td>&nbsp;</td> </tr>
				<td> <input name="Kindergarten" id="textbox" <?php if (isset($_POST['Kindergarten'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>Kindergarten</td>    <td>&nbsp;</td> </tr>
			  
			  <tr>	<td> <input name="1st_Grade" id="textbox" <?php if (isset($_POST['1st_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>1st_Grade</td>    <td>&nbsp;</td>
				<td> <input name="2nd_Grade" id="textbox" <?php if (isset($_POST['2nd_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>2nd_Grade</td>    <td>&nbsp;</td>
				<td> <input name="3rd_Grade" id="textbox" <?php if (isset($_POST['3rd_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>3rd_Grade</td>    <td>&nbsp;</td>
				<td> <input name="4th_Grade" id="textbox" <?php if (isset($_POST['4th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>4th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="5th_Grade" id="textbox" <?php if (isset($_POST['5th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>5th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="6th_Grade" id="textbox" <?php if (isset($_POST['6th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>6th_Grade</td>    <td>&nbsp;</td> </tr>

			  <tr>	<td> <input name="7th_Grade" id="textbox" <?php if (isset($_POST['7th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>7th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="8th_Grade" id="textbox" <?php if (isset($_POST['8th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>8th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="9th_Grade" id="textbox" <?php if (isset($_POST['9th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>9th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="10th_Grade" id="textbox" <?php if (isset($_POST['10th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>10th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="11th_Grade" id="textbox" <?php if (isset($_POST['11th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>11th_Grade</td>    <td>&nbsp;</td>
				<td> <input name="12th_Grade" id="textbox" <?php if (isset($_POST['12th_Grade'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>12th_Grade</td>    <td>&nbsp;</td> </tr>

			  <tr>	<td> <input name="N-K" id="textbox" <?php if (isset($_POST['N-K'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>N-K</td>    <td>&nbsp;</td>
				<td> <input name="K-5" id="textbox" <?php if (isset($_POST['K-5'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>K-5</td>    <td>&nbsp;</td>
				<td> <input name="6-8" id="textbox" <?php if (isset($_POST['6-8'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>6-8</td>    <td>&nbsp;</td>
				<td> <input name="9-12" id="textbox" <?php if (isset($_POST['9-12'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>9-12</td>    <td>&nbsp;</td>  </tr>

			  <tr>	<td> Format For</td>    <td>&nbsp;</td>
				<td> <input name="Windows2" id="textbox" <?php if (isset($_POST['Windows2'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>Windows</td>    <td>&nbsp;</td>
				<td> <input name="Mac" id="textbox" <?php if (isset($_POST['Mac'])){echo 'checked="checked"';}?> value="" type="checkbox" size=26>Mac</td>    <td>&nbsp;</td>  </tr>
			  <tr>
				<td colspan="12" nowrap align="left" width="150"> Group Emails by this amount:<input name="EmailGroup" id="textbox" value="<?php if (isset($_POST['EmailGroup'])){echo $_POST['EmailGroup'];}else {echo '100';}?>" type="text" size=26></td>
			  </tr>
			  <tr>
				<td colspan="6"><input type="submit" name="GetEmails" value="Get Emails" class="button"></td>		
			  </tr>
			</table>
		    </form>
			
			<?php 
			//echo 'test3';
			$count = 0;
		if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
			//for each child, we need to look at every parent
			//echo 'test4';
			if ($lenght < 40){
			  echo "You need to make a selection!";
			}
			else{
				//create the label of emails printed
				$emails_printed = "These are the emails for selections: ";
				if (isset($_POST['Nursery'])){ $emails_printed .="Nursery; ";}
				if (isset($_POST['1YearOlds'])){ $emails_printed .="1YearOlds; ";}
				if (isset($_POST['2YearOlds'])){ $emails_printed .="2YearOlds; ";}
				if (isset($_POST['3YearOlds'])){ $emails_printed .="3YearOlds; ";}
				if (isset($_POST['4YearOlds'])){ $emails_printed .="4YearOlds; ";}
				if (isset($_POST['5YearOlds'])){ $emails_printed .="5YearOlds; ";}
				if (isset($_POST['Kindergarten'])){ $emails_printed .="Kindergarten; ";}
				if (isset($_POST['1st_Grade'])){ $emails_printed .="1st_Grade; ";}
				if (isset($_POST['2nd_Grade'])){ $emails_printed .="2nd_Grade; ";}
				if (isset($_POST['3rd_Grade'])){ $emails_printed .="3rd_Grade; ";}
				if (isset($_POST['4th_Grade'])){ $emails_printed .="4th_Grade; ";}
				if (isset($_POST['5th_Grade'])){ $emails_printed .="5th_Grade; ";}
				if (isset($_POST['6th_Grade'])){ $emails_printed .="6th_Grade; ";}
				if (isset($_POST['7th_Grade'])){ $emails_printed .="7th_Grade; ";}
				if (isset($_POST['8th_Grade'])){ $emails_printed .="8th_Grade; ";}
				if (isset($_POST['9th_Grade'])){ $emails_printed .="9th_Grade; ";}
				if (isset($_POST['10th_Grade'])){ $emails_printed .="10th_Grade; ";}
				if (isset($_POST['11th_Grade'])){ $emails_printed .="11th_Grade; ";}
				if (isset($_POST['12th_Grade'])){ $emails_printed .="12th_Grade; ";}
				if (isset($_POST['N-K'])){ $emails_printed .="N-K; ";}
				if (isset($_POST['K-5'])){ $emails_printed .="K-5; ";}
				if (isset($_POST['6-8'])){ $emails_printed .="6-8; ";}
				if (isset($_POST['9-12'])){ $emails_printed .="9-12; ";}
				echo $emails_printed. "<p>";
			while ($row_Sort = mysql_fetch_assoc($Sort)) {
				if ($row_Sort['ParentID1']!=""){
					$count++;
					get_parent_email($row_Sort['ChildID'], $row_Sort['ParentID1'], $database_dbs, $dbs);
				}
				if ($row_Sort['ParentID2']!=""){
					$count++;
					get_parent_email($row_Sort['ChildID'], $row_Sort['ParentID2'], $database_dbs, $dbs);
				}
				//if ($row_Sort['ParentID3']!=""){
				//	$count++;
				//	get_parent_email($row_Sort['ChildID'], $row_Sort['ParentID3'], $database_dbs, $dbs);
				//}
				//if ($row_Sort['ParentID4']!=""){
				//	$count++;
				//	get_parent_email($row_Sort['ChildID'], $row_Sort['ParentID4'], $database_dbs, $dbs);
				//}
				if ($count > $_POST['EmailGroup']){
				//this will break the emails into sections to be copied
				echo '<p>';
				$count = 0;
				}
			} 
			}
		} ?> 
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


