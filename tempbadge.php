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
$tempID = 0;
//check the attandace for next avalible Temp ID.
//Temp IDs will be between 10 and 99.
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  //select the database
  mysql_select_db($database_dbs, $dbs);
  $date = date('m-d-Y');
  $query_Sort = "SELECT * FROM attendance WHERE Date='$date' AND ChildID BETWEEN 10 AND 99 ORDER BY ChildID DESC"; 
  $query_Name = "SELECT * FROM attendance WHERE Date='$date' AND ChildID BETWEEN 10 AND 99 ORDER BY ChildID DESC"; 
  //set the sort of the sql query
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  $Sort_Name = mysql_query($query_Name, $dbs) or die(mysql_error());
  //this will gengerate the AgeGroup data, there are to many "Visitors" with incorrect agegroups
  $AgeGroup = "";
  //if same lenght, then no Grade or age group was selected, remove the "AND"
  $Grade = substr($_POST['Grade'], 4, 5);  //looking to only get "Grade" from 1st_Grade
  if ($Grade == "Grade") { //We found our 1-5 Agegroup
    $AgeGroup = "1-5";
  }
  else { //we have a "N-K" age group
    $AgeGroup = "N-K";
  }
  //echo 'number'.mysql_num_rows($Sort);
  //make sure the Sort is not empty (first child of the day)
  $AllreadyCheckedInFlag = 0;
  if (mysql_num_rows($Sort)==0){
    //give this child an ID of 10
    $tempID = 10;
    //insert the new information into the attendace table
    echo '<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">';
    echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
      //Add attendance data to data base ONLY when child is checked in
    $insertSQL = sprintf("INSERT INTO attendance (ChildID, Grade, AgeGroup, FirstName, LastName, Date, YearMonthDay, DayOfYear, InTime, Event, ParentEmail) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($tempID, "text"),
		       GetSQLValueString($_POST['Grade'], "text"),
		       GetSQLValueString($AgeGroup, "text"),
		       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
                       GetSQLValueString(date('Ymd'), "text"),
                       GetSQLValueString(date('z'), "text"),
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_POST['Event'], "text"),
                       GetSQLValueString($_POST['ParentEmail'], "text"));

    mysql_select_db($database_dbs, $dbs);
    $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
  }//end if (mysql_num_rows($Sort)==0){
  else {//check to see if child was allready checked in
    while ($row_Sort = mysql_fetch_assoc($Sort_Name)) {
      if (($_POST['FirstName'] == $row_Sort['FirstName']) && ($_POST['LastName'] == $row_Sort['LastName'])) {
          $AllreadyCheckedInFlag = 1;
    	  echo '<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">';
    	  echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
          //now update the attandace database and on
  		$updateSQL = sprintf("UPDATE attendance SET Grade=%s, AgeGroup=%s, FirstName=%s, LastName=%s, YearMonthDay=%s, DayOfYear=%s, InTime=%s, Event=%s, ParentEmail=%s WHERE Date=%s AND ChildID=%s",
		       GetSQLValueString($_POST['Grade'], "text"),
		       GetSQLValueString($AgeGroup, "text"),
		       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString(date('Ymd'), "text"),
                       GetSQLValueString(date('z'), "text"),
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_POST['Event'], "text"),
                       GetSQLValueString($_POST['ParentEmail'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
                       GetSQLValueString($row_Sort['ChildID'], "text"));

  		mysql_select_db($database_dbs, $dbs);
  		$Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
      }
    }
    if ($AllreadyCheckedInFlag == 0){
      //get the first row, The data was formated in DESC order so the first should be the highest ChildID
      $row_Sort = mysql_fetch_assoc($Sort);
      //give this child the last ID entered plus one
      $tempID = $row_Sort['ChildID'] + 1;
      //insert the new information into the attendace table
      echo '<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">';
      echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
        //Add attendance data to data base ONLY when child is checked in
      $insertSQL = sprintf("INSERT INTO attendance (ChildID, Grade, AgeGroup, FirstName, LastName, Date, YearMonthDay, DayOfYear, InTime, Event, ParentEmail) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                      GetSQLValueString($tempID, "text"),
		       GetSQLValueString($_POST['Grade'], "text"),
		       GetSQLValueString($AgeGroup, "text"),
		       GetSQLValueString($_POST['FirstName'], "text"),
                       GetSQLValueString($_POST['LastName'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
                       GetSQLValueString(date('Ymd'), "text"),
                       GetSQLValueString(date('z'), "text"),
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_POST['Event'], "text"),
                       GetSQLValueString($_POST['ParentEmail'], "text"));

      mysql_select_db($database_dbs, $dbs);
      $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
    }//end if (mysql_num_rows($Sort)==0){
  }
  
  //Now we need to email Staff members of new visitors
  //this requires "sudo apt-get install sendmail" 
   $to      = 'mikehenson@hotmail.com, patti@sunnybrookcc.org';
   $subject = 'New Visitor to Sunnybrook';
   $message = '
Date: '.date('m/d/Y').'
Child Name:'.$_POST['FirstName'].' '.$_POST['LastName'].'
Child Temp ID:'.$tempID.'
Child Grade:'.$_POST['Grade'].'
Child AgeGroup:'.$_POST['AgeGroup'].'
Child Allergies:'.$_POST['Allergies'].'
Parent Name:'.$_POST['PFirstName'].' '.$_POST['PLastName'].'
Parent email:'.$_POST['ParentEmail'].'
Event:'.$_POST['Event'].'
';
   $headers = 'From: noreply@kidkonnect.org' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

   //mail($to, $subject, $message, $headers);

  //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/">';

}//end if MM_Update


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
			<table border="0" class="table">
		  
		     <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
			<input type="hidden" name="MM_update" value="form1">
			 <tr>
			  	<td nowrap align="right" width="150">* Child's First Name</td>
				<td><input name="FirstName" id="textbox" value="<?php echo  $_POST['FirstName']; ?>" type="text" size=26></td>
			 </tr>
			 <tr>
			  	<td nowrap align="right" width="150">* Child's Last Name</td>
				<td><input name="LastName" id="textbox" value="<?php echo  $_POST['LastName']; ?>" type="text" size=26></td>
			 </tr>
			 <tr>
			  	<td nowrap align="right">* Grade:</td>
			    	<td><select name="Grade" class="button">
			  	<option  class="button" value="Nursery" selected>Nursery&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="1YearOlds" >1YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="2YearOlds" >2YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="3YearOlds" >3YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="4YearOlds" >4YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="5YearOlds" >5YearOlds&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="1st_Grade" >1st_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="2nd_Grade" >2nd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="3rd_Grade" >3rd_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="4th_Grade" >4th_Grade&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="5th_Grade" >5th_Grade&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>

			    <tr>
				<td nowrap align="right">* Event:</td>
				<td><select name="Event" class="button">
				<option  class="button" value="Sunday" <?php if(date(D) == "Sun"){ echo 'selected';}?>>Sunday&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="Encounter" <?php if(date(D) == "Wed"){ echo 'selected';}?>>Encounter&nbsp;&nbsp;&nbsp;</option>
				<option  class="button" value="Other">Other&nbsp;&nbsp;&nbsp;</option>
				</select></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Allergies:</td>
				<td><input type="text" class="textbox" name="Allergies" value="none" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Parent's First Name:</td>
				<td><input type="text" class="textbox" name="PFirstName" value="<?php echo  $_POST['PFirstName']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Parent's Last Name:</td>
				<td><input type="text" class="textbox" name="PLastName" value="<?php echo  $_POST['PLastName']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">* Parent's Email Address:</td>
				<td><input type="text" class="textbox" name="ParentEmail" value="<?php echo  $_POST['ParentEmail']; ?>" size="32"></td>
			  </tr>
			  <tr valign="baseline">
				<td nowrap align="right">&nbsp;</td>
				<td><input style="font-size: 28px;" type="submit" name="Status" id="textbox" value="Check In"></td>
			  
		    </form>
		    <form ACTION= "/index.php"  METHOD="POST" name="index"> 
			    <td><font>&nbsp;<input style="font-size: 28px;" type="submit" name="exit" id="textbox" value="Exit"></font></td>
			    </tr> 
		    </form>
			</table>
		    
		    
		<SCRIPT language="JavaScript">
			document.form1.FirstName.focus();
		</SCRIPT>
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



</body>

<div id="printchildlabels">
  <?php include ('/var/www/printtempbadge.php'); ?>
</div>
</html>
