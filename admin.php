<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <?php include 'header.php'; ?>
        <div class="provision">
            <a href = "./enable_disable_regns_session.php"><button class = 'btnn'>Manage student registrations</button></a>
            <a href = "./Student Enrollment/admin_before_regno_gen.php"><button class = 'btnn'>Generate Register Numbers</button></a>
            <a href = "./Student Enrollment/admin_before_email_gen.php"><button class = 'btnn'>Generate Institution Email IDs</button></a>
            <!-- <a href = "./Student Enrollment/nominal_roll.php"><button class = 'btnn'>Generate Nominal Roll</button></a> -->
            <a href = "./OEC_allotment/admin_get_session.php"><button class = 'btnn'>Enable OEC Allotment</button></a>
            <a href = "./Honor_minor_allotment/admin_hm_allotment.php"><button class = 'btnn'>Enable Honor/Minor Allotment</button></a>
            <!-- <a href = #><button class = 'btnn'>Enable Course Registration</button></a> -->
            <a href = exam_regn/admin_get_session.php><button class = 'btnn'>Enable Exam Registration</button></a>
        </div>

        <button class="small_btn" onclick="goback()">Back</button>

        <script>
            function goback() {
                window.location.href = "index.php";
            }
        </script>
    </body>
</html>