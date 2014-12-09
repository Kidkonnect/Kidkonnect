<?php //you will find all database information in childdata.php ?>
<?php
$newstatus = "x";

if ((isset($_POST["Preview"])) && ($_POST["Preview"] != "")) {
  
    //echo '<link rel="stylesheet" href="/printvolunteerlabels.css" type="text/css" media="print">';
    echo '<SCRIPT language="JavaScript">window.printpreview()</SCRIPT>';
    //required to refresh query from database
    //echo 'nsIWebBrowserPrint::PrintPreview()';
}
else if ((isset($_GET["PrintVBadge"])) && ($_GET["PrintVBadge"] != "")) {
  
    //echo '<link rel="stylesheet" href="/printvolunteerlabels.css" type="text/css" media="print">';
    echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
    //required to refresh query from database
    //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/index.php">';
}
else if ((isset($_POST["PrintPID"])) && ($_POST["PrintPID"] != "")) {
  
    //echo '<link rel="stylesheet" href="/printvolunteerlabels.css" type="text/css" media="print">';
    echo '<SCRIPT language="JavaScript">window.print()</SCRIPT>';
    //required to refresh query from database
    //echo '<meta HTTP-EQUIV="REFRESH" content="0; url=http://192.168.12.158/index.php">';
}

?>


<table width="400" border="0" class="table">
<form action="parentinfo.php" METHOD="POST" name="form1">
<input type="hidden" name="PrintVBadge" value="form1">
<input type="hidden" name="passedParentID" value="<?php echo  $row_Sort['ParentID']; ?>" size="32" >
  <tr>
	<td><select name="Event" class="button">
	<option  class="button" value="Nursery/Preschool" selected>Nursery/Preschool&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Kids Church">Kids Church&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Counter">Counter&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Communion">Communion&nbsp;&nbsp;&nbsp;</option>
	<option  class="button" value="Other">Other&nbsp;&nbsp;&nbsp;</option>
	</select></td>
    	<td><input type="submit" name="Status" value="Print Volunteer Badge"  class="button"></td>
</form>
  </tr>

<form action="parentinfo.php" METHOD="POST" name="form2">
<input type="hidden" name="PrintPID" value="form2">
<input type="hidden" name="passedParentID" value="<?php echo  $row_Sort['ParentID']; ?>" size="32" >
  <tr>
	<td>&nbsp;</td>
    	<td><input type="submit" name="Status" value="Print Parent ID"  class="button"></td>
</form>


<form action="parentinfo.php" METHOD="POST" name="form3">
<input type="hidden" name="Preview" value="form3">
<input type="hidden" name="passedParentID" value="<?php echo  $row_Sort['ParentID']; ?>" size="32" >
  <tr>
	<td>&nbsp;</td>
    	<td><input type="submit" name="Status" value="Preview Parent ID"  class="button"></td>
</form>


<FORM METHOD="LINK" ACTION="index.php">
    <td><input type="submit" name="Exit" value="Exit" class="button"></td>
</FORM>

  </tr>
</table>
<?php 

?>

