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
        if(isset($_POST['submit_session'])){
            $_SESSION['session'] = $_POST['session'];
            $regno_q = "SELECT  distinct regno from u_course_regn where session = '$_SESSION[session]';";
            $regno = mysqli_query($conn, $regno_q);
            foreach($regno as $r)
            {
                $attendance_query = "SELECT session, round(avg(attendance)) as consolidated_attendance from u_course_regn where regno='$r[regno]'";
                $con_attendance = mysqli_query($conn, $attendance_query);
                $data_fetch = mysqli_fetch_assoc($con_attendance);
                
                if($data_fetch['consolidated_attendance'] >= 75){
                    $eligible = 1;
                }
                else{
                    $eligible = 0;
                }
                
                //sql query to check for dupliactes
                $inserted_rows = mysqli_query($conn, "select * from u_exam_regn where regno = '$r[regno]' and session = '$data_fetch[session]'");
                //if there is no entry yet - to avoid duplicate entry error
                if(mysqli_num_rows($inserted_rows) == 0){
                    $att_entry_query = "INSERT into u_exam_regn(regno,session,consolidated_attendance, eligible_for_exam) values('$r[regno]','$data_fetch[session]','$data_fetch[consolidated_attendance]', '$eligible')";
                    $att_entry = mysqli_query($conn, $att_entry_query);
                }
                // if($att_entry)
                // {
                    //     echo "<br>Success";
                    // }
                    // else
                    // {
                        //     echo "Error";
                        // }
            }
        }
        //display the consolidated attendance 
        // regno, name, attendance percentage, eligible or not
        $display_att_query = "select e.regno, s.sname, e.consolidated_attendance, e.eligible_for_exam 
        from u_student s, u_exam_regn e 
        where s.regno = e.regno;";
        $display_att_run = mysqli_query($conn, $display_att_query);
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