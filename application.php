<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Summer Application</title>
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
    include("auth_session.php");

    $studentid = $firstname = $surname = $level = $no_credits = $department = $academic_advisor = $comment = NULL;
    $studentidErr = $firstnameErr = $surnameErr = $levelErr = $no_creditsErr = $departmentErr = $academic_advisorErr = $commentErr = NULL;

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

        if ($_POST["studentid"] != $_SESSION['studentid']){
            $studentidErr = "The student ID is not matching your ID";
            $flag = false;
        } else {
			$studentid = test_input($_POST["studentid"]);
		}


        if (empty($_POST["firstname"])) {
			$firstnameErr = "First Name is required";
			$flag = false;
		} else {
			$firstname = test_input($_POST["firstname"]);
		}

        if (ctype_alpha($firstname)) {
			$firstnameErr = "First Name must be alphapetic only";
			$flag = false;
		} else {
			$firstname = test_input($_POST["firstname"]);
		}
        

        if (empty($_POST["surname"])) {
			$surnameErr = "Surame is required";
			$flag = false;
		} else {
			$surname = test_input($_POST["surname"]);
		}

        if (ctype_alpha($surname)) {
			$surnameErr = "First Name must be alphapetic only";
			$flag = false;
		} else {
			$surname = test_input($_POST["surname"]);
		}

        if (empty($_POST["level"])) {
			$levelErr = "Level is required";
			$flag = false;
		} else {
			$level = test_input($_POST["level"]);
		}

        if (is_numeric($level) && $level < 9) {
			$levelErr = "Level must be digits only and less than 9";
			$flag = false;
		} else {
			$level = test_input($_POST["level"]);
		}

        if (empty($_POST["no_credits"])) {
			$no_creditsErr = "Number of Credits is required";
			$flag = false;
		} else {
			$no_credits = test_input($_POST["no_credits"]);
		}

        if (is_numeric($no_credits) && $no_credits < 200) {
			$no_creditsErr = "Number of Credits is required";
			$flag = false;
		} else {
			$no_credits = test_input($_POST["no_credits"]);
		}

        if (empty($_POST["department"])) {
			$departmentErr = "department is required";
			$flag = false;
		} else {
			$department = test_input($_POST["department"]);
		}

        if (empty($_POST["academic_advisor"])) {
			$academic_advisorErr = "academic advisor is required";
			$flag = false;
		} else {
			$academic_advisor = test_input($_POST["academic_advisor"]);
		}

        $comment = test_input($_POST["comment"]);

        
        if ($flag) {
            mysqli_query($con, "Call InsertApplication('$studentid', '$firstname', 
                                '$surname', '$level', '$no_credits', '$department', 
                                '$academic_advisor', '$comment')") 
            or die("failed: " . mysqli_error($con));

            echo "<div class='form'>
                  <h3>You are applied successfully.</h3><br/>
                  <p class='link'>Click here to view and update your application 
                  <a href='student_info.php'>Update Application Information</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>Required fields are missing.</h3><br/>
                  <p class='link'>Click here to <a href='application.php'>apply</a> again.</p>
                  </div>";
        }
    } else{
    
?>
    <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <h1 class="login-title">Summer Application</h1>
        <input type="text" class="login-input" name="studentid" placeholder="Student ID" />
        <span class="error"> <?= $studentidErr; ?></span>
        <input type="text" class="login-input" name="firstname" placeholder="First Name" >
        <span class="error"> <?= $firstnameErr; ?></span>
        <input type="text" class="login-input" name="surname" placeholder="Surname">
        <span class="error"> <?= $surnameErr; ?></span>
        <input type="number" min="1" max="8" class="login-input" name="level" placeholder="Level">
        <span class="error"> <?= $levelErr; ?></span>
        <input type="number" min="1" max="400" class="login-input" name="no_credits" placeholder="Number of Credits Earned">
        <span class="error"> <?= $no_creditsErr; ?></span>
        <label for="department">Department</label>
            <select name="department" id="department" >
                <option value="ARCHITECTURAL ENGINEERING">ARCHITECTURAL ENGINEERING</option>
                <option value="ELECTRICAL ENGINEERING">ELECTRICAL ENGINEERING</option>
                <option value="INTERIOR DESIGN">INTERIOR DESIGN</option>
                <option value="CIVIL ENGINEERING">CIVIL ENGINEERING</option>
                <option value="COMPUTER SCIENCES">COMPUTER SCIENCES</option>
                <option value="SOFTWARE ENGINEERING">SOFTWARE ENGINEERING</option>
                <option value="CYBER SECURITY & FORENSIC COMPUTING">CYBER SECURITY & FORENSIC COMPUTING</option>
                <option value="ARTIFICIAL INTELLIGENCE">ARTIFICIAL INTELLIGENCE</option>
                <option value="ACCOUNTING">ACCOUNTING</option>
                <option value="FINANCE">FINANCE</option>
                <option value="MARKETING">MARKETING</option>
                <option value="BUSINESS MANAGEMENT">BUSINESS MANAGEMENT</option>
                <option value="INTERNATIONAL HOSPITALITY MANAGEMENT">INTERNATIONAL HOSPITALITY MANAGEMENT</option>
            </select>
            <span class="error"> <?= $departmentErr; ?></span>
        <label for="department">Academic Advisor</label>
            <select name="academic_advisor" id="academic_advisor">
                <option value="DR. RASHID TAHIR">DR. RASHID TAHIR</option>
                <option value="DR. SYED SADIQUR RAHMAN">DR. SYED SADIQUR RAHMAN</option>
                <option value="DR. MOHAMMAD. ABDUR RAHMAN">DR. MOHAMMAD. ABDUR RAHMAN</option>
                <option value="MR. MOHAMMED AL-KHATIB">MR. MOHAMMED AL-KHATIB</option>
                <option value="MS. MAIRA SULTAN">MS. MAIRA SULTAN</option>
                <option value="DR. MOHAMED ZAYED">DR. MOHAMED ZAYED</option>
                <option value="DR. FAZILA HARON">DR. FAZILA HARON</option>
                <option value="MS. ROUA NASSER AL-TURKI">MS. ROUA NASSER AL-TURKI</option>
                <option value="DR. KHALED KHANKAN">DR. KHALED KHANKAN</option>
                <option value="MR. AHMED ALGOGANDI">MR. AHMED ALGOGANDI</option>
                <option value="MS. BASIMAH ALJHNE">MS. BASIMAH ALJHNE</option>
                <option value="MR. NAVEED AHMED">MR. NAVEED AHMED</option>
            </select>
            <span class="error"> <?= $academic_advisorErr; ?></span>
        <input type="text" class="login-input" name="comment" placeholder="Comment"/>
        <input type="submit" name="submit" value="Apply" class="login-button">
        <p><a href="student_info.php">Click here to update your application information</a></p>
        <p><a href="logout.php">Logout</a></p>
    </form>
<?php
    }
    ?>
</body>
</html>