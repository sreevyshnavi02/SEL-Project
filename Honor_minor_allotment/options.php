<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <!-- Get three options for honor or minor courses -->
    
    <!-- drop down 1 - show all minors and honors offered by parent dept -->

    <!-- drop down 2 - show all minors and honors offered by parent dept 
    skipping the previously chosen option - must be disabled until the first option is chosen -->
    <!-- drop down 3 - skip the previously chosen options -
    must be disabled until the first 2 options are chosen -->
    <?php 
        include '../header.php';
        $regno = $_SESSION['regno'];
        $stud_details_query = $conn -> query ("
        select s.regno, s.curr_sem, s.entry_mode, c.cgpa, c.sem, p.dept_id
        from u_student s, u_gpa_cgpa c, u_prgm p
        where s.regno = '$regno' 
        and s.regno=c.regno 
        and s.curr_sem = c.sem 
        and s.prgm_id = p.prgm_id;");

        $stud_details = $stud_details_query -> fetch(PDO::FETCH_ASSOC);
        $stud_exist = $stud_details_query -> rowCount();
        if($stud_exist){

        $_SESSION['dept_id'] = $stud_details['dept_id'];
        $_SESSION['cgpa'] = $stud_details['cgpa'];

        $check_prereg = $conn -> query ("
        select * from u_hm_preregistration
        where regno = '$regno' ");

        $n = $check_prereg -> rowCount();

        //displaying the cgpa
        if($n > 0){
            echo "<h1 style='text-align: center; background-color: gray; padding: 1rem'>You have already given the options. </h1><br>";   
        ?>
            <button class="small_btn" onclick="goback()">Back</button>

            <script>
                function goback() {
                    window.location.href = "../student_login.php";
                }
            </script> 
        <?php
        }
        elseif(($stud_details['curr_sem'] == 3 && $stud_details['entry_mode'] == 'R' && $stud_details['cgpa'] > 7.5) ||
        ($stud_details['curr_sem'] == 4 && $stud_details['entry_mode'] == 'L' && $stud_details['cgpa'] > 7.5)){
            echo "<h1 style='text-align: center; background-color: gray; padding: 1rem'>Your CGPA: ".$stud_details['cgpa']."</h1><br>";
    ?>
	<h1 style="text-align: center">Honor/Minor Pre-registration</h1>
	<form method="POST" action="save_options.php">
    <?php
        $fetch_stud_details_sql = "select sname, curr_sem, credits_earned from u_student where regno = :regno";
        $fetch_stud_details = $conn -> prepare($fetch_stud_details_sql);
        $fetch_stud_details -> bindParam(':regno', $_SESSION['regno']);
        $fetch_stud_details -> execute();
        $n = $fetch_stud_details -> rowCount();

        $fetched_stud_data = $fetch_stud_details -> fetchAll(PDO::FETCH_ASSOC);

    ?>

            <!-- display student details -->
            <table class="left-align-table">
                <?php 
            foreach($fetched_stud_data as $stud_data){ 
                ?>
            <div class="hm_options">
                <tr>
                    <td>Name:</td> 
                    <td><?php echo $stud_data['sname'] ?></td>
                </tr>
                <tr>
                    <td>Semester: </td>
                    <td><?php echo $stud_data['curr_sem'] ?></td>
                </tr>
                <?php
            }?>

        <tr>
            <?php
				// Retrieve the list of courses from the database using PDO
                $dept_id = $_SESSION['dept_id'];
                $hm_prgms_query = "SELECT * FROM u_prgm WHERE (LOWER(prgm_name) LIKE '%honors%' AND dept_id = '$dept_id') OR (LOWER(prgm_name) LIKE '%minors%' AND dept_id != '$dept_id') AND offered = 1";
				$hm_prgms_prepare = $conn->prepare($hm_prgms_query);
                // $hm_prgms_prepare -> bindParam(':dept_id', $dept_id);
                
                $hm_prgms_prepare -> execute();
                
                $hm_prgms = $hm_prgms_prepare -> fetchAll(PDO::FETCH_ASSOC);
            ?>
            <td><label for="preference1">Preference 1:</label></td>
            <td><select name="preference1" id="preference1" required>
            <option value="">Select a Program</option>
			<?php
				// Generate the options for the dropdown list
				foreach($hm_prgms as $row){
                    echo "<script>console.log('inside while')</script>";
                    echo "<script>console.log('".$row['PRGM_ID']."')</script>";
					echo '<option value="' . $row['PRGM_ID'] . '">' . $row['DEPT_ID'] .' - ' .$row['PRGM_NAME'] .'</option>';
				}
                
                ?>
		</select>
        </td>
        </tr>

        <tr>

            <td><label for="preference2">Preference 2:</label></td>
            <td><select name="preference2" id="preference2" required>
                <option value="">Select a Program</option>
			<?php

                // Retrieve the list of courses from the database using PDO
                $courses_query = "SELECT * FROM u_prgm WHERE (LOWER(prgm_name) LIKE '%honors%' AND dept_id = '$_SESSION[dept_id]') OR (LOWER(prgm_name) LIKE '%minors%' AND dept_id != '$_SESSION[dept_id]') AND offered = 1";
                $courses_result = $conn->query($courses_query);

                // Generate the options for the dropdown list
                while ($row = $courses_result->fetch(PDO::FETCH_ASSOC)) {
					echo '<option value="' . $row['PRGM_ID'] . '">' . $row['DEPT_ID'] .' - ' .$row['PRGM_NAME'] .'</option>';
                }
                
                ?>
		</select>
        </td>
    </tr>
    <tr>
        <td><label for="preference3">Preference 3:</label></td>
		<td>
            <select name="preference3" id="preference3" required>
            <option value="">Select a Program</option>
			<?php

                // Retrieve the list of courses from the database using PDO
                $courses_query = "SELECT * FROM u_prgm WHERE (LOWER(prgm_name) LIKE '%honors%' AND dept_id = '$_SESSION[dept_id]') OR (LOWER(prgm_name) LIKE '%minors%' AND dept_id != '$_SESSION[dept_id]') AND offered = 1";
                $courses_result = $conn->query($courses_query);

                // Generate the options for the dropdown list
                while ($row = $courses_result->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['PRGM_ID'] . '">' . $row['DEPT_ID'] .' - ' .$row['PRGM_NAME'] .'</option>';
                }
            }

            ?>
            </select>
        </td>
    </tr>
        <br>
        
    </table>
		<input type="submit" value="Submit" class="small_btn">
	</form>

    <button class="small_btn" onclick="goback()">Back</button>

    <script>
        function goback() {
            window.location.href = "../admin.php";
        }
    </script>

    <?php
    }
    else{
        echo "<h1 style='text-align:center'>You aren't eligible for Honor/Minor Programmes!</h1>";

        //back navigation
        ?>
        <button class="small_btn" onclick="goback()">Back</button>

        <script>
            function goback() {
                window.location.href = "../admin.php";
            }
        </script>

    <?php
    }
    ?>
    
</body>
</html>