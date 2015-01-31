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

$passedSort = $_GET['Sort']; //ParentID, Firstname, LastName
if (!isset($passedSort)) {
	$passedSort = "LastName";
}
$passedEvent = $_GET['EventSort']; //Sunday Encounter
if (!isset($passedEvent)) {
	$passedEvent = "";
}
$passedVolunteerLocation = $_GET['VolunteerLocationSort']; //N-K, K-5
if (!isset($passedVolunteerLocation)) {
	$passedVolunteerLocation = "";
}
$passedVolunteerTitle = $_GET['VolunteerTitleSort']; //1stVolunteerTitle, 2ndVolunteerTitle
if (!isset($passedVolunteerTitle)) {
	$passedVolunteerTitle = "";
}
$passedInTime = $_GET['TimeSort']; //8:30
if (!isset($passedInTime)) {
	$passedInTime = "";
}
$passedMonth = $_GET['ThisMonth']; //last month totals
if (!isset($passedMonth)) {
	$passedMonth = "";
}
$passedYear = $_GET['ThisYear']; //Last year totals
if (!isset($passedYear)) {
	$passedYear = "";
}
$passedDate = $_GET['Date']; //Last year totals
if (!isset($passedDate)) {
	$passedDate = "";
}
mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
  $string = $_POST['Search'];
  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM volunteerattendance WHERE LastName LIKE '%$string%' OR FirstName LIKE '%$string%' OR ParentID='$string' ORDER BY $passedSort ASC"; 
}
//else last sunday we need to find what is the currnet day an then find out what last sunday was
else if ($passedEvent == "Last Sunday"){
  $day_of_year = Date('z');
  $day_of_week = Date('w');
  $Last_Sunday = 0;
  if($day_of_year < 7){$Last_Sunday = 365 + $day_of_year - $day_of_week;}
  else {$Last_Sunday = $day_of_year - $day_of_week;}
  //echo $day_of_year.' '. $day_of_week.' '. $Last_Sunday;
  //now find any entries with that day
  //SELECT * FROM volunteerattendance WHERE DayOfYear=249 ORDER BY Lastname ASC
    if($passedVolunteerLocation != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND VolunteerLocation LIKE '%$passedVolunteerLocation%' ORDER BY $passedSort ASC"; 
    }
    else if($passedVolunteerTitle != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND VolunteerTitle='$passedVolunteerTitle' ORDER BY $passedSort ASC"; 
    }
    else if($passedInTime != ""){
	if($passedInTime == "0900"){
		//get everyone that checked in before 0900
		$query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND InTime<'$passedInTime' ORDER BY $passedSort ASC";
	}
	else if($passedInTime == "1020"){
		//get everyone that checked in after 1020
		$query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND InTime>'$passedInTime' ORDER BY $passedSort ASC";
	} 
	else{
		//get everyone that checked in between 0900 and 1020
		$query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND InTime BETWEEN 0900 AND 1020 ORDER BY $passedSort ASC";
	} 
    }
    else{
  	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' ORDER BY $passedSort ASC"; 
    }
}

else if ($passedEvent == "Last Encounter"){
  $day_of_year = Date('z');
  $day_of_week = Date('w');
  $Last_Sunday = 0;
  //take everything to Sunday which is 0 then add 3 to get Wen
  if($day_of_year < 4){$Last_Sunday = 365 + $day_of_year - $day_of_week;}
  else {$Last_Sunday = $day_of_year - $day_of_week + 3;}
  //now find any entries with that day
    if($passedVolunteerLocation != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND VolunteerLocation LIKE '%$passedVolunteerLocation%' ORDER BY $passedSort ASC"; 
    }
    else if($passedVolunteerTitle != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' AND VolunteerTitle='$passedVolunteerTitle' ORDER BY $passedSort ASC"; 
    }
    else{
  	  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' ORDER BY $passedSort ASC"; 
    }
}
else if($passedMonth != ""){
  //get this month
  $month = Date('m'); //get 01 - 12
  //get this year
  $year = Date('Y'); //gets 2010
  $query_Sort = "SELECT * FROM volunteerattendance WHERE Date LIKE '$month-%-$year' ORDER BY Date AND VolunteerLocation ASC"; 
}
else if($passedYear != ""){
  //get this year
  $year = Date('Y'); //gets 2010
  $query_Sort = "SELECT * FROM volunteerattendance WHERE Date LIKE '%-%-$year' ORDER BY Date AND VolunteerLocation ASC"; 
}
else if($passedDate != ""){
  //get this year
  //$year = Date('Y'); //gets 2010
    if($passedVolunteerLocation != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE Date='$passedDate' AND VolunteerLocation LIKE '%$passedVolunteerLocation%' ORDER BY $passedSort ASC"; 
    }
    else if($passedVolunteerTitle != ""){
	  $query_Sort = "SELECT * FROM volunteerattendance WHERE Date='$passedDate' AND VolunteerTitle='$passedVolunteerTitle' ORDER BY $passedSort ASC"; 
    }
    else if($passedInTime != ""){
	if($passedInTime == "0900"){
		//get everyone that checked in before 0900
		$query_Sort = "SELECT * FROM volunteerattendance WHERE Date='$passedDate' AND InTime<'$passedInTime' ORDER BY $passedSort ASC";
	}
	else if($passedInTime == "1020"){
		//get everyone that checked in after 1020
		$query_Sort = "SELECT * FROM volunteerattendance WHERE Date='$passedDate' AND InTime>'$passedInTime' ORDER BY $passedSort ASC";
	} 
	else{
		//get everyone that checked in between 0900 and 1020
		$query_Sort = "SELECT * FROM volunteerattendance WHERE Date='$passedDate' AND InTime BETWEEN 0900 AND 1020 ORDER BY $passedSort ASC";
	} 
    }
    else{
		$query_Sort = "SELECT * FROM volunteerattendance WHERE Date = '$passedDate' ORDER BY $passedSort ASC"; 
    }
}
else{
  $day_of_year = Date('z');
  $day_of_week = Date('w');
  $Last_Sunday = 0;
  if($day_of_year < 7){$Last_Sunday = 365 + $day_of_year - $day_of_week;}
  else {$Last_Sunday = $day_of_year - $day_of_week;}
  $query_Sort = "SELECT * FROM volunteerattendance WHERE DayOfYear='$Last_Sunday' ORDER BY $passedSort ASC"; 
  //echo $query_Sort;
}
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Admin Section</h2>
		  <div class="feature">
<table width="400" border="0" class="table">
<tr>
<td><a href="add.php">Add</a></td>
<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
<td nowrap="true">Search for </td>
<td><input type="text" class="textbox" name="Search" size="32"></td>
<td nowrap="true">in (FirstName OR LastName OR ParentID)</td>
<td><input type="submit" value="GO!" class="button"></td>
<input type="hidden" name="MM_search" value="form1">  
</form>
</tr>
</table>
			<table width="800" class="table" border="1">

			  <tr>	
				<td nowrap="true">Start with:</td>
				<td nowrap="true"> <a href="index.php?Sort=<?php echo $passedSort ?>&EventSort=Last Sunday">Last Sunday</a>&nbsp;&nbsp;&nbsp;</td>
				<td nowrap="true"> <a href="index.php?Sort=<?php echo $passedSort ?>&EventSort=Last Encounter">Last Encounter</a>&nbsp;&nbsp;&nbsp;</td>
				<td nowrap="true"> <a href="index.php?Sort=<?php echo $passedSort ?>&ThisMonth=Month">This Month Totals</a>&nbsp;&nbsp;&nbsp;</td>
				<td nowrap="true"> <a href="index.php?Sort=<?php echo $passedSort ?>&ThisYear=Year">This Year Totals</a>&nbsp;&nbsp;&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
			  </tr>
			  <tr>	
				<td nowrap="true">All that came to any of the:</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
				<td nowrap="true">&nbsp;</td>
			  </tr>
			  <tr>	
				<td nowrap="true">Then filter by Title:</td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Nursery">Nursery</a></td>
			  	<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Ones">Ones</a></td>
			  	<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Twos">Twos</a></td>
			  	<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Threes">Threes</a></td>
			 	<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Fours">Fours</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Fives">Fives</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=Kindergarten">Kindergarten</a></td>
			  </tr>
			  <tr>	
				<td nowrap="true">&nbsp;</td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=1st_VolunteerTitle">1st_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=2nd_VolunteerTitle">2nd_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=3rd_VolunteerTitle">3rd_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=4th_VolunteerTitle">4th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=5th_VolunteerTitle">5th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=6th_VolunteerTitle">6th_Grade</a></td>
			  </tr>
			  <tr>	
				<td nowrap="true">&nbsp;</td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=7th_VolunteerTitle">7th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=8th_VolunteerTitle">8th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=9th_VolunteerTitle">9th_Grade</a></tdv>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=10th_VolunteerTitle">10th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=11th_VolunteerTitle">11th_Grade</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerLocationSort=12th_VolunteerTitle">12th_Grade</a></td>
			  </tr>
			  <tr>	
				<td nowrap="true">&nbsp;</td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerTitleSort=Supervisor">Supervisor</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerTitleSort=Teacher">Teacher</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&Date=<?php echo $passedDate; ?>&VolunteerTitleSort=Helper">Helper</a></tdv>
				<td nowrap="true">&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>	
				<td nowrap="true">OR Filter by Check in Time:</td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&Date=<?php echo $passedDate; ?>&TimeSort=0900">8:30 (Before 9:00)</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&Date=<?php echo $passedDate; ?>&TimeSort=0901">9:45 (9:00 - 10:20)</a></td>
				<td> <a href="index.php?Sort=<?php echo $passedSort; ?>&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&Date=<?php echo $passedDate; ?>&TimeSort=1020">11:00 (After 10:20)</a></tdv>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr><td colspan="7">Filters are: <?php echo 'Sort = '.$passedSort.'; EventSort = '.$passedEvent.'; VolunteerLocationSort = '.$passedVolunteerLocation.'; VolunteerTitleSort = '.$passedVolunteerTitle.'; Date = '.$passedDate.'; TimeSort = '.$passedInTime.';';?></td></tr>
			  <tr><td colspan="4">&nbsp;Or <a href="index.php">Clear all Filters</a></td><td colspan="3">Total in query is <?php echo mysql_num_rows($Sort);?></td></tr>
			<br>
		<?php if(($passedMonth != "")|($passedYear != "")){ ?>
			<form action="" method="get">
				<table width="300" border="1" class="table">
				<tr>
				<td>Date</td>       
				<td>VolunteerLocation</td>       
				<td>Totals</td>
				<td>Event</td>
				</tr>
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) {
			//get the date and VolunteerLocation
			$date = $row_Sort['Date'];
			//get the VolunteerLocation
			$VolunteerLocation = $row_Sort['VolunteerLocation'];
			$Event = $row_Sort['Event'];
			//set count to zero
			$count = 0;
			//keep count while date and age are equal to first one
			while (($date == $row_Sort['Date'])&($VolunteerLocation == $row_Sort['VolunteerLocation'])){
			  $count++;
			  //get next row_Sort
			  $row_Sort = mysql_fetch_assoc($Sort);
			}//end while(($date == $row_Sort['Date'])&($VolunteerLocation = $row_Sort['VolunteerLocation']))
			?>
				<tr>
				<td align="left"><a href="/Admin/VolunteerAttendance/index.php?Date=<?php echo $date; ?>"><?php echo $date; ?></a>&nbsp;</td>
				<td align="left"><?php echo $VolunteerLocation; ?>&nbsp;</td>
				<td align="left"><?php echo $count; ?>&nbsp;</td>
				<td align="left"><?php echo $Event; ?>&nbsp;</td>
				</tr>
			
			<?php } ?> 
				</table>
			</form>
		<?php } //END if(($passedMonth != "")|($passedYear != ""))
		      else{ ?>
			<form action="" method="get">
				<table width="900" border="1" class="table">
				<tr>
				<?php//<td><a href="index.php?Sort=UKey&EventSort=<?php echo $passedEvent">UKey</a></td>?>
				<td><a href="index.php?Sort=ParentID&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">ParentID</a></td>
				<td><a href="index.php?Sort=FirstName&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">FirstName</a></td>
				<td><a href="index.php?Sort=LastName&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">LastName</a></td>
				<td><a href="index.php?Sort=Date&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">Date</a></td>       
				<td><a href="index.php?Sort=VolunteerTitle&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">VolunteerTitle</a></td>       
				<td><a href="index.php?Sort=VolunteerLocation&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">VolunteerLocation</a></td>       
				<td><a href="index.php?Sort=InTime&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">InTime</a></td>       
				<td><a href="index.php?Sort=OutTime&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">OutTime</a></td>       
				<td><a href="index.php?Sort=Event&EventSort=<?php echo $passedEvent; ?>&VolunteerLocationSort=<?php echo $passedVolunteerLocation; ?>&VolunteerTitleSort=<?php echo $passedVolunteerTitle; ?>&TimeSort=<?php echo $passedInTime; ?>">Event</a></td>
				</tr>
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
				<?php//<td align="left"><?php echo $row_Sort['UKey']; &nbsp;</td>?>
				<td align="left"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID']; ?>"><?php echo $row_Sort['ParentID']; ?></a>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left"><a href="/Admin/VolunteerAttendance/index.php?Date=<?php echo $row_Sort['Date']; ?>"><?php echo $row_Sort['Date']; ?></a>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['VolunteerTitle']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['VolunteerLocation']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['InTime']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['OutTime']; ?>&nbsp;</td>
				<td align="left"><?php echo $row_Sort['Event']; ?>&nbsp;</td>
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


