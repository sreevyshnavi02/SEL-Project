<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
    <link rel="stylesheet" href="../style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
    </script>
</head>
<body>
    <!-- display student details -->
    <div class="box" id="makepdf">
        <div class="allotment-order-header">
            <div class="univ_logo">
                <img src="../images/logo_ptu.png" alt="ptu-logo">
            </div>
            <div class="univ_name">
                <h1>PUDUCHERRY TECHNOLOGICAL UNIVERSITY</h1>
                <h2>(Erstwhile Pondicherry Engineering College)</h2>
                <h2>An Autonomous Institution</h2>
            </div>
        </div>
        <div class="stud_details_box">
            <div class="photo">
                <?php 
                include '../connection.php';
                $src = "../images/18-BT-IMG/".$_SESSION['regno'].".png"; 
                echo "<img src=$src alt='stud_photo'>";
                ?>
            </div>
            <div class="stud_details">

                <h2>STUDENT DETAILS</h2>
                
                <!-- Fetching the data -->
                <?php 

                $stud_details_sql = "select s.REGNO, s.SNAME, s.EMAIL, s.CURR_SEM, p.PRGM_NAME, d.DEPT_NAME from u_student s, u_prgm p, u_dept d where s.regno = :regno and p.prgm_id = s.prgm_id and d.dept_id = p.dept_id;";
                $stud_details_query = $conn -> prepare($stud_details_sql);
                $stud_details_query -> bindParam(':regno', $_SESSION['regno']);
                $stud_details_query -> execute();

                //to fetch the results
                $stud_details_fetch = $stud_details_query -> fetchAll(PDO::FETCH_ASSOC);

                foreach($stud_details_fetch as $stud_details){
                    ?>

                <table class="stud_details_table">
                    <tr>
                        <th>NAME</th>
                        <td><?php echo "$stud_details[SNAME]"; ?></td>
                    </tr>
                    <tr>
                        <th>REGISTER NUMBER</th>
                        <td><?php echo "$stud_details[REGNO]"; ?></td>
                    </tr>
                    <tr>
                        <th>EMAIL</th>
                        <td><?php echo "$stud_details[EMAIL]"; ?></td>
                    </tr>
                    <tr>
                        <th>PROGRAMME</th>
                        <td><?php echo "$stud_details[PRGM_NAME]"; ?></td>
                    </tr>
                    <tr>
                        <th>DEPARTMENT</th>
                        <td><?php echo "$stud_details[DEPT_NAME]"; ?></td>
                    </tr>
                    <tr>
                        <th>SEMESTER</th>
                        <td><?php echo "$stud_details[CURR_SEM]"; ?></td>
                    </tr>
                </table>
            </div>

            <?php 
            } 
            
            // fetching course details from u_hm_allotment
            $oec_details_sql = "select p.prgm_name, p.dept_id, h.allotment_date 
            from u_hm_allotment h, u_prgm p 
            where h.regno = :regno
            and p.prgm_id = h.alloted_prgm;";
            $oec_details_query = $conn -> prepare($oec_details_sql);
            $oec_details_query -> bindParam(':regno', $_SESSION['regno']);
            $oec_details_query -> execute();
            
            //to fetch the results
            $oec_details_fetch = $oec_details_query -> fetchAll(PDO::FETCH_ASSOC);
            
            foreach($oec_details_fetch as $oec_details){
            ?>
        </div>

        <div class="oec_box">
            <div class="oec_title">
                <h2>
                    HONOR/MINOR ALLOTMENT DETAILS
                </h2>
            </div>
            <div class="oec_details">
                <table class="oec_details_table">
                    <tr>
                        <th>Programme Name</th>
                    </tr>
                    <tr>
                        <td><?php echo "$oec_details[course_code]"; ?></td>
                        <td><?php echo "$oec_details[course_name]"; ?></td>
                        <td><?php echo "$oec_details[credits]"; ?></td>
                        <td><?php echo "$oec_details[allotment_date]"; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php 
        }
        ?>

    </div>

    <button class="small_btn" id="print">Download</button>
    <script>
        console.log('print pdf');
        var button = document.getElementById("print");
        var makepdf = document.getElementById("makepdf");

        button.addEventListener("click", function () {
            console.log("download btn clicked");
            html2pdf().from(makepdf).save();
        });
    </script> 
</body>
</html>