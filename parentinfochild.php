<table width="300" border="0" class="table"> 
    <?php 
    if($row_Sort['ChildID1']!=''){echo '    <td><a href="/childinfo.php?passedChildID=', $row_Sort['ChildID1'], '"><img width="125" src = "/ChildPictures/', $row_Sort['ChildID1'], '.jpg"></a></td>';}
    if($row_Sort['ChildID2']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort['ChildID2'], '"><img width="125" src = "/ChildPictures/', $row_Sort['ChildID2'], '.jpg"></a></td>';}
    if($row_Sort['ChildID3']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort['ChildID3'], '"><img width="125" src = "/ChildPictures/', $row_Sort['ChildID3'], '.jpg"></a></td>';}
    if($row_Sort['ChildID4']!=''){echo     '<td><a href="/childinfo.php?passedChildID=', $row_Sort['ChildID4'], '"><img width="125" src = "/ChildPictures/', $row_Sort['ChildID4'], '.jpg"></a></td>';}

    ?>
</table>

