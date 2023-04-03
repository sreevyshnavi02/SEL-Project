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
    ?>
	<h1>Honor/Minor Pre-registration</h1>
	<form method="POST" action="save_options.php">
    <?php
        $fetch_stud_details_sql = "select sname, curr_sem, credits_earned from u_student where regno = :regno";
        $fetch_stud_details = $conn -> prepare($fetch_stud_details_sql);
        $fetch_stud_details -> bindParam(':regno', $_SESSION['regno']);
        $fetch_stud_details -> execute();
        $n = $fetch_stud_details -> rowCount();

        $fetched_stud_data = $fetch_stud_details -> fetchAll(PDO::FETCH_ASSOC);

    ?>

        <div class="oec_option_div">
            <!-- display student details -->
            <?php 
            foreach($fetched_stud_data as $stud_data){ 
            ?>
            <div class="oec_options">
                <p>Name: <?php echo $stud_data['sname'] ?></p>
                <p>Semester: <?php echo $stud_data['curr_sem'] ?></p>
            <?php
            }?>


		<label for="cgpa">CGPA:</label>
		<input type="number" name="cgpa" id="cgpa" step="0.01" min="0" max="10" required>
        <br>
		<label for="preference1">Preference 1:</label>
		<select name="preference1" id="preference1" required>
			<option value="">Select a Program</option>
			<?php
				// Retrieve the list of courses from the database using PDO
                $hm_prgms_query = "SELECT * FROM u_prgm WHERE (LOWER(prgm_name) LIKE '%honors%' AND dept_id = :dept_id) OR (LOWER(prgm_name) LIKE '%minors%' AND dept_id != :dept_id) AND offered = 1";
				$hm_prgms_prepare = $conn->prepare($hm_prgms_query);
                $hm_prgms_prepare -> bindParam(':dept_id', $_SESSION['dept_id']);

                $hm_prgms_prepare -> execute();

                $hm_prgms = $hm_prgms_prepare -> fetchAll(PDO::FETCH_ASSOC);
                echo "<script>console.log('fetched  prgms')</script>";
                echo "<script>console.log('".count($hm_prgms)."')</script>";

                echo count($hm_prgms);
				// Generate the options for the dropdown list
				foreach($hm_prgms as $row){
                    echo "<script>console.log('inside while')</script>";
                    echo "<script>console.log('".$row['PRGM_ID']."')</script>";
					echo '<option value="' . $row['PRGM_ID'] . '">' . $row['DEPT_ID'] .' - ' .$row['PRGM_NAME'] .'</option>';
				}

			?>
		</select>
        <br>
		<label for="preference2">Preference 2:</label>
		<select name="preference2" id="preference2" required>
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
        <br>
		<label for="preference3">Preference 3:</label>
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

			?>
		</select>
        <br>

		<input type="submit" value="Submit">
	</form>

</body>
</html>