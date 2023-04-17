<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="exam_regn_form_style.css">
            <title>PTU-COE</title>
    </head>
    <body>
    <?php
        include '../connection.php';

        //fetching the details of the student based on regno
        $stmt = $conn->prepare("SELECT s.sname, s.prgm_id, p.prgm_name, d.dept_name 
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
        $_SESSION['prgm_id'] = $stud_details['prgm_id'];

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

            foreach($_POST['arrear_courses'] as $a)
            {
                $arrear = get_course_details($conn, $a);
                if(trim($arrear['COURSE_TYPE'])=='TY'){
                    $arrear['COURSE_TYPE'] = 'Theory';
                    $fees='250';
                }
                elseif(trim($arrear['COURSE_TYPE'])=='LB'){
                    $arrear['COURSE_TYPE'] = 'Laboratory';
                    $fees='350';
                }
                elseif(trim($arrear['COURSE_TYPE'])=='MC'){
                    $arrear['COURSE_TYPE'] = 'Mandatory Course';
                    $fees='0';
                }
                else{
                    echo("else...".$arrear['COURSE_TYPE']);
                }

                echo "
                <tr>
                    <td>".$arrear['COURSE_CODE']."</td>
                    <td>".$arrear['COURSE_NAME']."</td>
                    <td>".$arrear['SEM']."</td>
                    <td>".$arrear['COURSE_TYPE']."</td>
                    <td>".$fees."</td>
                </tr>";

            $fee_sum += $fees;
            } 


            function get_course_details($conn, $a){
                $sql = "select c.COURSE_CODE, COURSE_NAME, COURSE_TYPE, p.SEM 
                from u_course c, u_prgm_comp_course p
                where c.course_code = '$a'
                and p.prgm_id = '$_SESSION[prgm_id] 
                and p.course_code = c.course_code'";
                $query = $conn -> query($sql);

                $query -> execute();
                $arrear = $query -> fetch(PDO::FETCH_ASSOC);
                return $arrear;
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

