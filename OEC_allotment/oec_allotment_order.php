<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <!-- display student details -->
    <div class="box">
        <div class="header">
            <img src="../images/logo_ptu.png" alt="ptu-logo">
            <div class="univ_name">
                <h1>PUDUCHERRY TECHNOLOGICAL UNIVERSITY</h1>
                <h2>(Erstwhile Pondicherry Engineering College)</h2>
                <h2>An Autonomous Institution</h2>
            </div>
        </div>
        <div class="stud_details_box">
            <div class="photo">
                <?php 
                include '../connection.php';
                $src = "../images/18-BT-IMG/".$_SESSION['regno'].".png"; 
                echo "<img src=$src alt='stud_photo'>";
                ?>
            </div>
            <h2>STUDENT DETAILS</h2>

            <!-- Fetching the data -->
            <?php 

            include '../connection.php';

            $stud_details_sql = "select s.REGNO, s.SNAME, s.EMAIL, s.CURR_SEM, p.PRGM_NAME, d.DEPT_NAME from u_student s, u_prgm p, u_dept d where s.regno = :regno and p.prgm_id = s.prgm_id and d.dept_id = p.dept_id;";
            $stud_details_query = $conn -> prepare($stud_details_sql);
            $stud_details_query -> bindParam(':regno', $_SESSION['regno']);
            $stud_details_query -> execute();

            //to fetch the results
            $stud_details_fetch = $stud_details_query -> fetchAll(PDO::FETCH_ASSOC);

            foreach($stud_details_fetch as $stud_details){
            ?>

            <table class="stud_details_table">
                <tr>
                    <th>NAME</th>
                    <td><?php echo "$stud_details[SNAME]"; ?></td>
                </tr>
                <tr>
                    <th>REGISTER NUMBER</th>
                    <td><?php echo "$stud_details[REGNO]"; ?></td>
                </tr>
                <tr>
                    <th>EMAIL</th>
                    <td><?php echo "$stud_details[EMAIL]"; ?></td>
                </tr>
                <tr>
                    <th>PROGRAMME</th>
                    <td><?php echo "$stud_details[PRGM_NAME]"; ?></td>
                </tr>
                <tr>
                    <th>DEPARTMENT</th>
                    <td><?php echo "$stud_details[DEPT_NAME]"; ?></td>
                </tr>
                <tr>
                    <th>SEMESTER</th>
                    <td><?php echo "$stud_details[CURR_SEM]"; ?></td>
                </tr>
            </table>

            <?php 
            } 
            
            // fetching course details from u_oec_allotment
            $oec_details_sql = "select o.course_code, c.course_name, c.credits, o.allotment_date from u_oec_allotment o, u_course c where o.regno = :regno and session = :sess and c.course_code = o.course_code;";
            $oec_details_query = $conn -> prepare($oec_details_sql);
            $oec_details_query -> bindParam(':regno', $_SESSION['regno']);
            $oec_details_query -> bindParam(':sess', $_SESSION['chosen_session']);
            $oec_details_query -> execute();
            
            //to fetch the results
            $oec_details_fetch = $oec_details_query -> fetchAll(PDO::FETCH_ASSOC);
            
            foreach($oec_details_fetch as $oec_details){
            ?>
        </div>

        <div class="oec_box">
            <div class="oec_title">
                OPEN ELECTIVE COURSE PRE-REGISTRATION DETAILS
            </div>
            <div class="oec_details">
                <table class="oec_details_table">
                    <tr>
                        <th>Course Code</th>
                        <th>Course Name</th>
                        <th>Credits</th>
                        <th>Allotment timestamp</th>
                    </tr>
                    <tr>
                        <td><?php echo "$oec_details[course_code]"; ?></td>
                        <td><?php echo "$oec_details[course_name]"; ?></td>
                        <td><?php echo "$oec_details[credits]"; ?></td>
                        <td><?php echo "$oec_details[allotment_date]"; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php 
        }
        ?>

    </div>
</body>
</html>