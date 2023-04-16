<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="exam_regn_form_style.css">
            <title>PTU-COE</title>
    </head>
    <body>
    <?php
        include '../connection.php';

        // getting the session chosen by the user
        $year =  $_POST['session_year'];
        $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
        $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];
        
        //fetching the details of the student based on regno
        $stmt = $conn->prepare("SELECT s.sname, p.prgm_name, d.dept_name 
            FROM u_student s 
            INNER JOIN u_prgm p ON p.prgm_id = s.prgm_id 
            INNER JOIN u_dept d ON d.dept_id = p.dept_id 
            WHERE s.regno = :regno");
        $stmt->bindParam(':regno', $_SESSION['regno']);
        $stmt->execute();
        $stud_details = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $stud_details['sname'];
        $prgm_name = $stud_details['prgm_name'];
        $dept_name = $stud_details['dept_name'];

        //query to get the consolidated attendance of the student
        $attendance_q = $conn -> prepare("SELECT consolidated_attendance 
        from u_exam_regn where regno=:regno 
        and session = :sess");
        $attendance_q -> bindParam(':regno', $_SESSION['regno']);
        $attendance_q -> bindParam(':sess', $_SESSION['chosen_session']);
        $attendance_q -> execute();
        
        if ($attendance = $attendance_q->fetch(PDO::FETCH_ASSOC)) {
            $_SESSION['consolidated_attendance'] = $attendance['consolidated_attendance'];
        } else {
            // handle case where query did not return any rows
            echo "no rows returned";
        }

        
        $subjectquery = $conn -> prepare("SELECT u_course_regn.course_code,u_course_regn.sem,session,course_name,course_type 
                        from u_course_regn 
                        inner join u_course 
                        on u_course_regn.course_code=u_course.course_code 
                        where regno= :regno and session = :sess"); 
        $subjectquery -> bindParam(':regno', $_SESSION['regno']);
        $subjectquery -> bindParam(':sess', $_SESSION['chosen_session']);
        $subjectquery -> execute();
        
        $registered_courses = $subjectquery -> fetchAll(PDO::FETCH_ASSOC);   

        // //query to bring in all the history of arrears for that student
        // $arrear_q = $conn -> prepare("SELECT regno, course_code, session from u_external_marks
        // where regno=:regno and grade in ('F','Z')");
        // $arrear_q -> bindParam(':regno', $_SESSION['regno']);
        // $arrear_q -> execute();

        // $arrear_courses = $arrear_q -> fetchAll(PDO::FETCH_ASSOC);

        // $arrears_array = array();
        
        // foreach($arrear_courses as $arrear)
        // {
        //     //pushing all the arrear history into arrears_array 
        //     array_push(
        //         $arrears_array, 
        //         array($arrear['regno'],$arrear['course_code'], $arrear['session'])
        //     );
        // }

        // foreach ($arrears_array as $i => $row) {
        //     $a_query = $conn -> prepare("SELECT * from u_external_marks 
        //         where regno='$row[0]' 
        //         and grade not in ('F','Z') 
        //         and course_code='$row[1]'");
        //     $a_query -> execute();
        //     $n = $a -> rowCount();
        //     if($n>0){
        //         unset($arrears_array[$i]);
        //     }
        // }

        //fetching the arrears
        
        function fetch_arrear_courses($conn, $regno) {

            // Query to fetch arrear courses for the given registration number
            $sql = "SELECT course_code, session
                    FROM u_external_marks
                    WHERE regno = '$regno'
                    AND grade IN ('F', 'Z')
                    AND course_code NOT IN (
                        SELECT course_code
                        FROM u_external_marks
                        WHERE regno = '$regno'
                        AND grade NOT IN ('F', 'Z')
                    )";

            // Execute the query and fetch results
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            if (!$stmt) {
                $error = $conn->errorInfo();
                echo "Error: " . $error[2];
                return;
            }

            $arrear_courses = $stmt -> fetchAll(PDO::FETCH_ASSOC);

            // Return the arrear courses
            return $arrear_courses;
        }
        

        $arrears_array = fetch_arrear_courses($conn, $_SESSION['regno']);
        $_SESSION['current_backlogs'] = $arrears_array;
    ?>
    
    <div class='img'>
        <img src="../images/logo_ptu.png" alt="PTU logo" style=" width: 10%;height: 30%;display: block;margin-left: auto;margin-right: auto;">
    </div>
    <div class='Header'>
        <h1>Puducherry Technological University<br>(PTU)</h1>
    </div>
    <div class='Details'>
        <h2><b>Examination Wing</b><br><?php echo "$_SESSION[chosen_session]" ?></h2>
        <p>To<br>
        <b><?php echo "$name" ?></b>,<br>
        Register Nr:<?php echo $_SESSION['regno'] ?> <br>
        Programme:<?php echo "$prgm_name" ?><br>
        Department:<?php echo "$dept_name" ?><br>
        <b>Consolidated Attendance:<?php echo "$_SESSION[consolidated_attendance]"."%" ?></b><br>
    </p>
    </div>
    <h1></h1>

    <!-- to fetch all the arrear courses -->
    <form action="exam_reg.php" method="POST">
        <label for="arrear_course">
            <!-- <?php print_r($_SESSION['current_backlogs']); ?> -->
        </label>
        <!-- <input type="checkbox" name="course_chkbox" id="course_chkbox"> -->
    </form>
    <!-- <//?php
    }
    ?> -->

    <table class='table1' style="width:100%">
        <tr>
            <th style="width:100px">Subject Code</th>
            <th>Subject Name</th>
            <th>Semester</th>
            <th>Type</th>
            <th  style="width:15%">Fees in INR</th>
        </tr>
        <?php
            $fee_sum = 0;  
            foreach($registered_courses as $x)
            {
                if(trim($x['course_type'])=='TY'){
                    $x['course_type'] = 'Theory';
                    $fees='250';
                }
                elseif(trim($x['course_type'])=='LB'){
                    $x['course_type'] = 'Laboratory';
                    $fees='350';
                }
                elseif(trim($x['course_type'])=='MC'){
                    $x['course_type'] = 'Mandatory Course';
                    $fees='0';
                }
                else{
                    echo("else.....".$x['course_type']);
                }

                echo "
                <tr>
                    <td>".$x['course_code']."</td>
                    <td>".$x['course_name']."</td>
                    <td>".$x['sem']."</td>
                    <td>".$x['course_type']."</td>
                    <td>".$fees."</td>
                </tr>";

            $fee_sum += $fees;
            } 
        ?>

    </table>  
    <table class='table2' style="width:100%">
        <?php
        $applnfees = '100';
        $marksfees = '50';
        if ($_SESSION['consolidated_attendance'] < 75 && $_SESSION['consolidated_attendance'] >= 60)
        {
            $attendance_shortage_fee = '500';
        }
        else{
            $attendance_shortage_fee = '0';
        }
     
        $totalfees = $applnfees + $marksfees + $fee_sum + $attendance_shortage_fee;
        ?>
        <tr><td>Application Fees</td><td  style="width:15%"><?php echo($applnfees); ?></td></tr>
        <tr><td>Statement of Marks</td><td  style="width:15%"><?php echo($marksfees); ?></td></tr>
        <tr><td>Attendance Shortage fees</td><td  style="width:15%"><?php echo($attendance_shortage_fee); ?></td></tr>
        <tr><td>Total Exam Fees Payable</td><td><?php echo($totalfees); ?></td></tr>   
    </table>
    <div class="pay_btn">
        <button class = "btn" type="button">Proceed to Pay</button>
    </div>
    </body>
</html>

