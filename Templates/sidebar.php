<h5>
<p><b>Check&nbsp;In:</b>
<br><a href="/index.php">&nbsp;&nbsp;Child</a>
<p><a href="/index.php">&nbsp;&nbsp;Volunteer</a>
<p><a href="/tempbadge.php">&nbsp;&nbsp;Visitor</a>
<p><b>Check&nbsp;Out:</b>
<br><a href="/checkout.php">&nbsp;&nbsp;Child</a>
<p><b>Other:</b>
<br><a href="/Pictorial/index.php">&nbsp;&nbsp;Pictorial&nbsp;Directory</a>
<p><a href="/Admin/login.php">&nbsp;&nbsp;Admin</a>
<p>Today's Date is <br><?php echo date('M d, Y');?></p>
</h5>

<?php if (isset($_SESSION['MM_AccessLevel'])) { ?>
<h5>
<p><b>Information:</b>
<br><a href="/Admin/Parent/index.php">&nbsp;&nbsp;Adult&nbsp;Data</a>
<p><a href="/Admin/Child/index.php">&nbsp;&nbsp;Child&nbsp;Data</a>
<p><a href="/Admin/Email/index.php">&nbsp;&nbsp;Email</a>
<p><b>Attendance:</b>
<br><a href="/Admin/VolunteerAttendance/index.php">&nbsp;&nbsp;Adult</a>
<p><a href="/Admin/Attendance/index.php">&nbsp;&nbsp;Child</a>
<p><a href="/Admin/Attendance/smallgroup.php">&nbsp;&nbsp;YG&nbsp;Fusion</a>
<p><b>Other:</b>
<br><a href="/Admin/visitor.php">&nbsp;&nbsp;Enter&nbsp;New&nbsp;Family</a>
<p><a href="/Admin/promote.php">&nbsp;&nbsp;Promote&nbsp;Child</a>
<p><b>Mobile:</b>
<br><a href="/Mobile/index.php">&nbsp;&nbsp;Search</a>
<p><a href="/Mobile/smallgroup.php">&nbsp;&nbsp;Small&nbsp;Group</a>
<p><b>&nbsp;</b>
<br><a href="/index.php?doLogout=true">&nbsp;&nbsp;Log&nbsp;Out</a>
</h5>
<?php } ?>
