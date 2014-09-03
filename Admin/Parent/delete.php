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

$passedParentID = $_GET['passedParentID'];

mysql_select_db($database_dbs, $dbs);
//SELECT * FROM foo WHERE b = 'abc' ORDER BY number ASC;
$query_Sort = sprintf("SELECT * FROM parent WHERE ParentID='$passedParentID'"); 
//echo $query_Sort;
$Sort = mysql_query($query_Sort, $dbs) or die(mysql_error());
?>
<div id="web"><!--start web -->
<?php include ('/var/www/Templates/masterhead.php'); ?>
  <div id="content"> <!--start content -->
	  <div id="breadCrumb">
	  </div> 
		<h2 id="pageName">Are you sure that you want to delete parent with an ID of <?php echo $passedParentID; ?> ? This will also remove this ParentID from all children.</h2>
		  <div class="feature">
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
				<table width="100" border="0" class="table">
				<tr>
					<td><a href="actualdelete.php?passedParentID=<?php echo $_GET['passedParentID']; ?>">YES</a></td>
					<td><a href="index.php">NO</a></td>
				</tr>
				</table>
			</form>
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


