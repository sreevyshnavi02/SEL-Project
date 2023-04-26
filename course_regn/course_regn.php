<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>

    <?php 
        include "../header.php"; 
        $stud_data = get_stud_data($conn, $_SESSION['regno']); 
        echo "<div class='stud_details_crs'>";
        echo "<h3> Regno: ".$stud_data['regno']."</h3>";  
        echo "<h3> Name: ".$stud_data['sname']."</h3>";  
        echo "<h3> Sem: ".$stud_data['curr_sem']."</h3>";  
        echo "</div>";

        $_SESSION['curr_sem'] = $stud_data['curr_sem'];
        
        // Get the regno and curr_sem values from the $stud_data array
        $regno = $stud_data['regno'];
        $curr_sem = $stud_data['curr_sem'];

        // Prepare a PDO statement to check if the values exist in the table
        $stmt = $conn->prepare("SELECT * FROM u_course_regn WHERE regno = :regno AND sem = :curr_sem");

        // Bind the values to the prepared statement
        $stmt->bindParam(':regno', $regno);
        $stmt->bindParam(':curr_sem', $curr_sem);

        // Execute the prepared statement
        $stmt->execute();

        // Check if the number of rows returned is greater than 0
        if ($stmt->rowCount() > 0) {
            // The values exist in the table
            echo "<h1>Course registration already done!</h1>";

            //redirect to course_regn_confirmation.php
            // header("Location: course_regn_confirmation.php");
        } else {
            // The values do not exist in the table
            //creating a 2d array that can be used for pushing the courses regd for
            $row_count = 0;
        ?>
        <form class="course_regn" action="submit_course_regn.php" method="post">

        <!-- Display compulsory courses -->
        <h2 style='text-align:center; padding: 1rem; margin-bottom: 1rem;'>Compulsory Courses</h2>
        <table class="courses">
            <tr>
                <th>Course Code</th>
                <th>Course Name</th>
                <th>Credits</th>
                <th>Faculty 1</th>
                <th>Faculty 2</th>
            </tr>
            <?php
            $comp_courses = fetch_comp_courses($conn, $stud_data['prgm_id'], $stud_data['curr_sem']);

            foreach($comp_courses as $c){
                $course = fetch_course_details($conn, $c['course_code']);
                echo "<tr>";
                echo '<td><input type="text" value = "'.$course["COURSE_CODE"].'" name = "data['.$row_count.'][]"></td>';
                // echo '<td><input type="text" value = "'.$course["COURSE_CODE"].'" name = "course_code[]" ></td>';
                echo "<td>".$course['COURSE_NAME']."</td>";
                echo "<td>".$course['CREDITS']."</td>";
                display_fac_names($conn, $row_count);
                display_fac_names($conn, $row_count);
                echo "</tr>";
                $row_count ++;
            }
            ?>
        </table>


        <!-- Display Open elective courses if applicable -->
        <?php
        $_SESSION['session'] = '23A';
        $oec = fetch_oec($conn, $stud_data['regno'], $_SESSION['session']);
        if($oec != 0){
        ?>
            <h2 style='text-align:center; padding: 1rem; margin-bottom: 1rem;'>Open Elective Course</h2>
            <table class="courses">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Faculty 1</th>
                    <th>Faculty 2</th>
                </tr>
                
                <?php
                foreach($oec as $c){
                    $course = fetch_course_details($conn, $c['course_code']);
                    echo "<tr>";
                    echo "<td><input type='text' value = '".$course['COURSE_CODE']."' readonly name='data[".$row_count."][]'></td>";
                    echo "<td>".$course['COURSE_NAME']."</td>";
                    echo "<td>".$course['CREDITS']."</td>";
                    display_fac_names($conn, $row_count);
                    display_fac_names($conn, $row_count);
                    echo "</tr>";
                    $row_count ++;
                    
                }
                ?>
            </table>
            <?php
            }
            ?>

        <!-- Display Program elective courses offered for that sem to choose from -->


        <!-- Display Honor/Minor course if applicable -->

        <?php
        $_SESSION['session'] = '23A';
        $hm_course = fetch_hm($conn, $stud_data['regno'], $stud_data['curr_sem']);
        if($hm_course != 0){
        ?>
            <h2 style='text-align:center; padding: 1rem; margin-bottom: 1rem;'>Honor/Minor Course</h2>
            <table class="courses">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Faculty 1</th>
                    <th>Faculty 2</th>
                </tr>
                
                <?php
                foreach($hm_course as $c){
                    $course = fetch_course_details($conn, $c['course_code']);
                    echo "<tr>";
                    echo "<td><input type='text' value = '".$course['COURSE_CODE']."' readonly name='data[".$row_count."][]'></td>";
                    echo "<td>".$course['COURSE_NAME']."</td>";
                    echo "<td>".$course['CREDITS']."</td>";
                    display_fac_names($conn, $row_count);
                    display_fac_names($conn, $row_count);
                    echo "</tr>";
                    $row_count ++;

                }
                ?>
            </table>
        <?php
        }
        ?>


        <!-- Display uncleared mandatory 0 cred course if not cleared in the prev sem -->
        
        <?php
        $_SESSION['session'] = '23A';
        $zero_cred = fetch_uncleared_mandatory($conn, $stud_data['regno'], $_SESSION['session']);
        if($zero_cred != 0){
        ?>
            <h2 style='text-align:center; padding: 1rem; margin-bottom: 1rem;'>Mandatory 0 credit Course(uncleared)</h2>
            <table class="courses">
                <tr>
                    <th>Course Code</th>
                    <th>Course Name</th>
                    <th>Credits</th>
                    <th>Faculty 1</th>
                    <th>Faculty 2</th>
                </tr>
                
                <?php
                foreach($zero_cred as $c){
                    $course = fetch_course_details($conn, $c['course_code']);
                    echo "<tr>";
                    echo "<td><input type='text' value = '".$course['COURSE_CODE']."' readonly name='data[".$row_count."][]'></td>";
                    echo "<td>".$course['COURSE_NAME']."</td>";
                    echo "<td>".$course['CREDITS']."</td>";
                    display_fac_names($conn, $row_count);
                    display_fac_names($conn, $row_count);
                    echo "</tr>";
                    $row_count ++;
                }
                ?>
            </table>
        <?php
        }
        ?>
        <button type="submit" class="small_btn" onclick="get_confirmation()">Submit</button>
        </form>
        <?php
        }
        ?>



        <script>
            function get_confirmation() {
                alert("Make sure you have checked the details. Are you sure to submit?");
                // window.location.href = "submit_course_regn.php";
            }
        </script>


</body>
</html>


<?php 
    function get_stud_data($conn, $regno){
        $query = $conn -> query("select regno, sname, prgm_id, curr_sem 
        from u_student 
        where regno = '$regno'");
        $query -> execute();
        $row = $query -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function fetch_comp_courses($conn, $prgm_id, $curr_sem){
        $query = $conn -> query("select course_code 
        from u_prgm_comp_course 
        where prgm_id = '$prgm_id' and sem = '$curr_sem'");
        $query -> execute();
        $comp_courses = $query -> fetchAll(PDO::FETCH_ASSOC);
        return $comp_courses;
    }

    function fetch_oec($conn, $regno, $session){
        $query = $conn -> query("select course_code 
        from u_oec_allotment 
        where regno = '$regno' and session = '$session'");

        $query -> execute();
        $n = $query -> rowCount();

        if($n == 0){
            return 0;
        }
        else{
            $result = $query -> fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function fetch_hm($conn, $regno, $curr_sem){
        $query = $conn -> query("select alloted_prgm 
        from u_hm_allotment 
        where regno = '$regno' and withdrawal_date is null");

        $query -> execute();
        $n = $query -> rowCount();
        
        if($n == 0){
            // not in any hm prgm
            return 0;
        }
        else{
            $result = $query -> fetch(PDO::FETCH_ASSOC);
            $prgm_id = $result['alloted_prgm'];

            $query2 = $conn -> query("select course_code 
            from u_prgm_comp_course 
            where prgm_id = '$prgm_id' and sem = '$curr_sem'");

            $query2 -> execute();

            $result2 = $query2 -> fetchAll(PDO::FETCH_ASSOC);
            return $result2;
        }
    }

    function fetch_uncleared_mandatory($conn, $regno, $session){
        $month = $session[2];
        // echo "month = ".$month."<br>";
        $query = $conn -> query("select e.course_code 
        from u_external_marks e, u_course c
        where e.regno = '$regno' and 
        e.grade like 'F' and 
        c.course_code = e.course_code and 
        c.credits = 0 and e.session like '%%$month'");

        $query -> execute();
        $n = $query -> rowCount();

        if($n == 0){
            return 0;
        }
        else{
            $result = $query -> fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
    }

    function fetch_course_details($conn, $course_code){
        $query = $conn -> query("select * 
        from u_course 
        where course_code = '$course_code'");
        $query -> execute();
        $row = $query -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function display_fac_names($conn, $row_count){
        $query = $conn -> query("select faculty_id, fname from u_faculty");
        $query -> execute();
        $fac_names = $query -> fetchAll(PDO::FETCH_ASSOC);
        echo "<td><select name='data[".$row_count."][]'>";
        print_r($fac_names);
        echo "<option value=''>Choose Faculty</option>";
        foreach($fac_names as $fac){
            echo "<option value=".$fac['faculty_id'].">".$fac['fname']."</option>";
        }
        echo "</select></td>";
    }
?>