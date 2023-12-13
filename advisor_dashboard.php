<?php
//include auth_session.php file on all user panel pages
include("advisor_auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - Client area</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <div class="form">
        <p>Hey, <?php echo $_SESSION['username']; ?>!</p>
        <p>You are now user dashboard page.</p>
        <p><a href="manage_applications.php">Students Applications Page</a></p>
        <p><a href="advisor_logout.php">Logout</a></p>
    </div>
</body>
</html>