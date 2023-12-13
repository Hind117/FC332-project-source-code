<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Students Registration</title>
    <link rel="stylesheet" href="style.css"/>
    <style type="text/css">
		.error {
			font-size: 15px;
			color: red;
		}
	</style>
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


    // prepare and bind
    $stmt = $con->prepare("INSERT INTO `students` (studentid, email, password, create_datetime) VALUES (?, ?, ?, ?)");
    
    $stmt->bind_param("isss", $studentid, $email, $password, $create_datetime);



    $studentid = $email = $password = $password2 = $create_datetime = NULL;
    $studentidErr = $emailErr = $passwordErr = $password2Err = NULL;


    $flag = true;
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		if (empty($_POST["studentid"])) {
			$studentidErr = "Student ID is required";
			$flag = false;
		} else {
			$studentid = test_input($_POST["studentid"]);
		}

        if (!(is_numeric($studentid))) {
			$studentidErr = "Student ID must be gigits only";
			$flag = false;
		} else {
			$studentid = test_input($_POST["studentid"]);
		}

        if (empty($_POST["email"])) {
			$emailErr = "Email is required";
			$flag = false;
		} else {
			$email = test_input($_POST["email"]);
		}

        

        if (empty($_POST["password"])) {
			$passwordErr = "Password is required";
			$flag = false;
        } else {
			$password = test_input($_POST["password"]);
		}

        if (!(preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/", $password))) {
            $passwordErr = "Password should has minimum 8 characters in length,
                            contains at least one uppercase English letter,
                            contains at least one lowercase English letter, 
                            contains at least one digit, contains at least one special character.";
            $flag = false;
        } else {
			$password = test_input($_POST["password"]);
		}

        if (empty($_POST["password2"])) {
			$password2Err = "Re-Entering Password is required";
			$flag = false;
        } else {
			$password2 = test_input($_POST["password2"]);
		}

        if ($password != $password2){
            $password2Err = "passwords are not matching";
            $flag = false;
        } else {
        $password2 = test_input($_POST["password2"]);
        }

        

        $create_datetime = date("Y-m-d H:i:s");
        // submit form if validated successfully
	    if ($flag) {
            $stmt->execute();
            echo "<div class='form'>
                  <h3>You are registered successfully.</h3><br/>
                  <p class='link'>Click here to <a href='login.php'>Login</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='registration.php'>registration</a> again.</p>
                  </div>"; 
        }

            $stmt->close();
            $con->close();

        }else{
    


?>

    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h1 class="login-title">Students Registration</h1>
        <input type="text" class="login-input" name="studentid" placeholder="Student ID" />
        <span class="error"> <?= $studentidErr; ?></span>
        <input type="text" class="login-input" name="email" placeholder="Email Adress">
        <span class="error"> <?= $emailErr; ?></span>
        <input type="password" class="login-input" name="password" placeholder="Password">
        <span class="error"> <?= $passwordErr; ?></span>
        <input type="password" class="login-input" name="password2" placeholder="Re-Enter Password">
        <span class="error"> <?= $password2Err; ?></span>
        <input type="submit" name="submit" value="Register" class="login-button">
        <p class="link"><a href="login.php">Click to Login</a></p>
    </form>
<?php
        }
?>
</body>
</html>



