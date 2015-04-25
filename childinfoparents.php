<?php
function getchilds($passedParentID, $database_dbs2, $dbs2){
//get the data from the parent
/*
mysql_select_db($database_tvt, $tvt);
$query_computerdata = sprintf("SELECT * FROM computerdata WHERE TerrahawkSN = '%s'", $colname_computerdata);
$computerdata = mysql_query($query_computerdata, $tvt) or die(mysql_error());
$row_computerdata = mysql_fetch_assoc($computerdata);
$totalRows_computerdata = mysql_num_rows($computerdata);
*/
	mysql_select_db($database_dbs2, $dbs2); //database already selected
	$query_Sort2 = "SELECT * FROM parent WHERE ParentID = '".$passedParentID."'"; 
	$Sort2 = mysql_query($query_Sort2, $dbs2) or die(mysql_error());
	$totalRows2 = mysql_num_rows($Sort2);
	$row_Sort2 = mysql_fetch_assoc($Sort2);
//Put the data on the sreen
echo '<table width="300" border="0" class="table">';
  echo '<tr><td><a href="/parentinfo.php?passedParentID=', $row_Sort2['ParentID'], '"><img width="150" height="110" src = "/ParentPictures/', $row_Sort2['ParentID'], '.jpg"></a></td>';
  echo '<td>';
  echo '<table width="75" border="0" class="table">';
    //echo '<tr><td colspan="5">', $row_Sort2['FirstName'], ' ', $row_Sort2['LastName'], '</td></tr>';
    if($row_Sort2['CellPhone1']<7){echo '<tr><td><b>NO&nbsp;CELL&nbsp#</b></td>';}else{echo '<tr>';}
    if($row_Sort2['ChildID1']!=''){echo '    <td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID1'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID1'], '.jpg"><br><h2>', $row_Sort2['ChildID1'], '</h2></a></td>';}
    if($row_Sort2['ChildID2']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID2'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID2'], '.jpg"><br><h2>', $row_Sort2['ChildID2'], '</h2></a></td>';}
    if($row_Sort2['ChildID3']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID3'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID3'], '.jpg"><br><h2>', $row_Sort2['ChildID3'], '</h2></a></td>';}
    if($row_Sort2['ChildID4']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID4'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID4'], '.jpg"><br><h2>', $row_Sort2['ChildID4'], '</h2></a></td></tr>';}else{echo '</tr>';}
    
    //if($row_Sort2['ChildID5']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID5'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID5'], '.jpg"></a></td></tr>';}else{echo '</tr>';}
    //if($row_Sort2['ChildID6']!=''){echo '<tr><td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID6'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID6'], '.jpg"></a></td>';}
    //if($row_Sort2['ChildID7']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID7'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID7'], '.jpg"></a></td>';}
    //if($row_Sort2['ChildID8']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID8'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID8'], '.jpg"></a></td>';}
    //if($row_Sort2['ChildID9']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID9'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID9'], '.jpg"></a></td>';}
    //if($row_Sort2['ChildID10']!=''){echo    '<td><a href="/childinfo.php?passedChildID=', $row_Sort2['ChildID10'], '"><img width="75" height="55" src = "/ChildPictures/', $row_Sort2['ChildID10'], '.jpg"></a></td></tr>';}else{echo '</tr>';}
  echo '</table>';  
echo '</td></tr><tr><td colspan="5">', $row_Sort2['FirstName'], ' ', $row_Sort2['LastName'], '</td></tr>';
echo '</table>';
  //echo $totalRows2;
  //echo $row_Sort2['FirstName'];
  //echo $row_Sort2['LastName'];

} 
?>
<table width="300" border="1" class="table"> 
    <?php if($row_Sort['ParentID1']!=''){ 
	//echo '<tr><td><a href="/parentinfo.php?passedParentID=', $row_Sort['ParentID1'], '"><img width="125" src = "/ParentPictures/', $row_Sort['ParentID1'], '.jpg"></a></td>';
	//echo '<td>';
	getchilds($row_Sort['ParentID1'], $database_dbs, $dbs);
	//echo '</td></tr><tr><td colspan="5">', $row_Sort2['FirstName'], ' ', $row_Sort2['LastName'], '</td></tr>';
	}
    ?>
    <?php if($row_Sort['ParentID2']!=''){ 
	//echo '<tr><td><a href="/parentinfo.php?passedParentID=', $row_Sort['ParentID2'], '"><img width="125" src = "/ParentPictures/', $row_Sort['ParentID2'], '.jpg"></a></td>';
	//echo '<td>';
	getchilds($row_Sort['ParentID2'], $database_dbs, $dbs);
	//echo '</td></tr>';
	}
    ?>
    <?php if($row_Sort['ParentID3']!=''){ 
	//echo '<tr><td><a href="/parentinfo.php?passedParentID=', $row_Sort['ParentID3'], '"><img width="125" src = "/ParentPictures/', $row_Sort['ParentID3'], '.jpg"></a></td>';
	//echo '<td>';
	getchilds($row_Sort['ParentID3'], $database_dbs, $dbs);
	//echo '</td></tr>';
	}
    ?>
    <?php if($row_Sort['ParentID4']!=''){ 
	//echo '<tr><td><a href="/parentinfo.php?passedParentID=', $row_Sort['ParentID4'], '"><img width="125" src = "/ParentPictures/', $row_Sort['ParentID4'], '.jpg"></a></td>';
	//echo '<td>';
	getchilds($row_Sort['ParentID4'], $database_dbs, $dbs);
	//echo '</td></tr>';
	}
    ?>
</table>

