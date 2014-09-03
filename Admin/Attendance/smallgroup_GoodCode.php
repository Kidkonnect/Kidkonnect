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

$searchmonth1 = date(m);
$searchyear1 = date(Y) - 1;
$searchmonth2 = date(m);
$searchyear2 = date(Y);
$searchdayofyear1 = " ";
$searchdayofyear2 = " ";
$YearMonthDay1 = $searchyear1.$searchmonth1.'50';
$YearMonthDay2 = $searchyear2.$searchmonth2.'50';
$searchEvent = '%';
//echo $YearMonthDay1;
//echo $YearMonthDay2;
$Sort_LastName = " ";
$query_Sort = " ";

if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
  $string = $_POST['Search'];
  //make sure the lenght of month is two
  if ((isset($_POST["SearchMonth1"])) && ($_POST["SearchMonth1"] != "Month")){
    $searchmonth1 = $_POST["SearchMonth1"];
    //$searchdayofyear1 = (($searchmonth1 - 1) * 30); //used to calculate the day of year 
    $length = strlen($searchmonth1);
    if ($length < 2) {$searchmonth1 = '0'.$searchmonth1;}
  }else {$searchmonth1 = date(m);}
  if ((isset($_POST["SearchYear1"])) && ($_POST["SearchYear1"] != "Year")){
    $searchyear1 = $_POST["SearchYear1"];
    $length = strlen($searchyear1);
    if ($length < 4) {$searchyear1 = '20'.$searchyear1;}
  }else {$searchyear1 = Date(Y) - 1 ;}
  if ((isset($_POST["SearchMonth2"])) && ($_POST["SearchMonth2"] != "Month")){
    $searchmonth2 = $_POST["SearchMonth2"];
    $searchmonth2 = $searchmonth2 + 1; //add for month between 2 and 5 needs to include 5
    //$searchdayofyear2 = (($searchmonth2) * 30); //used to calculate the day of year
    $length = strlen($searchmonth2);
    if ($length < 2) {$searchmonth2 = '0'.$searchmonth2;}
  }else {$searchmonth2 = date(m);}
  if ((isset($_POST["SearchYear2"])) && ($_POST["SearchYear2"] != "Year")){
    $searchyear2 = $_POST["SearchYear2"];
    $length = strlen($searchyear2);
    if ($length < 4) {$searchyear2 = '20'.$searchyear2;}
  }else {$searchyear2 = Date(Y);}
  if (isset($_POST['YGOnly'])){
    $searchEvent = 'YG';
  }
  if (isset($_POST['FusOnly'])){
    $searchEvent = 'Fusion';
  }
  //check to see if both are selected
  if ((isset($_POST['FusOnly'])) && (isset($_POST['YGOnly']))){
    $searchEvent = '%';
  }
  
  //echo $searchEvent;
  
  //build the YearMonthDay values
  $YearMonthDay1 = $searchyear1.$searchmonth1.'50';
  $YearMonthDay2 = $searchyear2.$searchmonth2.'50';
  
             $query_Sort = "SELECT * FROM smallgroup WHERE 
	       LastName LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       FirstName LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       SmallGroup LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       ChildID='$string' AND Event = '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY YearMonthDay ASC";
	        
	     $query_Sort_LastName = "SELECT * FROM smallgroup WHERE
     	       LastName LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       FirstName LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       SmallGroup LIKE '%$string%' AND Event LIKE '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' OR 
	       ChildID='$string' AND Event = '$searchEvent' AND YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY LastName, FirstName ASC";  
  
  
}
else { //grab the last 3 months
  //make sure the lenght of month is two
             $query_Sort = "SELECT * FROM smallgroup WHERE YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY YearMonthDay ASC";
	        
	     $query_Sort_LastName = "SELECT * FROM smallgroup WHERE YearMonthDay BETWEEN '$YearMonthDay1' AND '$YearMonthDay2' ORDER BY LastName, FirstName ASC"; 
	       
	       
  //echo $query_Sort_LastName;
  $Sort_LastName = mysql_query($query_Sort_LastName, $dbs) or die(mysql_error());
}
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
$Sort_LastName = mysql_query($query_Sort_LastName, $dbs) or die(mysql_error());
//echo $query_Sort;
//echo $Sort_LastName;

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
    <form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
    <tr>
      <td nowrap="true">Search for 
         <input type="text" class="textbox" value="<?php if (isset($_POST["Search"])){echo $_POST["Search"];}?>"name="Search" size="32">
         in FirstName OR LastName OR ChildID OR SmallGroup OR (Leave Blank)</td>
    </tr>
    <tr>
      <td nowrap="true"> Event/Age 
           <input name="YGOnly" id="textbox" <?php if (isset($_POST['YGOnly'])){echo 'checked="checked"';}?> type="checkbox" size=26>YG 
	   <input name="FusOnly" id="textbox" <?php if (isset($_POST['FusOnly'])){echo 'checked="checked"';}?> type="checkbox" size=26>Fusion </td>
    </tr>
    <tr>
      <td nowrap="true"> Group 
              <?php
	      mysql_select_db($database_dbs, $dbs);
	      //$passedSmallGroup = $_GET['passedSmallGroup'];
	      //echo $passedSmallGroup;
	      //$string = $_POST['Search'];
	      //$column = $_POST['Column'];
	        $query_Sort2 = "SELECT * FROM child WHERE SmallGroup LIKE '%' ORDER BY SmallGroup ASC"; 
	        $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
	        //echo $query_Sort;
	        $SmallGroup = ""; ?>
	        <table border="0" class="table" width="400">
	          <?php 
		    $count = 0;
		    while ($row_Sort2 = mysql_fetch_assoc($Sort2)) { 
		      if ($row_Sort2['SmallGroup'] != $SmallGroup) { 
		        $count++; 
			if ($count == 9){echo '<br>'; $count = 0;}?>
			<tr>
			  <input name="<?php echo $row_Sort2['SmallGroup']; ?>" id="textbox" <?php if (isset($_POST[$row_Sort2['SmallGroup']])){echo 'checked="checked"';}?> type="checkbox" size=26><?php echo $row_Sort2['SmallGroup']; ?> 
			</tr>
		      <?php } //end if
		      $SmallGroup = $row_Sort2['SmallGroup'];
		    } //close while
	          ?>
	        </table>
          </td>
    </tr>
    <tr>
      <td nowrap="true">Display attandance from 
        <input type="text" class="textbox" value="<?php if (isset($_POST["SearchMonth1"])){echo $_POST["SearchMonth1"];}else {echo 'Month';} ?>" name="SearchMonth1" size="10">
        <input type="text" class="textbox" value="<?php if (isset($_POST["SearchYear1"])){echo $_POST["SearchYear1"];}else {echo 'Year';} ?>" name="SearchYear1" size="10">
        to
        <input type="text" class="textbox" value="<?php if (isset($_POST["SearchMonth2"])){echo $_POST["SearchMonth2"];}else {echo 'Month';} ?>" name="SearchMonth2" size="10">
        <input type="text" class="textbox" value="<?php if (isset($_POST["SearchYear2"])){echo $_POST["SearchYear2"];}else {echo 'Year';} ?>" name="SearchYear2" size="10">
	<input type="submit" value="GO!" class="button"></td>
        <input type="hidden" name="MM_search" value="form1">  
    </tr>
    </form>
  </td></tr></table>
</table>
		     
		<?php  //END if(($passedMonth != "")|($passedYear != ""))
		      if(1){
		      //if((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form3")){ ?>
			<form action="" method="get">
				<table width="300" border="1" class="table">
				<tr align="center">
				<td nowrap="true" align="right">ChildID</td>       
				<td nowrap="true" align="left">First Name</td>       
				<td nowrap="true" align="left">Last Name</td>       
				<td nowrap="true" align="left">Group</td>       
				<td nowrap="true" align="left">Event</td>       
				
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
			    //echo '<td><a href="/Admin/Attendance/index.php?Date='.$arraydate[$count].'">'.$TempString.'</a></td>';
			    echo '<td>'.$TempString.'</td>';
			    //$row_Sort = mysql_fetch_assoc($Sort);
			    
			    $count++;
			    $arraydate[$count] = $row_Sort['Date'];
			  }
			}//<?php echo $date;
			//now we need to print out the event on the next row
			//echo '</tr><tr align="center">';//bring the table down a line
			//print blanks in the ChildID First and Last name columns.
			//echo '<td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>';
			for ($i = 0; $i <= $count; $i++) {
			    //only use the first 5 letters i.e. Sun Enc
			    $TempString = substr($arrayevent[$i], 0, 5);
			  //echo '<td>'.$TempString.'</td>';
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
			  $TempString2 = substr($row_Sort_LastName['Event'], 0, 5);
			  echo '<td align="right">'.$row_Sort_LastName['ChildID'].'</td><td align="left">'.$row_Sort_LastName['FirstName'].'</td><td align="left">'.$row_Sort_LastName['LastName'].'</td><td align="left">'.$row_Sort_LastName['SmallGroup'].'</td><td align="left">'.$TempString2.'</td>';
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


