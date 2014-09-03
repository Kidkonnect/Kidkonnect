<?php //you will find all database information in childdata.php ?>
<?php
$editFormAction = $_SERVER['PHP_SELF'];
$newstatus = "x";

if ((isset($_GET["MM_update"])) && ($_GET["MM_update"] == "form1")) {
  if((isset($_GET['Status'])) && ($_GET['Status'] == "Check In")){
    $newstatus = "Checked In";
  }
  else if((isset($_GET['Status'])) && ($_GET['Status'] == "Check Out")){
    //print the parent sheet only when Checked out is set!!!
    $newstatus = "Checked Out";
    $updateSQL = sprintf("UPDATE attendance SET OutTime=%s WHERE ChildID=%s AND Date=%s",
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_GET['passedChildID'], "text"),
		       GetSQLValueString(date('m-d-Y'), "text"));

    //echo $_GET["MM_update"];
    mysql_select_db($database_dbs, $dbs);	
    //mysql_select_db($database_tvt, $tvt);
    $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());
  }
  //echo $newstatus;
  $updateSQL = sprintf("UPDATE child SET Status=%s, StatusChange=%s WHERE ChildID=%s",
                       GetSQLValueString($newstatus, "text"),
		       GetSQLValueString(date('Y/m/d H:i:s'), "text"),
                       GetSQLValueString($_GET['passedChildID'], "text"));
  //echo $_GET["MM_update"];
  mysql_select_db($database_dbs, $dbs);	
  //mysql_select_db($database_tvt, $tvt);
  $Result1 = mysql_query($updateSQL, $dbs) or die(mysql_error());

  //print the child labels only when Checked in is set!!!
  if((isset($_GET['Status'])) && ($_GET['Status'] == "Check In")){
    echo '<link rel="stylesheet" href="/printchildlabels.css" type="text/css" media="print">';
    echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
    //check to see if child is already checked in.
    mysql_select_db($database_dbs, $dbs);
    $query_Sort2 = "SELECT * FROM attendance WHERE ChildID = '".$_GET['passedChildID']."' AND Date = '".date('m-d-Y')."' ORDER BY LastName ASC"; 
    //echo $query_Sort2;
    $Sort2 = mysql_query($query_Sort2, $dbs) or die(mysql_error());
    $totalRows2 = mysql_num_rows($Sort2);
    //echo $totalRows2;
    //if $totalRows2 == 0 then this child is not checked in and we will insert a new record
    if ($totalRows2 == 0){
      //Add attendance data to data base ONLY when child is checked in
      $insertSQL = sprintf("INSERT INTO attendance (ChildID, Grade, AgeGroup, FirstName, LastName, Date, DayOfYear, InTime, Event, YearMonthDay) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_Sort['ChildID'], "text"),
		       GetSQLValueString($row_Sort['Grade'], "text"),
		       GetSQLValueString($row_Sort['AgeGroup'], "text"),
		       GetSQLValueString($row_Sort['FirstName'], "text"),
                       GetSQLValueString($row_Sort['LastName'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
                       GetSQLValueString(date('z'), "text"),
                       GetSQLValueString(date('Hi'), "text"),
		       GetSQLValueString($_GET['Event'], "text"),
                       GetSQLValueString(date('Ymd'), "text"));

      mysql_select_db($database_dbs, $dbs);
      $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 
    }
   
  }
//required to refresh query from database
//echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/childinfo.php?passedChildID=', $row_Sort['ChildID'], '">';
	$passedChildID=$row_Sort['ChildID'];
	mysql_select_db($database_dbs, $dbs);
	$query_Sort = "SELECT * FROM child WHERE ChildID = '".$passedChildID."'"; 
	$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
	$totalRows = mysql_num_rows($Sort);
	$row_Sort = mysql_fetch_assoc($Sort);
}
?>

<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
<input type="hidden" name="MM_update" value="form1">
<input type="hidden" name="passedChildID" value="<?php echo  $row_Sort['ChildID']; ?>" size="32" >
<table width="400" border="1" class="table">
  <tr>
    <td>Status</td>
    <td align="left" colspan="2"><?php echo $row_Sort['Status'];?></td>
  </tr>
  <tr>
    <td>As of</td> 
    <td align="left" colspan="2"><?php echo $row_Sort['StatusChange'];?></td>
  </tr>
  <tr>
	<td><select name="Event" class="button" >
	<option  class="button" value="Sunday" <?php if(date(D) == "Sun"){ echo 'selected';}?>>Sunday&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Encounter" <?php if(date(D) == "Wed"){ echo 'selected';}?>>Encounter&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Other">Other&nbsp;&nbsp;&nbsp;</option>
	</select></td>
<?php if($row_Sort['Status']=="Checked In"){
    	echo '<td><input type="submit" name="Status" value="Check Out" class="button"></td>';
      }
      else {
    	echo '<td><input type="submit" name="Status" value="Check In"  class="button"></td>';
      }?>
</form>
<FORM METHOD="LINK" ACTION="index.php">
    <td><input type="submit" name="Exit" value="Exit" class="button"></td>
</FORM>
  </tr>
</table>


<?php 

?>

