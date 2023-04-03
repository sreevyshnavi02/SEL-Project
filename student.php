<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'header.php'; 
            //check if the regno is valid

            $regno = $_POST['regno'];
            $get_stud_name = $conn -> query("select s.sname, p.dept_id from u_student s, u_prgm p where regno = '$regno' and p.prgm_id = s.prgm_id");
            $stud_name = $get_stud_name -> fetchAll(PDO::FETCH_ASSOC);

            if($stud_name == 0){
                echo("<script>
                            alert('Enter the correct regno');
                            window.location.href = 'student_login.php';
                    </script>");
                    // header('Location: student_login.php');
            }
            else{
                echo("Welcome ".$stud_name[0]['sname']."!");
                echo("Dept: ".$stud_name[0]['dept_id']);
                $_SESSION['regno'] = $_POST['regno'];
                $_SESSION['dept_id'] = $stud_name[0]['dept_id'];
        ?>

        <!-- check for any updates from admin, display in scroll if any -->

        <div class="provision">
            <!-- show the student's details -->
            
            <!-- show this btn only to students belonging to 4th to 7th sem -->
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href = './OEC_allotment/get_session.php'><button class = 'btnn'>Pre-Registration for OEC</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <!-- show this btn only to students belonging to 3rd sem (or 4th sem for lateral entry students) -->
            <a href = './Honor_minor_allotment/options.php'><button class = 'btnn'>Pre-Registration for Honor/Minor</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href = #><button class = 'btnn'>Course Registration</button></a>
            
            <!-- show this btn only when the admin enables it and disable it after the deadline -->
            <a href="exam_regn/stu_page.php"><button class = 'btnn'>Exam Registration</button></a>
        </div>

        <?php
            }
        ?>
    </body>
</html>