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
    

<?php
    include '../header.php';
    $sql = "SELECT sname,appn_num,centac_or_josaa,father_name,mother_name,dob,gender,phone,personal_email,address_line1, address_line2, address_state,nationality,community,entry_mode, yoj, p.prgm_name, d.dept_name
    FROM u_student s, u_prgm p, u_dept d 
    where appn_num='$_SESSION[application_no]' 
    and d.dept_id = p.dept_id 
    and s.prgm_id = p.prgm_id";	
    $query = $conn -> query($sql);
    $fetched_data = $query->fetchAll(PDO::FETCH_ASSOC);


    foreach($fetched_data as $x)
    {
        if ($x['centac_or_josaa'] === 'C') {
            $x['centac_or_josaa'] = 'CENTAC';
        } else if ($x['centac_or_josaa'] === 'J') {
            $x['centac_or_josaa'] = 'JOSAA';
        }

        if ($x['entry_mode'] === 'R') {
            $x['entry_mode'] = 'Regular';
        } else if ($x['entry_mode'] === 'L') {
            $x['entry_mode'] = 'Lateral';
        }

        if ($x['gender'] === 'F') {
            $x['gender'] = 'Female';
        } else if ($x['gender'] === 'M') {
            $x['gender'] = 'Male';
        }

        $dob = $x['dob'];
        $formatted_date = date("d-m-Y", strtotime($dob)); // format date in dd mm yyyy format

        echo "<div id='makepdf'>
        <table class='left-align-table'>
        <tr><th>Name</th><td>".$x['sname']."</td></tr>
        <tr><th>Application number</th><td>".$x['appn_num']."</td></tr>
        <tr><th>Admission mode</th><td>".$x['centac_or_josaa']."</td></tr>
        <tr><th>Father name</th><td>".$x['father_name']."</td></tr>
        <tr><th>Mother name</th><td>".$x['mother_name']."</td></tr>
        <tr><th>Date </th><td>".$formatted_date."</td></tr>
        <tr><th>Gender</th><td>".$x['gender']."</td></tr>
        <tr><th>Contact</th><td>".$x['phone']."</td></tr>
        <tr><th>Email ID</th><td>".$x['personal_email']."</td></tr>
        <tr><th>Address</td><td>".$x['address_line1']."<br>".$x['address_line2']."<br>".$x['address_state']."</td></tr>
        <tr><th>Nationality</th><td>".$x['nationality']."</td></tr>
        <tr><th>Community</th><td>".$x['community']."</td></tr>
        <tr><th>Type</th><td>".$x['entry_mode']."</td></tr>
        <tr><th>Programme</th><td>".$x['prgm_name']."</td></tr>
        <tr><th>Department</th><td>".$x['dept_name']."</td></tr>
        <tr><th>Year of Joining</th><td>".$x['yoj']."</td></tr>

        </table></div>";
    }
?>

<button class="btnn">Download</button>
<script>
    console.log('print pdf');
    var button = document.getElementById("btnn");
    var makepdf = document.getElementById("makepdf");

    button.addEventListener("click", function () {
        console.log("download btn clicked");
        html2pdf().from(makepdf).save();
    });
</script> 

<button class="small_btn" onclick="goback()">Back</button>

<script>
    function goback() {
        window.location.href = "../student.php";
    }
</script>

</body>
</html>