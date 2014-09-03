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
mysql_select_db($database_dbs, $dbs);
$passedDate = $_GET['Date']; //get the exact date passed in the url
if (!isset($passedDate)) {
	$passedDate = "";
}
$passedSort = $_POST["Sort"];
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
  $string = $_POST['Search'];
  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM attendance WHERE LastName LIKE '%$string%' OR FirstName LIKE '%$string%' OR ChildID='$string' ORDER BY LastName ASC"; 
}
else if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form2")) {
  //make sure the lenght of month is two
  $searchmonth = " ";
  $searchday = " ";
  $searchyear = " ";
  if ((isset($_POST["SearchMonth"])) && ($_POST["SearchMonth"] != "Month")){
    $searchmonth = $_POST["SearchMonth"];
    $length = strlen($searchmonth);
    if ($length < 2) {$searchmonth = '0'.$searchmonth;}
  }else {$searchmonth = '%';}
  if ((isset($_POST["SearchDay"])) && ($_POST["SearchDay"] != "Day")){
    $searchday = $_POST["SearchDay"];
    $length = strlen($searchday);
    if ($length < 2) {$searchday = '0'.$searchday;}
  }else {$searchday = '%';}
  if ((isset($_POST["SearchYear"])) && ($_POST["SearchYear"] != "Year")){
    $searchyear = $_POST["SearchYear"];
    $length = strlen($searchyear);
    if ($length < 4) {$searchyear = '20'.$searchyear;}
  }else {$searchyear = '%';}
  if((isset($_POST["SearchMonth"])) && (isset($_POST["SearchDay"])) && (isset($_POST["SearchYear"])))
  $query_Sort = "SELECT * FROM attendance WHERE Date LIKE '$searchmonth-$searchday-$searchyear' ORDER BY LastName ASC"; 
  //echo $query_Sort;
} 

else if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form3")) {
  //make sure the lenght of month is two
  $searchmonth1 = " ";
  $searchyear1 = " ";
  $searchmonth2 = " ";
  $searchyear2 = " ";
  $searchdayofyear1 = " ";
  $searchdayofyear2 = " ";
  if ((isset($_POST["SearchMonth1"])) && ($_POST["SearchMonth1"] != "Month")){
    $searchmonth1 = $_POST["SearchMonth1"];
    //$searchdayofyear1 = (($searchmonth1 - 1) * 30); //used to calculate the day of year 
    $length = strlen($searchmonth1);
    if ($length < 2) {$searchmonth1 = '0'.$searchmonth1;}
  }else {$searchmonth1 = '00';}
  if ((isset($_POST["SearchYear1"])) && ($_POST["SearchYear1"] != "Year")){
    $searchyear1 = $_POST["SearchYear1"];
    $length = strlen($searchyear1);
    if ($length < 4) {$searchyear1 = '20'.$searchyear1;}
  }else {$searchyear1 = Date(Y);}
  if ((isset($_POST["SearchMonth2"])) && ($_POST["SearchMonth2"] != "Month")){
    $searchmonth2 = $_POST["SearchMonth2"];
    $searchmonth2 = $searchmonth2 + 1; //add for month between 2 and 5 needs to include 5
    //$searchdayofyear2 = (($searchmonth2) * 30); //used to calculate the day of year
    $length = strlen($searchmonth2);
    if ($length < 2) {$searchmonth2 = '0'.$searchmonth2;}
  }else {$searchmonth2 = '00';}
  if ((isset($_POST["SearchYear2"])) && ($_POST["SearchYear2"] != "Year")){
    $searchyear2 = $_POST["SearchYear2"];
    $length = strlen($searchyear2);
    if ($length < 4) {$searchyear2 = '20'.$searchyear2;}
  }else {$searchyear2 = Date(Y);}
  //build the YearMonthDay values
  $YearMonthDay1 = $searchyear1.$searchmonth1.'00';
  $YearMonthDay2 = $searchyear2.$searchmonth2.'00';
  if (isset($_POST["Visitors"])){
    //want only visitors shown
             $query_Sort = "SELECT * FROM attendance WHERE ChildID<100 AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY YearMonthDay ASC"; 
    $query_Sort_LastName = "SELECT * FROM attendance WHERE ChildID<100 AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY LastName, FirstName ASC"; 
  }
  else{
             $query_Sort = "SELECT * FROM attendance WHERE YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY YearMonthDay ASC"; 
    $query_Sort_LastName = "SELECT * FROM attendance WHERE YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY LastName, FirstName ASC"; 
  }
  //echo $query_Sort;
  //echo $query_Sort_LastName;
  $Sort_LastName = mysql_query($query_Sort_LastName, $dbs) or die(mysql_error());
}
//else last sunday we need to find what is the currnet day an then find out what last sunday was
else if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form4")) {
  //find the day of year for last sunday
  $day_of_year = Date('z');
  $day_of_week = Date('w');
  $month = Date('m'); //get 01 - 12
  //get this year
  $year = Date('Y'); //gets 2010
  $Last_Sunday = 0;
  $Last_Encounter = 0;
  //create string for query sort
  $query_Sort = "SELECT * FROM attendance WHERE ";
  $string_base = ""; //base is used for the day information
  $string_part = ""; // part is used for the grade and age group

  //check to see if date was manually entered in
  if ((isset($_POST["SearchMonth"])) && ($_POST["SearchMonth"] != "Month (mm)")){
    //make sure the lenght of month is two
    $searchmonth = " ";
    $searchday = " ";
    $searchyear = " ";
     
    $searchmonth = $_POST["SearchMonth"];
    //echo $searchmonth;
    $length = strlen($searchmonth);
    if ($length < 2) {$searchmonth = '0'.$searchmonth;}
    //now check on Day
    if ((isset($_POST["SearchDay"])) && ($_POST["SearchDay"] != "Day (dd)")){
    $searchday = $_POST["SearchDay"];
    //echo $searchday;
    $length = strlen($searchday);
    if ($length < 2) {$searchday = '0'.$searchday;}
    }//else {$searchday = '%';}//used to make day wide card
    //now check on year
    if ((isset($_POST["SearchYear"])) && ($_POST["SearchYear"] != "Year (yy)")){
    $searchyear = $_POST["SearchYear"];
    //echo $searchyear;
    $length = strlen($searchyear);
    if ($length < 4) {$searchyear = '20'.$searchyear;}
    }//else {$searchyear = '%';}//used to make year wide card
    $string_base .= "Date LIKE '$searchmonth-$searchday-$searchyear' AND "; 
    //echo $string_base;
  }
  else if ((isset($_POST["SelectDay"])) && ($_POST["SelectDay"] == "LastEncounter")){
    //take everything to Sunday which is 0 then add 3 to get Wen
    if($day_of_year < 4){
      $Last_Encounter = 365 + $day_of_year - $day_of_week;
      $year = $year - 1;
    }
    else {$Last_Encounter = $day_of_year - $day_of_week + 3;}
    
    //now find any entries with that day
    $string_base .="DayOfYear='$Last_Encounter' AND Date LIKE '%-%-$year' AND ";
  }
  else { //do lastSunday
    if($day_of_year < 7){
      $Last_Sunday = 365 + $day_of_year - $day_of_week;
      $year = $year - 1;
    }
    else {$Last_Sunday = $day_of_year - $day_of_week;}
    //echo $day_of_year.' '. $day_of_week.' '. $Last_Sunday;
    $string_base .="DayOfYear='$Last_Sunday' AND Date LIKE '%-%-$year' AND ";
  }
  if (isset($_POST["Visitors"])){
    //want only visitors shown
    $string_base .="ChildID<100 AND ";
  }
  //look for time only slots 
  if ((isset($_POST["0900"])) && ($_POST["SelectDay"] == "LastSunday")){
    //get everyone that checked in before 0900
    $string_base .="InTime<0900 AND ";
  }
  else if ((isset($_POST["1020"])) && ($_POST["SelectDay"] == "LastSunday")){
    //get everyone that checked in after 1020
    $string_base .="InTime>1020 AND ";
  } 
  else if ((isset($_POST["0901"]))&& ($_POST["SelectDay"] == "LastSunday")){
    //get everyone that checked in between 0900 and 1020
    $string_base .="InTime BETWEEN 0900 AND 1020 AND ";
  } 
  //now find any entries with that day
  //get the leght of query so we can see what items were selected
  $string_base_lenght = strlen($string_base);
  //create string for query sort
  if (isset($_POST['Nursery'])){ $string_part .= $string_base."Grade='Nursery' OR ";}
  if (isset($_POST['1YearOlds'])){ $string_part .= $string_base."Grade='1YearOlds' OR ";}
  if (isset($_POST['2YearOlds'])){ $string_part .= $string_base."Grade='2YearOlds' OR ";}
  if (isset($_POST['3YearOlds'])){ $string_part .= $string_base."Grade='3YearOlds' OR ";}
  if (isset($_POST['4YearOlds'])){ $string_part .= $string_base."Grade='4YearOlds' OR ";}
  if (isset($_POST['5YearOlds'])){ $string_part .= $string_base."Grade='5YearOlds' OR ";}
  if (isset($_POST['1st_Grade'])){ $string_part .= $string_base."Grade='1st_Grade' OR ";}
  if (isset($_POST['2nd_Grade'])){ $string_part .= $string_base."Grade='2nd_Grade' OR ";}
  if (isset($_POST['3rd_Grade'])){ $string_part .= $string_base."Grade='3rd_Grade' OR ";}
  if (isset($_POST['4th_Grade'])){ $string_part .= $string_base."Grade='4th_Grade' OR ";}
  if (isset($_POST['5th_Grade'])){ $string_part .= $string_base."Grade='5th_Grade' OR ";}
  if (isset($_POST['6th_Grade'])){ $string_part .= $string_base."Grade='6th_Grade' OR ";}
  if (isset($_POST['7th_Grade'])){ $string_part .= $string_base."Grade='7th_Grade' OR ";}
  if (isset($_POST['8th_Grade'])){ $string_part .= $string_base."Grade='8th_Grade' OR ";}
  if (isset($_POST['9th_Grade'])){ $string_part .= "$string_base.Grade='9th_Grade' OR ";}
  if (isset($_POST['10th_Grade'])){ $string_part .= $string_base."Grade='10th_Grade' OR ";}
  if (isset($_POST['11th_Grade'])){ $string_part .= $string_base."Grade='11th_Grade' OR ";}
  if (isset($_POST['12th_Grade'])){ $string_part .= $string_base."Grade='12th_Grade' OR ";}
  
  if (isset($_POST['N-K'])){ $string_part .= $string_base."AgeGroup='N-K' OR ";}
  if (isset($_POST['1-5'])){ $string_part .= $string_base."AgeGroup='1-5' OR ";}
  if (isset($_POST['6-8'])){ $string_part .= $string_base."AgeGroup='6-8' OR ";}
  if (isset($_POST['9-12'])){ $string_part .= $string_base."AgeGroup='9-12' OR ";}

  //get the lenght of base and compare it to part to see if items were selected
  $string_part_lenght = strlen($string_part);
  if($string_part_lenght == 0){
    //there is no $string_part, so add $string_base to $query_Sort
    $query_Sort .= $string_base;
    //if same lenght, then no Grade or age group was selected, remove the "AND"
    $length = strlen($query_Sort);
    $query_Sort = substr($query_Sort, 0, $length-4);  //remove the "AND"
  }
  else {//now put all the strings together!!!
    $query_Sort .= $string_part;
    //redo the length and remove the last "OR "
    $length = strlen($query_Sort);
    $query_Sort = substr($query_Sort, 0, $length-3);  // returns "yy"
  }
  //add the end of the sql query (Missing the "OR" on the front of Order
  $query_Sort .="ORDER BY $passedSort ASC";
  //SELECT * FROM attendance WHERE DayOfYear=249 ORDER BY Lastname ASC
  //over write any other data if This Month Totals OR This Year Totals are selected
  if (isset($_POST["ThisMonthTotals"])){
    //get this month
    $month = Date('m'); //get 01 - 12
    //get this year
    $year = Date('Y'); //gets 2010
    $query_Sort = "SELECT * FROM attendance WHERE Date LIKE '$month-%-$year' ORDER BY Date AND AgeGroup ASC"; 
  }
  if (isset($_POST["ThisYearTotals"])){
    //get this year
    $year = Date('Y'); //gets 2010
    $query_Sort = "SELECT * FROM attendance WHERE Date LIKE '%-%-$year' ORDER BY Date AND AgeGroup ASC"; 
  }
}
else if($passedDate != ""){
  //get this year
  //$year = Date('Y'); //gets 2010
  $query_Sort = "SELECT * FROM attendance WHERE Date = '$passedDate' ORDER BY LastName ASC"; 
}
else{
  $day_of_year = Date('z');
  $day_of_week = Date('w');
  $Last_Sunday = 0;
  $year = Date('Y'); //gets 2010

  if($day_of_year < 7){
    $Last_Sunday = 365 + $day_of_year - $day_of_week;
    $year = $year - 1;
  }
  else {$Last_Sunday = $day_of_year - $day_of_week;}
  //echo $day_of_year.' '. $day_of_week.' '. $Last_Sunday;  
  //$query_Sort = "SELECT * FROM attendance WHERE DayOfYear='$Last_Sunday' ORDER BY ChildID ASC"; 
  $query_Sort ="SELECT * FROM attendance WHERE DayOfYear='$Last_Sunday' AND Date LIKE '%-%-$year' ORDER BY LastName ASC";
  //echo 'default';
}
//echo $query_Sort;
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
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
<table width="800" border="1" class="table"><tr><td>
  <table width="800" border="0" class="table">
    <tr>
      <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form3">
      <td nowrap="true">Display attandance from </td>
      <td><input type="text" class="textbox" value="<?php if (isset($_POST["SearchMonth1"])){echo $_POST["SearchMonth1"];}else {echo 'Month';} ?>" name="SearchMonth1" size="10"></td>
      <td><input type="text" class="textbox" value="<?php if (isset($_POST["SearchYear1"])){echo $_POST["SearchYear1"];}else {echo 'Year';} ?>" name="SearchYear1" size="10"></td>
      <td nowrap="true">to</td>
      <td><input type="text" class="textbox" value="<?php if (isset($_POST["SearchMonth2"])){echo $_POST["SearchMonth2"];}else {echo 'Month';} ?>" name="SearchMonth2" size="10"></td>
      <td><input type="text" class="textbox" value="<?php if (isset($_POST["SearchYear2"])){echo $_POST["SearchYear2"];}else {echo 'Year';} ?>" name="SearchYear2" size="10"></td>
      <td> <input name="Visitors" id="textbox" <?php if (isset($_POST['Visitors'])){echo 'checked="checked"';}?> type="checkbox" size=26>Only Visitors</td>    <td>&nbsp;</td>
      <td><input type="submit" value="GO!" class="button"></td>
      <input type="hidden" name="MM_search" value="form3">  
      </form>
    </tr>
  </td></tr></table>
</table>
		     <form action="<?php echo $editFormAction; ?>" method="POST" name="form4">
			<input type="hidden" name="MM_update" value="form4">
			<table width="800" border="1" class="table"><tr><td>
			<table width="800" class="table" border="0">
			  <tr valign="baseline">
 				<td>Select Day</td><td>&nbsp;</td>
				<td><select name="SelectDay" >
				<option  class="textbox" value="LastSunday"   <?php if (isset($_POST['LastSunday']))  {echo 'selected';} ?>>Last&nbsp;Sunday&nbsp;&nbsp;&nbsp;</option> 
				<option  class="textbox" value="LastEncounter" <?php if (isset($_POST['LastEncounter'])){echo 'selected';} ?>>Last&nbsp;Encounter&nbsp;&nbsp;&nbsp;</option>
				</select></td><td>&nbsp;</td>
				<td><input type="text" class="textbox" value="<?php if ((isset($_POST["SearchMonth"])) && ($_POST["SearchMonth"] != "Month (mm)")) {echo $_POST["SearchMonth"];}else {echo 'Month (mm)';}?>"  name="SearchMonth" size="10"></td>    <td>&nbsp;</td>
				<td><input type="text" class="textbox" value="<?php if ((isset($_POST["SearchDay"]))   && ($_POST["SearchDay"]   != "Day (dd)"))   {echo $_POST["SearchDay"];  }else {echo 'Day (dd)';}?>"    name="SearchDay"   size="10"></td>    <td>&nbsp;</td>
				<td><input type="text" class="textbox" value="<?php if ((isset($_POST["SearchYear"]))  && ($_POST["SearchYear"]  != "Year (yyyy)")){echo $_POST["SearchYear"]; }else {echo 'Year (yyyy)';}?>" name="SearchYear"  size="10"></td>    <td>&nbsp;</td>
			  </tr>

			  <tr>	<td> <input name="0900" id="textbox" <?php if (isset($_POST['0900'])){echo 'checked="checked"';}?> type="checkbox" size=26>8:30 (Before 9:00)</td>     <td>&nbsp;</td>
				<td> <input name="0901" id="textbox" <?php if (isset($_POST['0901'])){echo 'checked="checked"';}?> type="checkbox" size=26>9:45 (9:00 - 10:20)</td>    <td>&nbsp;</td>
				<td> <input name="1020" id="textbox" <?php if (isset($_POST['1020'])){echo 'checked="checked"';}?> type="checkbox" size=26>11:00 (After 10:20)</td>    <td>&nbsp;</td></tr>
			  
			  <tr>	<td> <input name="Nursery"   id="textbox" <?php if (isset($_POST['Nursery']))  {echo 'checked="checked"';}?> type="checkbox" size=26>Nursery</td>      <td>&nbsp;</td>
				<td> <input name="1YearOlds" id="textbox" <?php if (isset($_POST['1YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>1YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="2YearOlds" id="textbox" <?php if (isset($_POST['2YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>2YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="3YearOlds" id="textbox" <?php if (isset($_POST['3YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>3YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="4YearOlds" id="textbox" <?php if (isset($_POST['4YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>4YearOlds</td>    <td>&nbsp;</td>
				<td> <input name="5YearOlds" id="textbox" <?php if (isset($_POST['5YearOlds'])){echo 'checked="checked"';}?> type="checkbox" size=26>5YearOlds</td>    <td>&nbsp;</td> </tr>
			  
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
				<td> <input name="1-5" id="textbox" <?php if (isset($_POST['1-5'])){echo 'checked="checked"';}?> type="checkbox" size=26>1-5</td>    <td>&nbsp;</td>
				<td> <input name="6-8" id="textbox" <?php if (isset($_POST['6-8'])){echo 'checked="checked"';}?> type="checkbox" size=26>6-8</td>    <td>&nbsp;</td>
				<td> <input name="9-12" id="textbox" <?php if (isset($_POST['9-1'])){echo 'checked="checked"';}?> type="checkbox" size=26>9-12</td>    <td>&nbsp;</td>
				<td> <input name="Visitors" id="textbox" <?php if (isset($_POST['Visitors'])){echo 'checked="checked"';}?> type="checkbox" size=26>Only Visitors</td>    <td>&nbsp;</td></tr>

			  <tr valign="baseline">
				<td colspan="2">Sort Column - ASC</td>
				<td><select name="Sort" >
				<option  class="textbox" value="LastName"   <?php if ($passedSort=="LastName")  {echo 'selected';} ?>>LastName&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="FirstName" <?php if ($passedSort=="FirstName"){echo 'selected';} ?>>FirstName&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="ChildID"  <?php if ($passedSort=="ChildID") {echo 'selected';} ?>>ChildID&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="Grade"     <?php if ($passedSort=="Grade")    {echo 'selected';} ?>>Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="AgeGroup"  <?php if ($passedSort=="AgeGroup") {echo 'selected';} ?>>AgeGroup&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="Birthday"  <?php if ($passedSort=="Birthday") {echo 'selected';} ?>>Birthday&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="InTime"  <?php if ($passedSort=="InTime") {echo 'selected';} ?>>InTime&nbsp;&nbsp;&nbsp;</option>
				<option  class="textbox" value="OutTime"  <?php if ($passedSort=="OutTime") {echo 'selected';} ?>>OutTime&nbsp;&nbsp;&nbsp;</option>
				</select></td><td>&nbsp;</td>
			  	<td> <input name="ThisMonthTotals" id="textbox" <?php if (isset($_POST['ThisMonthTotals'])){echo 'checked="checked"';}?> type="checkbox" size=26>This Month Totals</td>    <td>&nbsp;</td>
				<td> <input name="ThisYearTotals" id="textbox" <?php if (isset($_POST['ThisYearTotals'])){echo 'checked="checked"';}?> type="checkbox" size=26>This Year Totals</td>    <td>&nbsp;</td></tr>

				<td colspan="6"><input type="submit" name="Update" value="Update" class="button"></td>		
			  </tr>
			  </td></tr></table>
			</table>
			  <tr><td colspan="3">Total in query is <?php echo mysql_num_rows($Sort);?></td></tr>
		      </form>
			<br>
		<?php if((isset($_POST['ThisMonthTotals']))|(isset($_POST['ThisYearTotals']))){ ?>
			<form action="" method="get">
				<table width="300" border="1" class="table">
				<tr>
				<td>Date</td>       
				<td>AgeGroup</td>       
				<td>Totals</td>
				<td>Event</td>
				</tr>
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) {
			//get the date and AgeGroup
			$date = $row_Sort['Date'];
			//get the AgeGroup
			$AgeGroup = $row_Sort['AgeGroup'];
			$Event = $row_Sort['Event'];
			//set count to zero
			$count = 0;
			//keep count while date and age are equal to first one
			while (($date == $row_Sort['Date'])&($AgeGroup == $row_Sort['AgeGroup'])){
			  $count++;
			  //get next row_Sort
			  $row_Sort = mysql_fetch_assoc($Sort);
			}//end while(($date == $row_Sort['Date'])&($AgeGroup = $row_Sort['AgeGroup']))
			?>
				<tr>
				<td align="left"><a href="/Admin/Attendance/index.php?Date=<?php echo $date; ?>"><?php echo $date; ?></a>&nbsp;</td>
				<td align="left"><?php echo $AgeGroup; ?>&nbsp;</td>
				<td align="left"><?php echo $count; ?>&nbsp;</td>
				<td align="left"><?php echo $Event; ?>&nbsp;</td>
				</tr>
			
			<?php } ?> 
				</table>
			</form>
		<?php } //END if(($passedMonth != "")|($passedYear != ""))
		      else if((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form3")){ ?>
			<form action="" method="get">
				<table width="300" border="1" class="table">
				<tr align="center">
				<td nowrap="true" align="right">ChildID</td>       
				<td nowrap="true" align="left">First Name</td>       
				<td nowrap="true" align="left">Last Name</td>       
				
			<?php
			
			//get the first date and print to the screen as a row
			$count = 0;
			$arraydate[]=array();  //array to hold all dates found
			$arrayevent[]=array();  //array to hold all events found (used as second line in table)
			$arraydate[$count] = "0";
			//go through data and find all dates and print them to the screen
			while ($row_Sort = mysql_fetch_assoc($Sort)){
			  //row sort is ordered by the date, so step through all entries and pull out only when the date changes
			  if ($arraydate[$count] == $row_Sort['Date']){
			    //do nothing
			    //echo $row_Sort['Date'];
			  }
			  else {
			    //add the new date we found to the arraydate
			    $arraydate[$count] = $row_Sort['Date'];
			    //add the new event to that matches date to $arrayevent
			    $arrayevent[$count] = $row_Sort['Event'];	
			    //parse off the year from the table
			    $TempString = substr($arraydate[$count], 0, 5);
			    //print the date to the screen 
			    echo '<td><a href="/Admin/Attendance/index.php?Date='.$arraydate[$count].'">'.$TempString.'</a></td>';
			    //$row_Sort = mysql_fetch_assoc($Sort);
			    
			    $count++;
			    $arraydate[$count] = $row_Sort['Date'];
			  }
			}//<?php echo $date;
			//now we need to print out the event on the next row
			echo '</tr><tr align="center">';//bring the table down a line
			//print blanks in the ChildID First and Last name columns.
			echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
			for ($i = 0; $i <= $count; $i++) {
			    //only use the first 3 letters i.e. Sun Enc
			    $TempString = substr($arrayevent[$i], 0, 3);
			  echo '<td>'.$TempString.'</td>';
			}
			echo '</tr><tr align="center">';//bring the table down a line
			//$rowposition is used to keep track of the position of mysql_fetch_assoc(sort)
			$rowposition = 0;
			$totalrows = mysql_num_rows($Sort_LastName);
			//count now gives us all the columns plus FirstName and LastName
			while ($row_Sort_LastName = mysql_fetch_assoc($Sort_LastName)){
			  //row sort last name is the same database info as row_sort but ordered by last name
			  $currentLastName = $row_Sort_LastName['LastName'];
			  //so we shold be able to step through it a put an "X" where the date match
			  //print the first name and last name
			  echo '<td align="right">'.$row_Sort_LastName['ChildID'].'</td><td align="left">'.$row_Sort_LastName['FirstName'].'</td><td align="left">'.$row_Sort_LastName['LastName'].'</td>';
			  for ($i=0; $i<$count; $i++) {
			    //count is the total number of date used, so when we hit the end we go to the next kid in Sort lastname
			    if ($arraydate[$i] == $row_Sort_LastName['Date']){
			      //prnt an "X" for the kid being here	
			      echo '<td>X</td>';
			      //if we get a date we now need the next item in the query
			      $row_Sort_LastName = mysql_fetch_assoc($Sort_LastName);
			      //check to see if next fetch is different, if they are different, EXIT for loop
			      if (($row_Sort_LastName['LastName']) != ($currentLastName)) {
				//but before we leave, we need to fill the rest of the row with "blanks"
				for ($j=$i+1; $j<$count; $j++) {
				  echo '<td>&nbsp;</td>';
				}
				$i = $count; // to exit for loop above  "for ($i=0; $i<$count; $i++) "
			      } 
			      $rowposition++;
			    }
			    else {
			      //print a blank because the kids were not here.
			      echo '<td>&nbsp;</td>';
			      //echo '<td>'.$arraydate[$i].'|'.$row_Sort_LastName['Date'].'|'.$rowposition.'</td>';
			    }
			  }
			  //before the next kid, we need to go back one on the mysql_fetch_assoc to account for the double dip in for loop
			  //also check for the last row, if on last row do not decrement or it will cause endless loop
			  //if($totalrows>$rowposition){$rowposition--;}
			  //bring the table back to the start for thenext kid
			  mysql_data_seek($Sort_LastName, $rowposition);
			  echo '</tr><tr align="center">';//bring the table down a line
			  
			}//end while(($date == $row_Sort['Date'])&($AgeGroup = $row_Sort['AgeGroup']))
			 ?> 
				</table>
			</form>
		<?php } //END if(($passedMonth != "")|($passedYear != ""))
		      else{ ?>
			<form action="" method="get">
				<table width="900" border="1" class="table">
				<tr>
				<?php//<td><a href="index.php?Sort=UKey&EventSort=<?php echo $passedEvent">UKey</a></td>?>
				<td>ChildID</td>
				<td>FirstName</td>
				<td>LastName</td>
				<td>Date</td>       
				<td>Grade</td>       
				<td>AgeGroup</td>       
				<td>InTime</td>       
				<td>OutTime</td>       
				<td>Event</td>
				<td>ParentEmail</td>
				</tr>
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
				<?php//<td align="left"><?php echo $row_Sort['UKey']; &nbsp;</td>?>
				<td align="left"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID']; ?>"><?php echo $row_Sort['ChildID']; ?></a>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left"><a href="/Admin/Attendance/index.php?Date=<?php echo $row_Sort['Date']; ?>"><?php echo $row_Sort['Date']; ?></a>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['Grade']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['AgeGroup']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['InTime']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['OutTime']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['Event']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['ParentEmail']; ?>&nbsp;</td>
			</tr>
			
			<?php } ?> 
				</table>
			</form>

		<?php } //END else  ?>
		  </div>
		<SCRIPT language="JavaScript">
			document.form1.Search.focus();
		</SCRIPT>
		  <!--end feature -->
	    </div> 
	  <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php include ('/var/www/Templates/sidebar.php'); ?>
		<?php include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


