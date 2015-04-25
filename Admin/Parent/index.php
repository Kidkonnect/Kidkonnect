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
if ((isset($_POST["MM_search"])) && ($_POST["MM_search"] == "form1") && ($_POST['Search']!="")) {
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
			<table class="table">
			  <tr><td colspan="25">Filter by Last Name:</td></tr>
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
				<table border="1" class="table">
				<tr>
				<td>Photo</td>
				<td>Delete</td>
				<td><a href="index.php?Sort=ParentID&Filter=<?php echo $passedFilter; ?>">ParentID</a></td>
				<td><a href="index.php?Sort=FirstName&Filter=<?php echo $passedFilter; ?>">FirstName</a></td>
				<td><a href="index.php?Sort=LastName&Filter=<?php echo $passedFilter; ?>">LastName</a></td>
				<td><a href="index.php?Sort=Address&Filter=<?php echo $passedFilter; ?>">Address</a></td>       
				<td><a href="index.php?Sort=City&Filter=<?php echo $passedFilter; ?>">City</a></td>
				<td><a href="index.php?Sort=HomePhone&Filter=<?php echo $passedFilter; ?>">HomePhone</a></td>
				<td><a href="index.php?Sort=CellPhone1&Filter=<?php echo $passedFilter; ?>">CellPhone1</a></td>
				<td><a href="index.php?Sort=Email&Filter=<?php echo $passedFilter; ?>">Email</a></td>
				<td><a href="index.php?Sort=ChildID1&Filter=<?php echo $passedFilter; ?>">VolunteerLocation</a></td>       
				<td><a href="index.php?Sort=ChildID1&Filter=<?php echo $passedFilter; ?>">VoluteerTitle</a></td>       
				<td><a href="index.php?Sort=ChildID1&Filter=<?php echo $passedFilter; ?>">CID1</a></td>       
				<td><a href="index.php?Sort=ChildID2&Filter=<?php echo $passedFilter; ?>">CID2</a></td>
				<td><a href="index.php?Sort=ChildID3&Filter=<?php echo $passedFilter; ?>">CID3</a></td>
				<td><a href="index.php?Sort=ChildID4&Filter=<?php echo $passedFilter; ?>">CID4</a></td>
				<td><a href="index.php?Sort=ChildID5&Filter=<?php echo $passedFilter; ?>">CID5</a></td>
				<td><a href="index.php?Sort=ChildID6&Filter=<?php echo $passedFilter; ?>">CID6</a></td>
				<td><a href="index.php?Sort=ChildID7&Filter=<?php echo $passedFilter; ?>">CID7</a></td>
				<td><a href="index.php?Sort=ChildID8&Filter=<?php echo $passedFilter; ?>">CID8</a></td>        
				<td><a href="index.php?Sort=ChildID9&Filter=<?php echo $passedFilter; ?>">CID9</a></td>
				<td><a href="index.php?Sort=ChildID10&Filter=<?php echo $passedFilter; ?>">CD10</a></td>        
				<td>Parent&nbsp;ID</td>

				</tr>
			<?php while ($row_Sort = mysql_fetch_assoc($Sort)) { ?>
				<tr>
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID']; ?>&Filter=<?php echo $passedFilter; ?>&Sort=<?php echo $passedSort; ?>"><img height="50" src="/ParentPictures/<?php echo $row_Sort['ParentID']; ?>.jpg"></a></td>
				<td align="left" nowrap="true"><a href="/Admin/Parent/delete.php?passedParentID=<?php echo $row_Sort['ParentID']; ?>&Filter=<?php echo $passedFilter; ?>&Sort=<?php echo $passedSort; ?>">delete</a></td>      
				<td align="left" nowrap="true"><a href="/Admin/Parent/edit.php?passedParentID=<?php echo $row_Sort['ParentID']; ?>&Filter=<?php echo $passedFilter; ?>&Sort=<?php echo $passedSort; ?>"><?php echo $row_Sort['ParentID']; ?></a>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['FirstName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['LastName']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Address']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['City']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['HomePhone']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['CellPhone1']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['Email']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['VolunteerLocation']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><?php echo $row_Sort['VolunteerTitle']; ?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID1']; ?>"><?php if($row_Sort['ChildID1']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID1'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID2']; ?>"><?php if($row_Sort['ChildID2']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID2'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID3']; ?>"><?php if($row_Sort['ChildID3']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID3'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID4']; ?>"><?php if($row_Sort['ChildID4']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID4'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID5']; ?>"><?php if($row_Sort['ChildID5']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID5'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID6']; ?>"><?php if($row_Sort['ChildID6']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID6'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID7']; ?>"><?php if($row_Sort['ChildID7']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID7'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID8']; ?>"><?php if($row_Sort['ChildID8']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID8'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID9']; ?>"><?php if($row_Sort['ChildID9']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID9'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left" nowrap="true"><a href="/Admin/Child/edit.php?passedChildID=<?php echo $row_Sort['ChildID10']; ?>"><?php if($row_Sort['ChildID10']!=""){echo '<img height="50" src="/ChildPictures/'.$row_Sort['ChildID10'].'.jpg"></a>';}?>&nbsp;</td>
				<td align="left"><?php echo '<IMG SRC="/barcode.php?barcode=',$row_Sort['ParentID'], '&text=0&width=200&height=40">';?></td>

			</tr>
			
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


