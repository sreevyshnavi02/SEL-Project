<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.js">
        </script>
</head>
<body>
    <?php include '../header.php'; 
    	$name = $_REQUEST['Name'];
		$application_no = $_REQUEST['appn_num'];
		$_SESSION['application_no'] = $application_no;
        $father_name = $_REQUEST['Father_name'];
        $mother_name = $_REQUEST['Mother_name'];
        $Contact = $_REQUEST['MobileNumber'];
        $email = $_REQUEST['EmailID'];
        $address_line1 = $_REQUEST['address_line1'];
        $address_line2 = $_REQUEST['address_line2'];
        $address_state = $_REQUEST['address_state'];
        $admission = $_REQUEST['Centac/Josaa'];
        $Gender = $_REQUEST['Gender'];
		$Programme = $_REQUEST['prgm'];
		$Nationality = $_REQUEST['Nationality'];
		$Other_Nation = $_REQUEST['Other_Nationality'];
		$Community = $_REQUEST['caste'];
		$date = $_REQUEST['dob'];

		$Year_Of_Joining = $_REQUEST['year'];
		$Type = $_REQUEST['type'];



		// if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
		// 	$image = $_FILES['image']['name'];
		// 	$target = "images/".basename($image);

		// 	// generate a new name for the file using the application number
		// 	$extension = pathinfo(basename($image), PATHINFO_EXTENSION);
		// 	$new_name = $application_no . '.' . $extension;

		// 	// set the target path for the uploaded file using the new name
		// 	$target = "images/" . $new_name;

		// } else {
		// 	// handle the error
		// 	echo "Error uploading file: " . $_FILES['image']['error'];
		// }

		// find the latest NEW* registration number in the u_student table
		$sql = "SELECT regno FROM u_student WHERE regno LIKE 'NEW%' ORDER BY regno DESC LIMIT 1";
		$stmt = $conn->prepare($sql);
		$stmt->execute();
		$latest_regno = $stmt->fetchColumn();

		// extract the numeric part of the latest regno
		$latest_num = intval(substr($latest_regno, 3));

		// generate the new registration number
		if ($latest_num >= 10) {
			$new_num = $latest_num + 1;
			$new_regno = "NEW" . $new_num;
		} else {
			$new_regno = "NEW0" . ($latest_num + 1);
		}


		
		$sql = "INSERT INTO u_student (regno, sname, appn_num, centac_or_josaa, father_name, mother_name, DOB, GENDER, phone, personal_email, address_line1, address_line2, address_state, nationality, community, entry_mode, prgm_id, yoj) VALUES (:regno, :name, :application_no, :admission, :father_name, :mother_name, :date, :Gender, :Contact, :email, :address_line1, :address_line2, :State, :Nationality, :Community, :Type, :Programme, :Year_Of_Joining)";
		$stmt = $conn->prepare($sql);

		$params = array(
			'regno' => $new_regno,
			':name' => $name,
			':application_no' => $application_no,
			':admission' => $admission,
			':father_name' => $father_name,
			':mother_name' => $mother_name,
			':date' => $date,
			':Gender' => $Gender,
			':Contact' => $Contact,
			':email' => $email,
			':address_line1' => $_POST['address_line1'],
			':address_line2' => $_POST['address_line2'],
			':State' => $address_state,
			':Nationality' => $Nationality,
			':Community' => $Community,
			':Type' => $Type,
			':Programme' => $Programme,
			':Year_Of_Joining' => $Year_Of_Joining,
		);

		// if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		// 	$msg = "Image uploaded successfully";
		// }else{
		// 	$msg = "Failed to upload image";
		// }

		// echo $msg;
		
		if ($stmt->execute($params)) {
			// Insert was successful
			if ($stmt->rowCount() == 1) {
				header('Location: enrolment_confirmation.php');		
			}
		} else {
			// Insert failed
			echo "Error: " . $stmt->errorInfo()[2];
		}

		?>

</body>
</html>

