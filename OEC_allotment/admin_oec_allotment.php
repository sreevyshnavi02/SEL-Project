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
    include '../header.php'; 
    $year =  $_POST['session_year'];
    $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
    $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];
    ?>

    <script>
        // function for checking course code using ajax
        function check_course_code(entered_course_code){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function(){
                if(this.readyState == 4 && this.status == 200){
                    //ready state = 4 when the data transfer is complete - successful transfer or failure
                    //status = 200 when the transfer is successful
                    console.log(this.response);
                    // document.getElementById("txt").innerHTML = this.response;
                    // document.getElementById("txt2").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "check_course_code.php?request=" + entered_course_code, true);
            xmlhttp.send();
        }
    </script>

<form action="admin_insert_oec.php" method="post">
    
    <h1 style="text-align: center; padding: 1rem;">OEC ALLOTMENT</h1>
    <table id="OEC_table">
        <tr>
            <th>Course Code</th>
            <th>Course Name</th>
            <th>Offered By(Department Name)</th>
            <th>Offered By(Faculty Name)</th>
            <th>Credits</th>
            <th>Max number of students</th>
        </tr>
        
        <?php 
            $fac_list_sql = "
            select faculty_id, fname from u_faculty f 
            where faculty_id != :fid;";
            $fac_list_query = $conn -> prepare($fac_list_sql);
            // <!-- create a php array to store all the data -->
            $oec_offered = array();
            
            // <!-- Retrieve the already added courses(if any) -->
            $offered_electives_sql = "
            select c.course_code, c.course_name, c.dept_id, f.faculty_id,
            f.fname, c.credits, e.capacity 
            from u_prgm_elective_course e, u_course c, u_faculty f 
            where session = :sess 
            and c.course_code = e.course_code 
            and f.faculty_id = e.faculty_id;";
            $offered_electives = $conn -> prepare($offered_electives_sql);
            $offered_electives -> bindParam(':sess', $_SESSION['chosen_session']);
            $offered_electives -> execute();

            //to fetch the results
            $existing_oec = $offered_electives -> fetchAll(PDO::FETCH_ASSOC);
            $row_count = 0;

            foreach($existing_oec as $oec){
                echo '
                <tr>
                <td><input type="text" onkeyup="check_course_code(this.value)" value="'.$oec["course_code"].'" name="data['.$row_count.'][]"></td>
                <td><input type="text" value="'.$oec["course_name"].'" name="data['.$row_count.'][]"></td>
                <td><input type="text" value="'.$oec["dept_id"].'" name="data['.$row_count.'][]"></td>';
                
                echo '
                <td>
                <select name="data['.$row_count.'][]" id="fname">
                <option value="'.$oec["faculty_id"].'">'.$oec["faculty_id"].' - '.$oec["fname"].'</option>';

                
                $fac_list_query -> bindParam(':fid', $oec['faculty_id']);
                $fac_list_query -> execute();

                $fac_list = $fac_list_query -> fetchAll(PDO::FETCH_ASSOC);

                foreach($fac_list as $fac_list_row){
                    echo'
                    <option value="'.$fac_list_row["faculty_id"].'">'.$fac_list_row["faculty_id"].' - '.$fac_list_row["fname"].'</option>
                    </select>
                    </td>';
                }
                
                ?>
                <!-- 
                -------------------------------
                //  drop down of faculty names
                --------------------------------
                //TO BE MODIFIED!! -->
                
                <?php
                echo '
                <td><input type="text" value="'.$oec["credits"].'" name="data['.$row_count.'][]"></td>
                <td><input type="text" value="'.$oec["capacity"].'" name="data['.$row_count.'][]"></td>
                </tr>';
                $row_count += 1;
            }
            echo '<script> let count = '.$row_count.'; </script>';
            

        ?>
            <!-- <tr>
                <td><input type="text" onkeyup="check_course_code(this.value)" name="data[" + encodeURIComponent(count) + "][]"></td>
                <td><input type="text" name="data[" + encodeURIComponent(count) + "][]"></td>
                <td><input type="text" name="data[" + encodeURIComponent(count) + "][]"></td>
                <td><input type="text" name="data[" + encodeURIComponent(count) + "][]"></td>
                <td><input type="text" name="data[" + encodeURIComponent(count) + "][]"></td>
                <td><input type="text" name="data[" + encodeURIComponent(count) + "][]"></td>
            </tr> -->
    </table>


    <!-- add this data to the db -->
    
    <button type="button" class = "small_btn" onclick=add_new_row()>Add another OEC</button>
    
    <input type="submit" class = "small_btn" value="Submit Data">
    </form>

    <button onclick="<?php header('location: ') ?>"></button>

    <script>
        function add_new_row(){
            console.log("adding new row..");

            var table = document.getElementById("OEC_table");
            var row = table.insertRow(-1);
            // -1 to insert another row at the end of the table
            var cell1 = row.insertCell(0);
            cell1.innerHTML = "<input type = 'text' onkeyup='check_course_code(this.value)' name='data[" + encodeURIComponent(count) + "][]'>";
            var cell2 = row.insertCell(1);
            cell2.innerHTML = "<input type = 'text' name='data[" + encodeURIComponent(count) + "][]'>"; 
            var cell3 = row.insertCell(2);
            cell3.innerHTML = "<input type = 'text' name='data[" + encodeURIComponent(count) + "][]'>";
            var cell4 = row.insertCell(3);
            cell4.innerHTML = "<select name='data[" + encodeURIComponent(count) + "][]'>";
                // <option value="'.$oec["faculty_id"].'">'.$oec["faculty_id"].' - '.$oec["fname"].'</option>';
                
                // $fac_list_query -> bindParam(':fid', $oec['faculty_id']);
                // $fac_list_query -> execute();

                // $fac_list = $fac_list_query -> fetchAll(PDO::FETCH_ASSOC);

                // foreach($fac_list as $fac_list_row){
                //     echo'
                //     <option value="'.$fac_list_row["faculty_id"].'">'.$fac_list_row["faculty_id"].' - '.$fac_list_row["fname"].'</option>
                //     </select>
                //     </td>';
                // }
            var cell5 = row.insertCell(4);
            cell5.innerHTML = "<input type = 'number' name='data[" + encodeURIComponent(count) + "][]'>";
            var cell6 = row.insertCell(5);
            cell6.innerHTML = "<input type = 'number' name='data[" + encodeURIComponent(count) + "][]'>";
            count++;
        }

    </script>
</body>
</html>