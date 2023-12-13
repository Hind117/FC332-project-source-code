<?php
    function test_input($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
    }

//include auth_session.php file on all user panel pages
include("advisor_auth_session.php");
require('db.php');


    if (isset($_POST['submit']))
    {
        
        
        $stmt = $con->prepare("UPDATE `application` SET approved = ? WHERE studentid = ?");

        $stmt->bind_param("si", $approved, $studentid);

        $approved = test_input($_REQUEST['status']); //apprved or rejected

        $studentid = test_input($_REQUEST['studentid']);
        

        $stmt->execute();

        
        echo "<div class='form'>
                <h3>Your Approval has been stored in the database.</h3><br/>
                </div>";
    
        $stmt->close();
    
    } 

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
        <p>You are now Applications Page.</p>

        <p><a href="advisor_dashboard.php">Dashboard Page</a></p>
        <p><a href="advisor_logout.php">Logout</a></p>
    </div>

    <form class="form" method="post" name="login">
        <h1 class="login-title">Students Applications</h1>
        <p> Enter Your Full Name </p>
        <input type="text" class="login-input" name="advisor" placeholder="Advisor Name" autofocus="true"/>
        <p> Enter Student ID to view her/his application information </p>
        <input type="text" class="login-input" name="studentid" placeholder="Student ID"/>
        <input type="submit" value="View" name="submit_application" class="login-button"/>
  </form>
  <div class="form">
  <?php 
            if (isset($_POST['advisor'])) {
                $studentid = test_input($_REQUEST['studentid']);
                $advisor = $_REQUEST['advisor'];
        
                $result = mysqli_query($con, "Call getStudentApp('$advisor', '$studentid')") or die("failed: " . mysqli_error($con));
                while($row = mysqli_fetch_array($result)){
                    echo "<p>Student's Information</p>";
                    echo '<p>Student ID: </p>';
                    echo $row['studentid'];
                    echo '<p>Student Name: </p>';
                    echo $row['firstname'], ' ', $row['surname'];
                    echo '<p>Student Level: </p>';
                    echo $row['level'];
                    echo '<p>Number of Credits Earned: </p>';
                    echo $row['no_credits'];
                    echo '<p>Department: </p>';
                    echo $row['department'];
                    echo '<p>Comment: </p>';
                    if(empty($row['comment'])){
                        echo '<p> Student did not post any comment</p>'; 
                    }else{
                        echo $row['comment'];
                    } 
                }
            }        
        ?> 
        <form class="form" method="post" name="approval">
        <label for="status">Approve or Reject the application:</label>
        <select name="status" id="status">
            <option value="Approved" name="approve">Approve</option>
            <option value="Rejected" name="reject">Reject</option>
        </select>
                    <input type="hidden" name="studentid" value="$studentid">
                    <input type="submit" value="Submit" name="submit" class="login-button"/>
                        </form></div>

</body>
</html>