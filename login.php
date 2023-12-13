<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Students Login</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>
<?php
    function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    }
?>
<?php
    require('db.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['studentid'])) {
        $studentid = test_input($_REQUEST['studentid']);
        $password = test_input($_REQUEST['password']);

        $result = mysqli_query($con, "Call getStudentInfo('$studentid','$password')") or die("failed: " . mysqli_error($con));
        
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['studentid'] = $studentid;
            // Redirect to user dashboard page
            header("Location: dashboard.php");
        } else {
            echo "<div class='form'>
                  <h3>Incorrect Student ID/password.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a> again.</p>
                  </div>";
        }
    } else {
?>

    <form class="form" method="post" name="login">
        <h1 class="login-title">Students Login</h1>
        <input type="text" class="login-input" name="studentid" placeholder="Student ID" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Password"/>
        <input type="submit" value="Login" name="submit" class="login-button"/>
        <p class="link"><a href="registration.php">New Registration</a></p>
        <p class="link"><a href="index.html">Back to Main Page</a></p>
  </form>
<?php
    }
?>
</body>
</html>