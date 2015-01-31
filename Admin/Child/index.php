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
//function to check for birthday
function check_birthday_grade($query_Sort1, $grade){
  //get the length to check if anything was set
  $query_Sort1_lenght1 = strlen($query_Sort1);
  if (isset($_POST['Jan'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '1-%' OR Grade='".$grade."' And Birthday LIKE '01-%' OR Grade='".$grade."' And Birthday LIKE '1/%' OR Grade='".$grade."' And Birthday LIKE '01/%'  OR ";}
  if (isset($_POST['Feb'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '2%' OR Grade='".$grade."' And Birthday LIKE '02%' OR ";}
  if (isset($_POST['Mar'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '3%' OR Grade='".$grade."' And Birthday LIKE '03%' OR ";}
  if (isset($_POST['Apr'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '4%' OR Grade='".$grade."' And Birthday LIKE '04%' OR ";}
  if (isset($_POST['May'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '5%' OR Grade='".$grade."' And Birthday LIKE '05%' OR ";}
  if (isset($_POST['Jun'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '6%' OR Grade='".$grade."' And Birthday LIKE '06%' OR ";}
  if (isset($_POST['Jul'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '7%' OR Grade='".$grade."' And Birthday LIKE '07%' OR ";}
  if (isset($_POST['Aug'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '8%' OR Grade='".$grade."' And Birthday LIKE '08%' OR ";}
  if (isset($_POST['Sep'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '9%' OR Grade='".$grade."' And Birthday LIKE '09%' OR ";}
  if (isset($_POST['Oct'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '10%' OR ";}
  if (isset($_POST['Nov'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '11%' OR ";}
  if (isset($_POST['Dec'])){ $query_Sort1 .="Grade='".$grade."' And Birthday LIKE '12%' OR ";}
  $query_Sort1_lenght2 = strlen($query_Sort1);
  if($query_Sort1_lenght1 == $query_Sort1_lenght2){
  //no birthday was selected create the string with out it
    $query_Sort1 .="Grade='".$grade."' OR ";
  }
  return $query_Sort1;

}
function check_birthday_agegroup($query_Sort1, $group){
  //get the length to check if anything was set
  $query_Sort1_lenght1 = strlen($query_Sort1);
  if (isset($_POST['Jan'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '1-%' OR AgeGroup='".$group."' And Birthday LIKE '01-%' OR AgeGroup='".$group."' And Birthday LIKE '1/%' OR AgeGroup='".$group."' And Birthday LIKE '01/%'  OR ";}
  if (isset($_POST['Feb'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '2%' OR AgeGroup='".$group."' And Birthday LIKE '02%' OR ";}
  if (isset($_POST['Mar'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '3%' OR AgeGroup='".$group."' And Birthday LIKE '03%' OR ";}
  if (isset($_POST['Apr'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '4%' OR AgeGroup='".$group."' And Birthday LIKE '04%' OR ";}
  if (isset($_POST['May'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '5%' OR AgeGroup='".$group."' And Birthday LIKE '05%' OR ";}
  if (isset($_POST['Jun'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '6%' OR AgeGroup='".$group."' And Birthday LIKE '06%' OR ";}
  if (isset($_POST['Jul'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '7%' OR AgeGroup='".$group."' And Birthday LIKE '07%' OR ";}
  if (isset($_POST['Aug'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '8%' OR AgeGroup='".$group."' And Birthday LIKE '08%' OR ";}
  if (isset($_POST['Sep'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '9%' OR AgeGroup='".$group."' And Birthday LIKE '09%' OR ";}
  if (isset($_POST['Oct'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '10%' OR ";}
  if (isset($_POST['Nov'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '11%' OR ";}
  if (isset($_POST['Dec'])){ $query_Sort1 .="AgeGroup='".$group."' And Birthday LIKE '12%' OR ";}
  $query_Sort1_lenght2 = strlen($query_Sort1);
  if($query_Sort1_lenght1 == $query_Sort1_lenght2){
  //no birthday was selected create the string with out it
    $query_Sort1 .="AgeGroup='".$group."' OR ";
  }
  return $query_Sort1;

}

$query_Sort = "Declare Variable";
$passedSort = $_POST['Sort'];
if (!isset($passedSort)) {
  $passedSort = "LastName, FirstName";
}
$passedFilter = $_GET['Filter'];
if (!isset($passedFilter)) {
  $passedFilter = "";
}
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  //reset all other filters
  $passedFilter = "";
}
$passedColumnSet = "All";
if (isset($_POST['ColumnSetAS'])) {
  $passedColumnSet = "Attendance Sheet";
}
$query_Sort = "";
mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
  $string = $_POST['Search'];
  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM child WHERE LastName LIKE '%$string%' OR FirstName LIKE '%$string%' OR ChildID='$string' ORDER BY $passedSort ASC"; 
}
else if (isset($_POST['AllCheckedIn'])){
  $query_Sort = "SELECT * FROM child WHERE Status='Checked In' ORDER BY $passedSort ASC ";
}
else if($passedFilter != ""){
   //if last name char set then show all names beginning with that letter
   $query_Sort = "SELECT * FROM child WHERE LastName LIKE '$passedFilter%' ORDER BY $passedSort ASC "; 
}
else{
  //create string for query sort
  $query_Sort = "SELECT * FROM child WHERE ";
  if (isset($_POST['Nursery'])){ $query_Sort =check_birthday_grade($query_Sort, "Nursery");}
  if (isset($_POST['1YearOlds'])){ $query_Sort =check_birthday_grade($query_Sort, "1YearOlds");}
  if (isset($_POST['2YearOlds'])){ $query_Sort =check_birthday_grade($query_Sort, "2YearOlds");}
  if (isset($_POST['3YearOlds'])){ $query_Sort =check_birthday_grade($query_Sort, "3YearOlds");}
  if (isset($_POST['4YearOlds'])){ $query_Sort =check_birthday_grade($query_Sort, "4YearOlds");}
  if (isset($_POST['5YearOlds'])){ $query_Sort =check_birthday_grade($query_Sort, "5YearOlds");}
  if (isset($_POST['Kindergarten'])){ $query_Sort =check_birthday_grade($query_Sort, "Kindergarten");}
  if (isset($_POST['1st_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "1st_Grade");}
  if (isset($_POST['2nd_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "2nd_Grade");}
  if (isset($_POST['3rd_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "3rd_Grade");}
  if (isset($_POST['4th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "4th_Grade");}
  if (isset($_POST['5th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "5th_Grade");}
  if (isset($_POST['6th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "6th_Grade");}
  if (isset($_POST['7th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "7th_Grade");}
  if (isset($_POST['8th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "8th_Grade");}
  if (isset($_POST['9th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "9th_Grade");}
  if (isset($_POST['10th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "10th_Grade");}
  if (isset($_POST['11th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "11th_Grade");}
  if (isset($_POST['12th_Grade'])){ $query_Sort =check_birthday_grade($query_Sort, "12th_Grade");}
  if (isset($_POST['N-K'])){ $query_Sort =check_birthday_agegroup($query_Sort, "N-K");}
  if (isset($_POST['K-5'])){ $query_Sort =check_birthday_agegroup($query_Sort, "K-5");}
  if (isset($_POST['6-8'])){ $query_Sort =check_birthday_agegroup($query_Sort, "6-8");}
  if (isset($_POST['9-12'])){ $query_Sort =check_birthday_agegroup($query_Sort, "9-12");}
  //remove the last "OR "
  $length = strlen($query_Sort);
  //echo "|A|".$query_Sort . "=".$length ."|A|";
  $query_Sort_test = substr($query_Sort, $length-6, 6);
  if ($query_Sort_test == "WHERE "){
  //add a location for the query sort, if there was no selection.
  $query_Sort .="Grade='Nursery' OR ";
  }
  //redo the length and remove the last "OR "
  $length = strlen($query_Sort);
  $query_Sort = substr($query_Sort, 0, $length-3);  // returns "yy"

  //add the end of the sql query
  $query_Sort .="ORDER BY $passedSort ASC";

  
} //end else after if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {

//make sure they make a selection
$length = strlen($query_Sort);
  //echo "|END|".$query_Sort . "=".$length ."|END|";
//echo $length;
//echo $query_Sort;
if ($length > 40){
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
}
else{
  //set default page load
  $query_Sort = "SELECT * FROM child WHERE Grade='Nursery' ORDER BY $passedSort ASC"; 
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
}
//echo $query_Sort;
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
<table width="800" border="1" class="table"><tr><td>
  <table width="800" border="0" class="table">
    <tr>
      <td><a href="add.php">Add</a></td>
      <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
      <td nowrap="true">Search for </td>
      <td><input type="text" class="textbox" name="Search" size="32"></td>
      <td nowrap="true">in (FirstName OR LastName OR ChildID)</td>
      <td><input type="submit" value="GO!" class="button"></td>
      <input type="hidden" name="MM_search" value="form1">  
      </form>
    </tr>
  </table>
</td></tr></table>
		     <form action="<?php echo $editFormAction; ?>" method="POST" name="form2">
			<input type="hidden" name="MM_update" value="form2">
			<table width="800" border="1" class="table"><tr><td>
			<table width="800"  class="table" border="0">
			  <tr><td colspan="2">Set Columns to: </td>
			      <td> <input name="ColumnSetAll" id="textbox" <?php if (isset($_POST['ColumnSetAll'])){echo 'checked="checked"';}?> type="checkbox" size=26>All</td>    <td>&nbsp;</td>
			      <td> <input name="ColumnSetAS" id="textbox" <?php if (isset($_POST['ColumnSetAS'])){echo 'checked="checked"';}?> type="checkbox" size=26>Attendance Sheet</td>    <td>&nbsp;</td>
			      <td colspan="4">Today's Date is <b><?php echo date('M d, Y');?></b></td></tr>
			  
			  <tr>	<td> <input name="Nursery" id="textbox" <?php if (isset($_POST['Nursery'])){echo 'checked="checked"';}?> type="checkbox" size=26>Nursery</td>    <td>&nbsp;</td>
				<td> <input name="1YearOlds" id="textbox" <?php if (isset($_POST['1YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>1YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="2YearOlds" id="textbox" <?php if (isset($_POST['2YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>2YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="3YearOlds" id="textbox" <?php if (isset($_POST['3YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>3YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="4YearOlds" id="textbox" <?php if (isset($_POST['4YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>4YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="5YearOlds" id="textbox" <?php if (isset($_POST['5YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>5YearOlds</td>    <td>&nbsp;</td> </tr>
				<td> <input name="Kindergarten" id="textbox" <?php if (isset($_POST['Kindergarten'])){echo 'checked="checked"';}?> type="checkbox" size=26>Kindergarten</td>    <td>&nbsp;</td> </tr>
			  
			  <tr>	<td> <input name="1st_Grade" id="textbox" <?php if (isset($_POST['1st_Grade'])){echo 'checked="checked"';}?> type="checkbox" size=26>1st_Grade</td>    <td>&nbsp;</td>
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

			  <tr>	<td> <input name="N-K" id="textbox" <?php if (isset($_POST['N-K'])){echo 'checked="checked"';}?> type="checkbox" size=26>N-K</td>    <td>&nbsp;</td>
				<td> <input name="K-5" id="textbox" <?php if (isset($_POST['K-5'])){echo 'checked="checked"';}?> type="checkbox" size=26>K-5</td>    <td>&nbsp;</td>
				<td> <input name="6-8" id="textbox" <?php if (isset($_POST['6-8'])){echo 'checked="checked"';}?> type="checkbox" size=26>6-8</td>    <td>&nbsp;</td>
				<td> <input name="9-12" id="textbox" <?php if (isset($_POST['9-1'])){echo 'checked="checked"';}?> type="checkbox" size=26>9-12</td>    <td>&nbsp;</td>
				<td>&nbsp;</td>    <td>&nbsp;</td>
				<td> <input name="AllCheckedIn" id="textbox" <?php if (isset($_POST['AllCheckedIn'])){echo 'checked="checked"';}?> type="checkbox" size=26>Checked&nbsp;In</td>    <td>&nbsp;</td>  </tr>


			</table>

			<table  class="table" border="0">
			  <tr>
				<td colspan="2">Birthday</td>
				<td> <input name="Jan" id="textbox" <?php if (isset($_POST['Jan'])){echo 'checked="checked"';}?> type="checkbox" size=26>Jan</td>    <td>&nbsp;</td>
				<td> <input name="Feb" id="textbox" <?php if (isset($_POST['Feb'])){echo 'checked="checked"';}?> type="checkbox" size=26>Feb</td>    <td>&nbsp;</td>
				<td> <input name="Mar" id="textbox" <?php if (isset($_POST['Mar'])){echo 'checked="checked"';}?> type="checkbox" size=26>Mar</td>    <td>&nbsp;</td>
				<td> <input name="Apr" id="textbox" <?php if (isset($_POST['Apr'])){echo 'checked="checked"';}?> type="checkbox" size=26>Apr</td>    <td>&nbsp;</td>
				<td> <input name="May" id="textbox" <?php if (isset($_POST['May'])){echo 'checked="checked"';}?> type="checkbox" size=26>May</td>    <td>&nbsp;</td>
				<td> <input name="Jun" id="textbox" <?php if (isset($_POST['Jun'])){echo 'checked="checked"';}?> type="checkbox" size=26>Jun</td>    <td>&nbsp;</td>
				<td> <input name="Jul" id="textbox" <?php if (isset($_POST['Jul'])){echo 'checked="checked"';}?> type="checkbox" size=26>Jul</td>    <td>&nbsp;</td>
				<td> <input name="Aug" id="textbox" <?php if (isset($_POST['Aug'])){echo 'checked="checked"';}?> type="checkbox" size=26>Aug</td>    <td>&nbsp;</td>
				<td> <input name="Sep" id="textbox" <?php if (isset($_POST['Sep'])){echo 'checked="checked"';}?> type="checkbox" size=26>Sep</td>    <td>&nbsp;</td>
				<td> <input name="Oct" id="textbox" <?php if (isset($_POST['Oct'])){echo 'checked="checked"';}?> type="checkbox" size=26>Oct</td>    <td>&nbsp;</td>
				<td> <input name="Nov" id="textbox" <?php if (isset($_POST['Nov'])){echo 'checked="checked"';}?> type="checkbox" size=26>Nov</td>    <td>&nbsp;</td>
				<td> <input name="Dec" id="textbox" <?php if (isset($_POST['Dec'])){echo 'checked="checked"';}?> type="checkbox" size=26>Dec</td>    <td>&nbsp;</td>
			  </tr>

			</table>

			<table  class="table" border="0">
			  <tr valign="baseline">
				<td colspan="2">Sort Column - ASC</td>
				<td><select name="Sort" >
				<option  class="textbox" value="AgeGroup, LastName, FirstName"	<?php if ($passedSort=="AgeGroup, LastName, FirstName")	{echo 'selected';} ?>>AgeGroup,&nbsp;LastName,&nbsp;FirstName&nbsp;</option>
				<option  class="textbox" value="Birthday"			<?php if ($passedSort=="Birthday")			{echo 'selected';} ?>>Birthday&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="ChildID"			<?php if ($passedSort=="ChildID")			{echo 'selected';} ?>>ChildID&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="FirstName, LastName"		<?php if ($passedSort=="FirstName, LastName")		{echo 'selected';} ?>>FirstName,&nbsp;LastName&nbsp;&nbsp;</option>
				<option  class="textbox" value="Grade, LastName"		<?php if ($passedSort=="Grade, LastName")		{echo 'selected';} ?>>Grade,&nbsp;LastName&nbsp;&nbsp;</option>
				<option  class="textbox" value="LastName, FirstName"		<?php if ($passedSort=="LastName, FirstName")		{echo 'selected';} ?>>LastName,&nbsp;FirstName&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>
				<td colspan="6"><input type="submit" name="Update" value="Update" class="button"></td>		
			  </tr>
			  </td></tr></table>
			</table>
			<table width="800" border="1" class="table"><tr><td>
			<table width="800"  class="table" border="0">
			  <td colspan="26">Filter by Last Name:</td></tr>
			  <tr>
				<td width="5"> <a href="index.php?Filter=A">A</a></td>
				<td width="5"> <a href="index.php?Filter=B">B</a></td>
				<td width="5"> <a href="index.php?Filter=C">C</a></td>
				<td width="5"> <a href="index.php?Filter=D">D</a></td>
				<td width="5"> <a href="index.php?Filter=E">E</a></td>
				<td width="5"> <a href="index.php?Filter=F">F</a></td>
				<td width="5"> <a href="index.php?Filter=G">G</a></td>
				<td width="5"> <a href="index.php?Filter=H">H</a></td>
				<td width="5"> <a href="index.php?Filter=I">I</a></td>
				<td width="5"> <a href="index.php?Filter=J">J</a></td>
				<td width="5"> <a href="index.php?Filter=K">K</a></td>
				<td width="5"> <a href="index.php?Filter=L">L</a></td>
				<td width="5"> <a href="index.php?Filter=M">M</a></td>
				<td width="5"> <a href="index.php?Filter=N">N</a></td>
				<td width="5"> <a href="index.php?Filter=O">O</a></td>
				<td width="5"> <a href="index.php?Filter=P">P</a></td>
				<td width="5"> <a href="index.php?Filter=Q">Q</a></td>
				<td width="5"> <a href="index.php?Filter=R">R</a></td>
				<td width="5"> <a href="index.php?Filter=S">S</a></td>
				<td width="5"> <a href="index.php?Filter=T">T</a></td>
				<td width="5"> <a href="index.php?Filter=U">U</a></td>
				<td width="5"> <a href="index.php?Filter=V">V</a></td>
				<td width="5"> <a href="index.php?Filter=W">W</a></td>
				<td width="5"> <a href="index.php?Filter=X">X</a></td>
				<td width="5"> <a href="index.php?Filter=Y">Y</a></td>
				<td width="5"> <a href="index.php?Filter=Z">Z</a></td>
				<td width="5"> <a href="index.php?Filter=">All</a></td>

			  </tr>
			  </td></tr></table>
			</table>
		    </form>
			<?php if ($passedColumnSet == "All"){ ?>
			<form action="" method="get">
				<table border="1" class="table">
				<tr>
				<td>Photo</td>
				<td>Delete</td>
				<td>ChildID</td>
				<td>FirstName</td>
				<td>LastName</td>
				<td>Address</td>       
				<td>City</td>
				<td>G</td>
				<td>Grade</td>
				<td>AgeGrp</td>
				<td>Birthday</td>
				<td>Status</td>
				<td>StatusChange</td>
				<td>Allergies</td>
				<td>PID1</td>       
				<td>PID2</td>
				<td>PID3</td>
				<td>PID4</td>        
				<td>Notes</td>
				<td>Child&nbsp;ID</td>
				</tr>

			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><img height="50" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/delete.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>">delete</a></td>      
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="false"><?php echo $row_Sort['Address']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['City']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Gender']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Grade']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['AgeGroup']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Birthday']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/childinfo.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['Status']; ?></a>&nbsp;</td>
				<td align="left" nowrap="false"><?php echo $row_Sort['StatusChange']; ?>&nbsp;</td>
				<td align="left" width="75"><?php echo $row_Sort['Allergies']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID1']; ?>"><?php if($row_Sort['ParentID1']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID2']; ?>"><?php if($row_Sort['ParentID2']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID3']; ?>"><?php if($row_Sort['ParentID3']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID4']; ?>"><?php if($row_Sort['ParentID4']!=""){echo '<img height="50" src="/ParentPictures/'.$row_Sort['ParentID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" width="75"><?php echo $row_Sort['Notes']; ?>&nbsp;</td>
				<td align="left"><?php echo '<IMG SRC="/barcode.php?barcode=',$row_Sort['ChildID'], '&text=0&width=200&height=40">';?></td>
			</tr>
			
			<?php } } //first close while, second close if
			else { ?>
			<form action="" method="get">
				<table border="1" class="table">
				<tr>
				<td>Photo</td>
				<td>ChildID</td>
				<td>FirstName</td>
				<td>LastName</td>
				<td>G</td>
				<td>Birthday</td>
				<td>Allergies</td>
				<td>1PID1</td>       
				<td>2PID2</td>
				<td>3PID3</td>
				<td>4PID4</td>        
				<td>Parent Location</td>
				</tr>

			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { 
				//now check to see if the child has been here in the past three months
				$current_month = Date('m'); //get 01 - 12
				$current_year = Date('Y'); //get 01 - 12
				$child_month = substr($row_Sort['StatusChange'], 5, 2); //get 01 - 12
				$child_year = substr($row_Sort['StatusChange'], 0, 4); //get 01 - 12
				//make sure the years are the same
				//echo 'while curm ='.$current_month.': cury = '.$current_year.': chim = '.$child_month.' chiy = '.$child_year.'<br>' ;

				//If current month < 3 years are the same and years are the same
				if(($current_month<3) && ($current_year==($child_year)) && ($child_month<3)){  ?>
				<tr>
				<?php //echo 'if curm ='.$current_month.': cury = '.$current_year.': chim = '.$child_month.' chiy = '.$child_year.'<br>' ;  ?>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><img width="50" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Gender']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Birthday']; ?>&nbsp;</td>
				<td align="left" width="175"><?php echo $row_Sort['Allergies']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID1']; ?>"><?php if($row_Sort['ParentID1']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID2']; ?>"><?php if($row_Sort['ParentID2']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID3']; ?>"><?php if($row_Sort['ParentID3']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID4']; ?>"><?php if($row_Sort['ParentID4']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" width="175">&nbsp;</td>
				</tr>
				<?php } //end If current month < 3 years are the same and years are the same

				//If current month < 3 and child was here in the last three months of last year
				else if(($current_month<3) && ($current_year==$child_year+1) && ($child_month>($current_month+9))){  ?>
				<?php //echo '1st curm ='.$current_month.': cury = '.$current_year.': chim = '.$child_month.' chiy = '.$child_year.'<br>' ;  ?>
				<tr>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><img width="50" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Gender']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Birthday']; ?>&nbsp;</td>
				<td align="left" width="175"><?php echo $row_Sort['Allergies']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID1']; ?>"><?php if($row_Sort['ParentID1']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID2']; ?>"><?php if($row_Sort['ParentID2']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID3']; ?>"><?php if($row_Sort['ParentID3']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID4']; ?>"><?php if($row_Sort['ParentID4']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" width="175">&nbsp;</td>
				</tr>
				<?php } // end If current month < 3 and child was here in the last three months of last year

				//If current month < 12 and child month within 3 months of it, same year
				else if(($current_month<13) && ($current_year==$child_year) && ($child_month>$current_month-3)){  ?>
				<?php //echo '2nd curm ='.$current_month.': cury = '.$current_year.': chim = '.$child_month.' chiy = '.$child_year.'<br>' ;  ?>				
				<tr>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><img width="50" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Gender']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Birthday']; ?>&nbsp;</td>
				<td align="left" width="175"><?php echo $row_Sort['Allergies']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID1']; ?>"><?php if($row_Sort['ParentID1']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID2']; ?>"><?php if($row_Sort['ParentID2']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID3']; ?>"><?php if($row_Sort['ParentID3']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID4']; ?>"><?php if($row_Sort['ParentID4']!=""){echo '<img width="50" src="/ParentPictures/'.$row_Sort['ParentID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" width="175">&nbsp;</td>
				</tr>
				<?php } ?> 
			<?php } } //first close while, second close if ?>
				</table>
			</form>
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


