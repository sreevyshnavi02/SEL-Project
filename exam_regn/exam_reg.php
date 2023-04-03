<?php
    include '../connection.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="exam_regn_form_style.css">
            <title>PTU-COE</title>
    </head>
    <body>
    <?php
            // include 'fetch_data.php';
            // // include 'chk_eligibility.php'

            // $_SESSION['regno'] = $_POST['regno'];
            $_SESSION['session'] = $_POST['session'];
            //fetching the details of the student based on regno
            $data_fetch_query = mysqli_query($conn, "select s.sname, p.prgm_name, d.dept_name from u_student s, u_prgm p, u_dept d
            where s.regno = '$_SESSION[regno]' and p.prgm_id = s.prgm_id and d.dept_id = p.dept_id");

            $fetched_data = mysqli_fetch_assoc($data_fetch_query);
            $name = $fetched_data['sname'];
            $prgm_name = $fetched_data['prgm_name'];
            $dept_name = $fetched_data['dept_name'];

            //query to get the consolidated attendance of the student
            $attendance_q = "SELECT consolidated_attendance 
            from u_exam_regn where regno='$_SESSION[regno]' 
            and session = '$_SESSION[session]'";

            $attendance_r = mysqli_query($conn, $attendance_q);
            $attendance = mysqli_fetch_assoc($attendance_r);
            $_SESSION['consolidated_attendance'] = $attendance['consolidated_attendance'];

            $subjectquery = "SELECT u_course_regn.course_code,u_course_regn.sem,session,course_name,course_type 
                            from u_course_regn 
                            inner join u_course 
                            on u_course_regn.course_code=u_course.course_code 
                            where regno='$_SESSION[regno]' and session = '$_SESSION[session]'"; 
            $registered_courses = mysqli_query($conn, $subjectquery);   



            //query to bring in all the history of arrears for that student
            $arrear_q = "SELECT regno, course_code, session from u_external_marks
            where regno='$_SESSION[regno]' and grade in ('F','Z')";

            $arrear_courses = mysqli_query($conn, $arrear_q);

            $arrears_array = array();
            
            foreach($arrear_courses as $arrear)
            {
                //pushing all the arrear history into arrears_array 
                array_push(
                    $arrears_array, 
                    array($arrear['regno'],$arrear['course_code'], $arrear['session'])
                );
            }

            foreach ($arrears_array as $i => $row) {
                $a_query = "SELECT * from u_external_marks 
                    where regno='$row[0]' 
                    and grade not in ('F','Z') 
                    and course_code='$row[1]' ";

                $a = mysqli_query($conn,$a_query);
                $x=mysqli_num_rows($a);
                if($x>0){
                    unset($arrears_array[$i]);
                }
            }

            $_SESSION['current_backlogs'] = $arrears_array;
    ?>
    
    <div class='img'>
        <img src="../images/logo_ptu.png" alt="PTU logo" style=" width: 10%;height: 30%;display: block;margin-left: auto;margin-right: auto;">
    </div>
    <div class='Header'>
        <h1>Puducherry Technological University<br>(PTU)</h1>
    </div>
    <div class='Details'>
        <h2><b>Examination Wing</b><br><?php echo "$_SESSION[session]" ?></h2>
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