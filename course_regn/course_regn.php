<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php include "../header.php"; ?>
    <!-- Display compulsory courses -->
    <h2>Compulsory Courses</h2>
    <table class="courses">
        <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Credits</th>
            <th>Faculty 1</th>
            <th>Faculty 2</th>
        </tr>
        <?php
        $stud_data = get_stud_data($conn, $_SESSION['regno']);
        $comp_courses = fetch_comp_courses($conn, $stud_data['prgm_id'], $stud_data['curr_sem']);

        foreach($comp_courses as $c){
            $course = fetch_course_details($conn, $c['course_code']);
            echo "<tr>";
            echo "<td>".$course['COURSE_CODE']."</td>";
            echo "<td>".$course['COURSE_NAME']."</td>";
            echo "<td>".$course['CREDITS']."</td>";
            echo "<td>".display_fac_names($conn)."</td>";

            
            echo "</tr>";
        }
        ?>
    </table>
    <!-- Display Open elective courses if applicable -->
    <!-- Display Program elective courses offered for that sem to choose from -->
    <!-- Display Honor/Minor course if applicable -->
    <!-- Display uncleared mandatory 0 cred course if not cleared in the prev sem -->
</body>
</html>


<?php 
    function get_stud_data($conn, $regno){
        $query = $conn -> query("select sname, prgm_id, curr_sem 
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

    function fetch_course_details($conn, $course_code){
        $query = $conn -> query("select * 
        from u_course 
        where course_code = '$course_code'");
        $query -> execute();
        $row = $query -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function display_fac_names($conn, $fac_for){
        $query = $conn -> query("select * from u_faculty");
        $query -> execute();
        $fac_names = $query -> fetchAll(PDO::FETCH_ASSOC);
        echo "<select name='faculty".$fac_for."'>";
        foreach($fac_names as $fac){
            echo "<option value=".$fac['faculty_id'].">".$fac['fac_name']."</option>";
        }
        echo "</select>";
    }
?>