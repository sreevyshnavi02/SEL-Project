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

        // Retrieve eligible student options
        $options_query = "SELECT h.REGNO, s.sname, OPT1_PRGM_ID, OPT2_PRGM_ID, OPT3_PRGM_ID, CGPA 
                        FROM u_hm_preregistration h, u_student s
                        WHERE CGPA > 7.5 and s.regno = h.regno;";
        $options_result = $conn->query($options_query);
        $registrations = $options_result -> fetchAll(PDO::FETCH_ASSOC);

        //creating a html table
        echo "<h1 style='text-align:center;'>Received Pre-registrations</h1>";
        echo ("<table class='hm_reg_table'>");
            echo("<tr>");
            echo("<th>REGNO</th>");
            echo("<th>Name</th>");
            echo("<th>CGPA</th>");
            echo("<th>OPTION 1</th>");
            echo("<th>OPTION 2</th>");
            echo("<th>OPTION 3</th>");
            echo("</tr>");


        foreach($registrations as $reg){
            echo("<tr>");
            echo("<td>".$reg['REGNO']."</td>");
            echo("<td>".$reg['sname']."</td>");
            echo("<td>".$reg['CGPA']."</td>");
            echo("<td>".$reg['OPT1_PRGM_ID']."</td>");
            echo("<td>".$reg['OPT2_PRGM_ID']."</td>");
            echo("<td>".$reg['OPT3_PRGM_ID']."</td>");
            echo("</tr>");
        }
        echo("</table>");
    ?>
    <button class="small_btn" onclick="goback()">Allot programmes</button>

    <script>
        function goback() {
            window.location.href = "admin_allot_hm_logic.php";
        }
    </script>
</body>
</html>
