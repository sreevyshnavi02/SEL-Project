<!DOCTYPE html>
<html>
    <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
        </script>
        <link rel="stylesheet" href="pdf_style.css">
    </head>
    <body>
        <div id="makepdf">
            <div class="college_dets">
            <!-- <div class="imgg">
                <img class="image" src="../PTU_Logo-2.png" alt="PTU logo">
            </div> -->
            <div class="ccname">
                <h2>PUDUCHERRY TECHNOLOGICAL UNIVERSITY<br><br>Office of Controller of Examination</h2>
            </div>
            </div>
            <div class="course_dets">

                <!-- displaying the session and course code -->
                <b><h3>Session:<?php echo($_SESSION['session']);?></b><br><br>
                </h3>
                <?php

                $get_data = mysqli_query($conn, 
                    "select c.regno, s.sname, c.internal_marks
                    from u_course_regn c, u_student s
                    where c.course_code = '$_SESSION[course_code]' 
                    and c.session = '$_SESSION[session]' 
                    and c.regno = s.regno;"
                );
                echo("
                <table class='marks_table'>
                <tr>
                    <th>Regno</th>
                    <th>Name</th>
                    <th>Internal Marks(Out of 40)</th>
                </tr>
                <script> var i = 1; </script>");
                $int_marks_array = array();

                //fetch all the data from the u_course_regn into $int_marks_array
                foreach($get_data as $stud_details){
                    // echo("Inside foreach");
                    // print_r($stud_details);
                    array_push(
                        $int_marks_array, 
                        array($stud_details['regno'], $stud_details['sname'], $stud_details['internal_marks'])
                    );
                }
                foreach($int_marks_array as $i => $row){
                    echo("
                    <tr>
                        <td>".$row[0]."</td>
                        <td>".$row[1]."</td>
                        <td>".$row[2]."</td>
                    </tr>
                    ");
                }
                echo("</table>");

                ?>
            </div>
        </div>
            <button id="button">Download</button>
            <script>
                var button = document.getElementById("button");
                var makepdf = document.getElementById("makepdf");
        
                button.addEventListener("click", function () {
                    html2pdf().from(makepdf).save();
                });
            </script> 
    </body>
</html>