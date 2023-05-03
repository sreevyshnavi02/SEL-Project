<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php 
            include 'header.php'; 

            //check if the regno is valid
            if(!isset($_SESSION['regno'])){
                echo 'inside if';
                if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                    header('Location: student_login.php');
                }
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
                    echo("<h2 class='stud_page_welcome'>Welcome ".$stud_name[0]['sname']."!</h2>");
                    $_SESSION['regno'] = $_POST['regno'];
                    $_SESSION['dept_id'] = $stud_name[0]['dept_id'];
                }
            }
            else{
                $regno = $_SESSION['regno'];
                $get_stud_name = $conn -> query("select s.sname, p.dept_id from u_student s, u_prgm p where regno = '$regno' and p.prgm_id = s.prgm_id");
                $stud_name = $get_stud_name -> fetchAll(PDO::FETCH_ASSOC);
                echo("<h2 class='stud_page_welcome'>Welcome ".$stud_name[0]['sname']."!</h2>");
                    
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
                <?php
                    // $result = check_enabled($conn, );
                ?>
                <a href = './course_regn/course_regn.php'><button class = 'btnn'>Course Registration</button></a>
                
                <!-- show this btn only when the admin enables it and disable it after the deadline -->
                <a href="exam_regn/stud_get_session.php"><button class = 'btnn'>Exam Registration</button></a>
            </div>

        <?php
                }

        ?>

        <button class="small_btn" onclick="goback()">Back</button>

        <script>
            function goback() {
                window.location.href = "student_login.php";
            }
        </script>
    </body>
</html>