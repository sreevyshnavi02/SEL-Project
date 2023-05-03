<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <!-- check if the student is btwn 4th to 7th sem -->
    <?php 
        include '../header.php'; 
        $year =  $_POST['session_year'];
        $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
        $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];

        $regno = $_SESSION['regno'];   //entered during login
        //-------temporary--------
        //to get the session as input from the user
        $session = $_SESSION['chosen_session']; 

        //------redirecting to the allotment order page if the student has already registered for oec----

        //check if they have already regd
        $check_stud_regd = $conn -> query ("select * from u_oec_allotment where regno = '$regno' and session = '$session';");
        $num_rows = $check_stud_regd -> rowCount();

        if($num_rows > 0){
            header('Location: oec_allotment_order.php');
        }

            //eligible to register for oec
            //display a drop down menu with the available oecs

            //check if the capacity is reached for an oec before displaying it

            $fetch_oec_sql = "select e.course_code, c.course_name, c.course_type 
            from u_prgm_elective_course e, u_course c, u_student s, u_prgm p
            where e.no_of_students_enrolled < e.capacity 
            and e.session = :sess 
            and e.course_code = c.course_code 
            and s.regno = :regno
            and s.prgm_id = p.prgm_id 
            and c.dept_id != p.dept_id";

            $fetch_oec_query = $conn -> prepare($fetch_oec_sql);
            $fetch_oec_query -> bindParam(':sess', $session);
            $fetch_oec_query -> bindParam(':regno', $regno);
            $fetch_oec_query -> execute();

            $fetch_oec = $fetch_oec_query -> fetchAll(PDO::FETCH_ASSOC);

            $fetch_stud_details_sql = "select sname, curr_sem, credits_earned from u_student where regno = :regno";
            $fetch_stud_details = $conn -> prepare($fetch_stud_details_sql);
            $fetch_stud_details -> bindParam(':regno', $regno);
            $fetch_stud_details -> execute();
            $n = $fetch_stud_details -> rowCount();

            $fetched_stud_data = $fetch_stud_details -> fetchAll(PDO::FETCH_ASSOC);

            //display the rows fetched in this query in drop-down menu
        ?>

        <div class="oec_option_div">
            <!-- display student details -->
            <form action="preregister_submit.php" method = "post">
                <?php 
                foreach($fetched_stud_data as $stud_data){ 
                ?>
                <div class="oec_options">
                    <p>Name: <?php echo $stud_data['sname'] ?></p>
                    <p>Semester: <?php echo $stud_data['curr_sem'] ?></p>
                    <p>Credits earned: <?php echo $stud_data['credits_earned'] ?></p>
                <?php
                }

                echo "<p>Choose OEC: ";
                echo '<select name="oec_choose" id="oec_choose"></p>';
                foreach($fetch_oec as $oec){
                    echo('<option value="'.$oec["course_code"].'">'.$oec["course_code"].' - '.$oec["course_name"].'</option>');
                }
                echo '</select>';

                ?>

                <button type="submit" class="submit_option">Confirm Option</button>
                </div>
            </form>
        </div>

</body>
</html>