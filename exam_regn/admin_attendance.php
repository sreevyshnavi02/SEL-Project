<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">s</script>
</head>
<body>
    <?php
        include '../header.php';

        // getting the session chosen by the user
        $year =  $_POST['session_year'];
        $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
        $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];
        
        //selecting all the students who have registered for various courses during the session        
        $regno_sql = "SELECT  distinct regno from u_course_regn where session = :sess;";
        $registered_students = $conn -> prepare($regno_sql);
        $registered_students -> bindParam(':sess', $_SESSION['chosen_session']);
        $registered_students -> execute();

        //to fetch the results
        $registered_students = $registered_students -> fetchAll(PDO::FETCH_ASSOC);

        foreach($registered_students as $r)
        {
            echo $r['regno'];
            $attendance_query = "SELECT session, round(avg(attendance)) as consolidated_attendance from u_course_regn where regno=:regno";
            $con_attendance = $conn -> prepare($attendance_query);
            $con_attendance -> bindParam(':regno', $r['regno']);
            $con_attendance -> execute();

            //to fetch the results
            $con_attendance = $con_attendance -> fetchAll(PDO::FETCH_ASSOC);
            
            if($con_attendance['consolidated_attendance'] >= 75){
                $eligible = 1;
            }
            else{
                $eligible = 0;
            }
            
            //sql query to check for dupliactes
            $inserted_rows = $conn -> query("select * from u_exam_regn where regno = '$r[regno]' and session = '$data_fetch[session]'");
            $n = $inserted_rows -> rowCount();
            //if there is no entry yet - to avoid duplicate entry error
            if($n == 0){
                $insert_sql = "INSERT into u_exam_regn(regno,session,consolidated_attendance, eligible_for_exam) values(:regno, :sess, :consolidated_attendace, :eligible)";
                $insert_sql_prepare = $conn -> prepare($insert_sql);
                $insert_oec = $insert_sql_prepare -> execute(
                    [
                        ':regno' => $r['regno'],
                        ':sess' => $_SESSION['chosen_session'],
                        ':consolidated_attendace' => $con_attendance['consolidated_attendance'],
                        ':eligible' => $eligible
                    ]);
            }
        }
        
        //display the consolidated attendance 
        // regno, name, attendance percentage, eligible or not
        $display_att_query = "select e.regno, s.sname, e.consolidated_attendance, e.eligible_for_exam 
        from u_student s, u_exam_regn e 
        where s.regno = e.regno and e.session = :sess;";
        $display_att_run = $conn -> prepare($display_att_query);
        $display_att_run -> bindParam(':sess', $_SESSION['chosen_session']);
        $display_att_run -> execute();
        $display_att_run = $display_att_run -> fetchAll(PDO::FETCH_ASSOC);
        ?>

        <div id="makepdf">

            <table class = "disp_con_att">
                <tr>
                <th>Regno</th>
                <th>Name</th>
                <th>Consolidated_attendance</th>
                <th>Eligible for exam</th>
                </tr>

                <?php
                foreach($display_att_run as $row){
                ?>
                    <tr>
                        <td><?php echo($row['regno']); ?></td>
                        <td><?php echo($row['sname']); ?></td>
                        <td><?php echo($row['consolidated_attendance']); ?></td>
                        <td><?php 
                        if($row['eligible_for_exam'] == 1){
                            $x = 'Eligible';
                        }
                        else
                        {
                            $x = 'Not Eligible';
                        }
                        echo($x); ?></td>
                </tr>
                <?php 
                } ?>
            </table>
        </div>
    


        <!-- Provision to print the summary as pdf if reqd -->
        <button id="button" class = "download_pdf">Download</button>
        <script>
            var button = document.getElementById("button");
            var makepdf = document.getElementById("makepdf");
    
            button.addEventListener("click", function () {
                html2pdf().from(makepdf).save();
            });
        </script> 
</body>
</html>