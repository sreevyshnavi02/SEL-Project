<?php
    include 'header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <div class="login">

        <form action="student.php" method="post">
            <div class="label_regno">
                <label for="regno">Enter your regno: </label>
            </div>
            <input type="text" name="regno" id="regno">

            <div class="label_OTP">
                <label for="otp">Enter the OTP: </label>
            </div>
            <input type="text" name="otp" id="otp">

            <!-- fetch email id associated with the given regno -->
            <?php 
                // $fetch_email = mysqli_query($conn, "select ");
            ?>
            <!-- feature to send the otp securely -->
            <input type="submit" value="Go to Student Page" class = "submit_login">
        </form>
    </div>

        <a href = "./Student Enrollment/enroll.php"><button class = 'btnn'>Student Enrolment (For newly Admitted students)</button></a>
</body>
</html>