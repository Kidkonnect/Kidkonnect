<?php include ('/var/www/Templates/database.php'); ?>
<?php //include ('/var/www/Access/accessadmin.php'); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Sunnybrook Child Checkin Admin pages</title>
<link rel="stylesheet" href="/scc.css" type="text/css" >
<link rel="stylesheet" href="/print.css" type="text/css" media="print">

</head>

<?php
function getchilds($passedChildID, $database_dbs2, $dbs2){
//this gets the childs first name and prints it
/*
mysql_select_db($database_tvt, $tvt);
$query_computerdata = sprintf("SELECT * FROM computerdata WHERE TerrahawkSN = '%s'", $colname_computerdata);
$computerdata = mysql_query($query_computerdata, $tvt) or die(mysql_error());
$row_computerdata = mysql_fetch_assoc($computerdata);
$totalRows_computerdata = mysql_num_rows($computerdata);
*/
	mysql_select_db($database_dbs2, $dbs2); //database already selected
	$query_Sort2 = "SELECT * FROM child WHERE ChildID = '".$passedChildID."'"; 
	$Sort2 = mysql_query($query_Sort2, $dbs2) or die(mysql_error());
	$totalRows2 = mysql_num_rows($Sort2);
	$row_Sort2 = mysql_fetch_assoc($Sort2);
//Put the data on the sreen
if($totalRows2 !=0){
echo '<table width="75" border="0" class="table">';
  echo '<tr><td><a href="/Admin/Child/edit.php?passedChildID=', $row_Sort2['ChildID'], '"><img width="75" src = "/ChildPictures/', $row_Sort2['ChildID'], '.jpg"></a></td>';
  echo '<td></tr><tr><td>'.$row_Sort2['FirstName'].'</td></tr>';
echo '</table>';
}
else{
echo '<table width="75" border="0" class="table">';
  echo '<tr><td><img width="75" src = "/ChildPictures/0.jpg"></td>';
  echo '<td></tr><tr><td>No&nbsp;Child</td></tr>';
echo '</table>';
}
  //echo $totalRows2;
  //echo $row_Sort2['FirstName'];
  //echo $passedChildID;

} 
?>
<body>
<?php

$passedSort = $_GET['Sort'];
if (!isset($passedSort)) {
	$passedSort = "LastName";
}
$passedFilter = $_GET['Filter'];
if (!isset($passedFilter)) {
  $passedFilter = "A";
}
mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1")) {
  $string = $_POST['Search'];
  $column = $_POST['Column'];
  $query_Sort = "SELECT * FROM parent WHERE LastName LIKE '%$string%' OR FirstName LIKE '%$string%' OR ParentID='$string' ORDER BY $passedSort ASC"; 
}
else if($passedFilter != ""){
  $query_Sort = "SELECT * FROM parent WHERE LastName LIKE '$passedFilter%' ORDER BY $passedSort ASC"; 
}
else{
  $query_Sort = sprintf("SELECT * FROM parent ORDER BY $passedSort ASC"); 
  //echo $query_Sort;
}
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Welcome to Sunnybrook Pictorial Directory</h2>
		  <div class="feature">
<table width="400" border="0" class="table">
<tr>
<form action="<?php echo $editFormAction; ?>" METHOD="POST" name="form1">
<td nowrap="true">Search for </td>
<td><input type="text" class="textbox" name="Search" size="32"></td>
<td nowrap="true">in (FirstName OR LastName OR ParentID)</td>
<td><input type="submit" value="GO!" class="button"></td>
<input type="hidden" name="MM_search" value="form1">  
</form>
</tr>
</table>
			<table class="table">
			  <tr><td colspan="25">Filter by Adult Last Name:</td></tr>
			  <tr>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=A">A</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=B">B</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=C">C</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=D">D</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=E">E</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=F">F</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=G">G</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=H">H</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=I">I</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=J">J</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=K">K</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=L">L</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=M">M</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=N">N</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=O">O</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=P">P</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=Q">Q</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=R">R</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=S">S</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=T">T</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=U">U</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=V">V</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=W">W</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=X">X</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=Y">Y</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=Z">Z</a></td>
				<td width="5"> <a href="index.php?Sort=<?php echo $passedSort; ?>&Filter=">All</a></td>

			  </tr>
			</table>
			<br>
			<form action="" method="get">
				<table border="0" class="table">
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr><TD>
				    <table>
					<tr>
					<td align="left" nowrap="true" colspan="2"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID']; ?>&Filter=<?php echo $passedFilter; ?>&Sort=<?php echo $passedSort; ?>"><img width="125" src="/ParentPictures/<?php echo $row_Sort['ParentID']; ?>.jpg"></a></td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID1']!=""){getchilds($row_Sort['ChildID1'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID2']!=""){getchilds($row_Sort['ChildID2'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID3']!=""){getchilds($row_Sort['ChildID3'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID4']!=""){getchilds($row_Sort['ChildID4'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID5']!=""){getchilds($row_Sort['ChildID5'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID6']!=""){getchilds($row_Sort['ChildID6'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID7']!=""){getchilds($row_Sort['ChildID7'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID8']!=""){getchilds($row_Sort['ChildID8'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID9']!=""){getchilds($row_Sort['ChildID9'], $database_dbs, $dbs);}?>&nbsp;</td>
					<td align="left" nowrap="true"><?php if($row_Sort['ChildID10']!=""){getchilds($row_Sort['ChildID10'], $database_dbs, $dbs);}?>&nbsp;</td>
					</tr>
					<tr>
					<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
					<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
					</tr>
					<tr>
					<td align="left" nowrap="true">&nbsp;</td>
					</tr>
				    </table>
				</TD></tr>
			<?php } ?>
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
		<?php include ('/var/www/Admin/adminrelatedlinks.php'); ?>
	  </div><!--end relatedLinks -->
  </div> <!--start sidebar -->
</div><!--end web -->

</body>
</html>


