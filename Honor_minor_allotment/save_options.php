<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php include '../header.php'; 
    // Get the values submitted by the form
    $cgpa = $_SESSION['cgpa'];
    $preference1 = $_POST['preference1'];
    $preference2 = $_POST['preference2'];
    $preference3 = $_POST['preference3'];
    $regno = $_SESSION['regno'];
    
    // Prepare the insert statement
    $insert_query = "INSERT INTO u_hm_preregistration (regno, cgpa, OPT1_PRGM_ID, OPT2_PRGM_ID, OPT3_PRGM_ID) 
                    VALUES (:regno, :cgpa, :preference1, :preference2, :preference3)";
    $insert_prepare = $conn->prepare($insert_query);
    
    // Bind the parameters
    $insert_prepare->bindParam(':regno', $regno);
    $insert_prepare->bindParam(':cgpa', $cgpa);
    $insert_prepare->bindParam(':preference1', $preference1);
    $insert_prepare->bindParam(':preference2', $preference2);
    $insert_prepare->bindParam(':preference3', $preference3);
    
    // Execute the insert statement
    $insert_prepare->execute();
    echo "<h3 style='text-align: center;'>Your options are saved!</h3>";
    // sleep(10);
    // header("Location: ../student_login.php");
    ?>

<button class="small_btn" onclick="goback()">Back</button>

<script>
    function goback() {
        window.location.href = "../student_login.php";
    }
</script>


    
</body>
</html>