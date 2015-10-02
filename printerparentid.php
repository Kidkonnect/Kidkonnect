   <table width="480" height="240"  border="0" class="table" >
      <tr>
        <td colspan="2" align="left"><?php echo '<img width="115" height="90" src="/ParentPictures/', $row_Sort['ParentID'], '.jpg">';?></td>
        <td colspan="3" align="left"><h1><?php echo $row_Sort['LastName'];?></h1></td>
        <td colspan="3" align="left"><img src="/Templates/corner.png" width="120"  hight="105"></td>
      </tr>
      <tr>
	<?php if($row_Sort['ChildID1']!=''){echo '<td colspan="2"><img width="115" height="90" src="/ChildPictures/',$row_Sort['ChildID1'],'.jpg"></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID2']!=''){echo '<td colspan="2"><img width="115" height="90" src="/ChildPictures/',$row_Sort['ChildID2'],'.jpg"></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID3']!=''){echo '<td colspan="2"><img width="115" height="90" src="/ChildPictures/',$row_Sort['ChildID3'],'.jpg"></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID4']!=''){echo '<td colspan="2"><img width="115" height="90" src="/ChildPictures/',$row_Sort['ChildID4'],'.jpg"></td>';}else {echo '&nbsp;';} ?>
      </tr>
      <tr>
	<?php if($row_Sort['ChildID1']!=''){echo '<td colspan="2" align="center"><h2>',$row_Sort['ChildID1'],'</h2></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID2']!=''){echo '<td colspan="2" align="center"><h2>',$row_Sort['ChildID2'],'</h2></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID3']!=''){echo '<td colspan="2" align="center"><h2>',$row_Sort['ChildID3'],'</h2></td>';}else {echo '&nbsp;';} ?>
	<?php if($row_Sort['ChildID4']!=''){echo '<td colspan="2" align="center"><h2>',$row_Sort['ChildID4'],'</h2></td>';}else {echo '&nbsp;';} ?>
      </tr>
      <tr>
	<td colspan="8" align="center">If found return to Sunnybrook Christian Church</td>
      </tr>
  </table>

