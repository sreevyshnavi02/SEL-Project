<?php
    include '../header.php';
    if (isset($_POST['data'])) {
        // Get the data from the $_POST variable
        $data = $_POST['data'];

        // Looping through each row of data and inserting to the db
        foreach ($data as $row) {
            print_r($row);
            echo "<br>";
            $course_code = $row[0];
            $course_name = $row[1];
            $dept_id = $row[2];
            $fname = $row[3];
            $credits = $row[4];
            $capacity = $row[5];
            $sess = $_SESSION['chosen_session'];


            //TEMP 
            // -----------------------remove later-------------------------
            $fid = '1';

            $check_duplicate= $conn -> query("select * from u_prgm_elective_course where session = '$sess' and course_code = '$course_code';");
            $n = $check_duplicate -> rowCount();

            if($n > 0){
                //update the table if the course code is already in the table in that session
                $update_sql = "update u_prgm_elective_course set faculty_id = :fid, capacity = :capacity ";
                $update_sql_prepare = $conn -> prepare($update_sql);
                $update_oec = $update_sql_prepare -> execute(
                    [
                        ':capacity' => $capacity,
                        ':fid' => $fid
                    ]);

                echo "updated ".$course_code;
            }
            else{
                //insert these into the u_prgm_elective_course table - if new
                $insert_sql = "insert into u_prgm_elective_course(course_code, capacity, session, faculty_id) values(:course_code, :capacity, :sess, :fid);";
                $insert_sql_prepare = $conn -> prepare($insert_sql);
                $insert_oec = $insert_sql_prepare -> execute(
                    [
                        ':course_code' => $course_code,
                        ':capacity' => $capacity,
                        ':sess' => $sess,
                        ':fid' => $fid
                    ]);
                    
                    echo "executed insert";
            }
        }
    } 
    else {
        // Handle the error
        echo "No data entered!";
    }
?>
