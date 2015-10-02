<?php include ('/var/www/Templates/database.php'); ?>
<html>
<head>

<meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, width=device-width, user-scalable=0"/>
<meta http-equiv="Content-Script-Type" content="text/javascript">
<title>Sunnybrook Child Checkin </title>
<link rel="stylesheet" href="/scc.css" type="text/css" media="handheld">
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>
<body>
<?php

  $passedSmallGroup = "";
  $CheckInFlag = 0;
//$Sort = "":
//$Sort2 = "";
if (isset($_GET['passedSmallGroup'])&&($_GET['passedSmallGroup']!='')) {
  mysql_select_db($database_dbs, $dbs);
  $passedSmallGroup = $_GET['passedSmallGroup'];
//  echo $passedSmallGroup;
//  $string = $_POST['Search'];
//  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM child WHERE SmallGroup = '".$passedSmallGroup."' ORDER BY LastName ASC"; 
  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
  //echo $query_Sort;
  
 
  
  
}
$EmailMessage = '';
/*
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
    //select the database we want to update
//    mysql_select_db($database_dbs, $dbs);
//    $query_Sort2 = "SELECT * FROM smallgroup WHERE ChildID = '".$_GET['passedChildID']."' AND Date = '".date('m-d-Y')."' ORDER BY LastName ASC"; 
//    //echo $query_Sort2;
//    $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
//    $totalRows2 = mysql_num_rows($Sort2);
//    //echo $totalRows2;
//    //if $totalRows2 == 0 then this child is not checked in and we will insert a new record
//    if ($totalRows2 == 0){
  while ($row_Sort = mysql_fetch_assoc($Sort)) {
  //find the students that were checked in and add them to the smallgroup database
    if (isset($_POST[$row_Sort['ChildID']])) { 
      echo "WE DID It";
      //CREATE TABLE `sunnybrook`.`smallgroup` (
      //`Ukey` INT NOT NULL AUTO_INCREMENT ,
      //`ChildID` TEXT NOT NULL ,
      //`Grade` TEXT NULL ,
      //`AgeGroup` TEXT NULL ,
      //`FirstName` TEXT NULL ,
      //`LastName` TEXT NULL ,
     //`Date` TEXT NULL ,
      //`YearMonthDay` TEXT NULL COMMENT 'yyyymmdd',
      //`Event` TEXT NULL ,
      //PRIMARY KEY ( `Ukey` )
      //) ENGINE = MYISAM ;
      //Add attendance data to data base ONLY when child is checked in
      $insertSQL = sprintf("INSERT INTO smallgroup (ChildID, Grade, AgeGroup, FirstName, LastName, Date, Event, YearMonthDay) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_Sort['ChildID'], "text"),
		       GetSQLValueString($row_Sort['Grade'], "text"),
		       GetSQLValueString($row_Sort['AgeGroup'], "text"),
		       GetSQLValueString($row_Sort['FirstName'], "text"),
                       GetSQLValueString($row_Sort['LastName'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
		       GetSQLValueString($_GET['Event'], "text"),
                      GetSQLValueString(date('Ymd'), "text"));

      mysql_select_db($database_dbs, $dbs);
      $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
      
    } //end If loop
  } //end While
      
//  }

}
*/
?>
<div id="web"><!--start web -->
<?php //include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	<h2 id="pageName" align="center">Sunnybrook Small Group Check In</h2>
	
	
		<?php if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) { //only print this if form was updated ?>
		  <form action="smallgroup.php?passedSmallGroup=<?php echo $passedSmallGroup; ?>" METHOD="POST" name="form2">
		    <table align="center" class="table">
			<?php 
			$EmailMessage = 'Prayers from '.$passedSmallGroup."\r\n";
			while ($row_Sort = mysql_fetch_assoc($Sort)) { 
			  //find the students that were checked in and add them to the smallgroup database
			    if (isset($_POST[$row_Sort['ChildID']])) { 
			      //echo "WE DID It";
			      if ($row_Sort['AgeGroup'] == "6-8") { $Event = "Fusion";} else { $Event = "YG"; } 
			      //Add attendance data to data base ONLY when child is checked in
			          //check to see if child is already checked in.
			      mysql_select_db($database_dbs, $dbs);
			      $query_Sort2 = "SELECT * FROM smallgroup WHERE ChildID = '".$row_Sort['ChildID']."' AND YearMonthDay = '".$_POST['EnteredDate']."' ORDER BY LastName ASC"; 
			      //echo $query_Sort2;
			      $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
			      $totalRows2 = mysql_num_rows($Sort2);
			      //echo $totalRows2;
			      //if $totalRows2 == 0 then this child is not checked in and we will insert a new record
			      if ($totalRows2 == 0){
			        //make a date variable with m-d-Y (old YYYYMMDD)
				$tempDate = substr($_POST['EnteredDate'], 4, 2).'-'.substr($_POST['EnteredDate'], 6, 2).'-'.substr($_POST['EnteredDate'], 0, 4);
			        $insertSQL = sprintf("INSERT INTO smallgroup (ChildID, Grade, AgeGroup, FirstName, LastName, Date, Event, SmallGroup, YearMonthDay) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s)",
					       GetSQLValueString($row_Sort['ChildID'], "text"),
					       GetSQLValueString($row_Sort['Grade'], "text"),
					       GetSQLValueString($row_Sort['AgeGroup'], "text"),
					       GetSQLValueString($row_Sort['FirstName'], "text"),
					       GetSQLValueString($row_Sort['LastName'], "text"),
					       GetSQLValueString($tempDate, "text"),
					       GetSQLValueString($Event, "text"),
					       GetSQLValueString($row_Sort['SmallGroup'], "text"),
					       GetSQLValueString($_POST['EnteredDate'], "text"));

			        mysql_select_db($database_dbs, $dbs);
			        $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
				$CheckInFlag = 1;
				$PostChildPrayer = $row_Sort['ChildID'].'prayers';
			        $ChildPrayer = ''.$row_Sort['FirstName'].' '.$row_Sort['LastName'].': '.$_POST[$PostChildPrayer]."\r\n";
				//echo $ChildPrayer;
				$EmailMessage = $EmailMessage.$ChildPrayer
      
			?>
			  <tr valign="baseline">
				<td colspan="2" nowrap align="center"><?php echo $row_Sort['FirstName']; ?> Was Checked In...</td>
			  </tr>
			    
			<?php } } } 
			     // first is end If totalRows2 || 2nd  is end of if isset || 3rd is While loop
			     //send email to Ryan with prayers included.
			     //$to      = 'mikehenson@hotmail.com, patti@sunnybrookcc.org';
			     $to      = 'mikehenson@hotmail.com';
			     $subject = 'Hello';
			     //$subject = 'Prayers from '.$passedSmallGroup.'\r\n';
			     $message = $EmailMessage;
			     //$message = "Hello World";
			     //$headers = 'From: noreply@kidkonnect.org'."\r\n".
			     $headers = 'From: noreply@kidkonnect.org' . "\r\n" .
			         'Content-type: text/html; charset=iso-8859-1';
			        //mail($to, $subject, $message, $headers);
			
			echo $message;
			
			?>			    
			  <tr valign="baseline">
				<td colspan="2" align="center"><?php if ($CheckInFlag) { echo '--CHECK IN WAS A SUCCESS!--';} else { echo 'No one was Checked in, this maybe they are already checked in OR no one was selected to be checked in.';}?></td>
			  </tr>
			  <tr valign="baseline">
				<td><input type="submit" name="Status" value="GO BACK"  class="button"></td>
			  </tr>
		    </table>

		  </form>
		  
		   
		<?php } else if (isset($_GET['passedSmallGroup'])&&($_GET['passedSmallGroup']!='')) { //print the update form?>
				
		  <form action="smallgroup.php?passedSmallGroup=<?php echo $passedSmallGroup; ?>" METHOD="POST" name="form1">
			  <table border="0" class="table">
				<tr>
				  <td colspan="2" nowrap align="left">Small Group = "<?php echo $passedSmallGroup; ?>" <a href="/Mobile/smallgroup.php">Clear?</a></td>
				</tr>
				<tr>
				  <td nowrap align="left">Picture</td><td nowrap align="left">Name/ID</td><td nowrap align="left">Prayers/Notes</td>
				</tr>
				
			    <?php 
					mysql_data_seek($row_Sort, 0);

					while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
					<?php
					  
						$query_smallgroup = "SELECT * FROM smallgroup WHERE ChildID = '".$row_Sort['ChildID']."' AND YearMonthDay = '".date('Ymd')."' ORDER BY LastName ASC"; 
			      //echo $query_smallgroup;
			      $smallgroup = mysql_query($query_smallgroup, $dbs) or die(mysql_error());
						$row_smallgroup = mysql_fetch_assoc($smallgroup);
						//echo $row_smallgroup['ChildID'];
			      $totalsmallgroup = mysql_num_rows($smallgroup);
						//echo $totalsmallgroup;
					?>
					<td align="left"><img height="100" src="/ChildPictures/<?php echo $row_Sort['ChildID']; ?>.jpg" ></a></td>
				  <td><?php echo $row_Sort['ChildID']; ?>&nbsp;<br><?php echo $row_Sort['FirstName']; ?>&nbsp;<br><?php echo $row_Sort['LastName']; ?>&nbsp;<br>
				    <input name="<?php echo $row_Sort['ChildID']; ?>" id="textbox" <?php if ($totalsmallgroup!=0){echo 'checked="checked"';}?> type="checkbox" size=25></td>
				</tr>
			    <?php } //close while?>
			      <?php if (isset($_SESSION['MM_AccessLevel'])){ 
			        // only show the date field when a person is logged into the system ?>
				<tr>
				  <td>Date YYYYMMDD: </td>
				  <td><input type="text" class="textbox" name="EnteredDate" value="<?php echo date('Ymd'); ?>" size="10"></td>
				</tr>
				<?php }
				   else {
				     //hide the date field ?>
				     <input type="hidden" class="textbox" name="EnteredDate" value="<?php echo date('Ymd'); ?>" size="10"></td>
				   
				<?php }?>
				
				<tr>
				  <td><input type="submit" value="Check In Students" class="button"></td>
				  <input type="hidden" name="MM_update" value="form1">  
				</tr>				    

			  </table>
	
		  </form>
		  
		<?php } else { //end else if statment, just search the child database for any small groups
		  mysql_select_db($database_dbs, $dbs);
		//  $passedSmallGroup = $_GET['passedSmallGroup'];
		//  echo $passedSmallGroup;
		//  $string = $_POST['Search'];
		//  $column = $_POST['Column'];
		  $query_Sort = "SELECT * FROM child WHERE SmallGroup LIKE '%' ORDER BY SmallGroup ASC"; 
		  $Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());

		  //echo $query_Sort;
		  $SmallGroup = ""; ?>
		  <table border="0" class="table">
		    <tr valign="baseline">
			<td colspan="2" nowrap align="center">Available Small Groups:</td>
		    </tr>
	  	    <?php while ($row_Sort = mysql_fetch_assoc($Sort)) { 
		      if ($row_Sort['SmallGroup'] != $SmallGroup) {?>
			<tr>
			  <td colspan="2" nowrap align="left"><a href="/Mobile/smallgroup.php?passedSmallGroup=<?php echo $row_Sort['SmallGroup']; ?>"><?php echo $row_Sort['SmallGroup']; ?></a></td>
			</tr>
		      <?php } //end if
		      $SmallGroup = $row_Sort['SmallGroup'];
		    } //close while?>
		  </table>
  		<?php } //end else?>

		
	</div> <!--end content -->
   <div id="sidebar" ><!--start sidebar -->
   	  <div class="relatedLinks"><!--start relatedLinks -->
        	<?php //include ('/var/www/Templates/sidebar.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>