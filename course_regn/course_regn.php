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
    ?>

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
        $comp_courses = fetch_comp_courses($conn, $stud_data['prgm_id'], $stud_data['curr_sem']);

        foreach($comp_courses as $c){
            $course = fetch_course_details($conn, $c['course_code']);
            echo "<tr>";
            echo "<td>".$course['COURSE_CODE']."</td>";
            echo "<td>".$course['COURSE_NAME']."</td>";
            echo "<td>".$course['CREDITS']."</td>";
            display_fac_names($conn, 'comp1');
            display_fac_names($conn, 'comp2');
            echo "</tr>";
        }
        ?>
    </table>


    <!-- Display Open elective courses if applicable -->
    <?php
    $_SESSION['session'] = '23A';
    $oec = fetch_oec($conn, $stud_data['regno'], $_SESSION['session']);
    if($oec != 0){
    ?>
        <h2>Open Elective Course</h2>
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
                echo "<td>".$course['COURSE_CODE']."</td>";
                echo "<td>".$course['COURSE_NAME']."</td>";
                echo "<td>".$course['CREDITS']."</td>";
                display_fac_names($conn, 'comp1');
                display_fac_names($conn, 'comp2');
                echo "</tr>";
            }
            ?>
        </table>
        <?php
        }
        ?>

    <!-- Display Program elective courses offered for that sem to choose from -->
    <?php
    $_SESSION['session'] = '23A';
    $oec = fetch_hm($conn, $stud_data['regno'], $_SESSION['session']);
    if($hm_course != 0){
    ?>
        <h2>Honor/Minor Course</h2>
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
                echo "<td>".$course['COURSE_CODE']."</td>";
                echo "<td>".$course['COURSE_NAME']."</td>";
                echo "<td>".$course['CREDITS']."</td>";
                display_fac_names($conn, 'comp1');
                display_fac_names($conn, 'comp2');
                echo "</tr>";
            }
            ?>
        </table>
    <?php
    }
    ?>

    <!-- Display Honor/Minor course if applicable -->

    <!-- Display uncleared mandatory 0 cred course if not cleared in the prev sem -->
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

    function fetch_course_details($conn, $course_code){
        $query = $conn -> query("select * 
        from u_course 
        where course_code = '$course_code'");
        $query -> execute();
        $row = $query -> fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function display_fac_names($conn, $fac_for){
        $query = $conn -> query("select faculty_id, fname from u_faculty");
        $query -> execute();
        $fac_names = $query -> fetchAll(PDO::FETCH_ASSOC);
        echo "<td><select name='faculty".$fac_for."[]'>";
        print_r($fac_names);
        echo "<option value=''>Choose Faculty</option>";
        foreach($fac_names as $fac){
            echo "<option value=".$fac['faculty_id'].">".$fac['fname']."</option>";
        }
        echo "</select></td>";
    }
?>