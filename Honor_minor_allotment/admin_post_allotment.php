<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <!-- display the allotments made and provide option to edit or drop an allotted prgm -->
    <?php
        $hm_allotments = $conn -> query("
        select h.regno, p.prgm_name, p.dept_id, h.allotment_date, h.withdrawal_date, r.cgpa, s.sname
        from u_hm_allotment h, u_student s, u_hm_preregistration r, u_prgm p
        where h.regno = r.regno and h.regno = s.regno and h.alloted_prgm = p.prgm_id;");
        $hm_allotments -> execute();

        echo "<h1 style='text-align:center;'>Allotted Honor/Minor Programmes</h1>";
        echo ("<table class='hm_reg_table'>");
            echo("<tr>");
            echo("<th>REGNO</th>");
            echo("<th>Name</th>");
            echo("<th>CGPA</th>");
            echo("<th>Alloted Program</th>");
            echo("<th>Alloted Date</th>");
            echo("<th>Withdrawal Date</th>");
            echo("</tr>");

        $hm_allotments = $hm_allotments -> fetchAll(PDO::FETCH_ASSOC);
        foreach($hm_allotments as $row){
            echo("<tr>");
            echo("<td>".$row['REGNO']."</td>");
            echo("<td>".$row['sname']."</td>");
            echo("<td>".$row['CGPA']."</td>");
            echo("<td>".$row['dept_id']." - ".$row['prgm_name']."</td>");
            echo("<td>".$row['allotment_date']."</td>");
            echo("<td>".$row['withdrawal_date']."</td>");
            echo("</tr>");
        }
    ?>
</body>
</html>