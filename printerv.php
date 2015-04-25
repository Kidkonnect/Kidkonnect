<?php
      //Add attendance data to data base ONLY when volunteer is checked in
    $insertSQL = sprintf("INSERT INTO volunteerattendance (ParentID, VolunteerLocation, VolunteerTitle, FirstName, LastName, Date, DayOfYear, InTime, Event) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($row_Sort['ParentID'], "text"),
		       GetSQLValueString($row_Sort['VolunteerLocation'], "text"),
		       GetSQLValueString($row_Sort['VolunteerTitle'], "text"),
		       GetSQLValueString($row_Sort['FirstName'], "text"),
                       GetSQLValueString($row_Sort['LastName'], "text"),
                       GetSQLValueString(date('m-d-Y'), "text"),
                       GetSQLValueString(date('z'), "text"),
                       GetSQLValueString(date('Hi'), "text"),
                       GetSQLValueString($_GET['Event'], "text"));

    mysql_select_db($database_dbs, $dbs);
    $Result1 = mysql_query($insertSQL, $dbs) or die(mysql_error()); 



?>
   <table width="480" height="240"  border="0" class="table" >
      <tr>
        <td colspan="2" align="left"><?php echo '<img width="200" height="130" src="/ParentPictures/', $row_Sort['ParentID'], '.jpg">';?></td>
	<td>
	<table>
          <tr>
            <td align="left" nowrap="true"><h1><?php echo $row_Sort['FirstName'];?></h1></td>
            <td align="left" nowrap="true"><h1><?php echo $row_Sort['LastName'];?></h1></td>
          </tr>
          <tr>
	    <td colspan="2" align="left" nowrap="true"><h1><?php echo $row_Sort['VolunteerTitle'];?></h1></td>
          </tr>
          <tr>
            <td colspan="2" align="left" nowrap="true"><h1><?php echo $row_Sort['VolunteerLocation'];?></h1></td>
          </tr>
          <tr>
            <td colspan="2" nowrap="true"><h1><?php //echo $_POST['Event'];?></h1></td>
          </tr>
	</table>
	</td>
      </tr>
  </table>

