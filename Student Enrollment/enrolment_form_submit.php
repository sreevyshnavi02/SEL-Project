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

		echo("DOB = ". $date);
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
		
		
		
		$sql = "INSERT INTO u_student (sname, appn_num, centac_or_josaa, father_name, mother_name, DOB, GENDER, phone, EMAIL, address_line1, address_line2, address_state, nationality, community, entry_mode, prgm_id, yoj) VALUES (:name, :application_no, :admission, :father_name, :mother_name, :date, :Gender, :Contact, :email, :address_line1, :address_line2, :State, :Nationality, :Community, :Type, :Programme, :Year_Of_Joining)";
		$stmt = $conn->prepare($sql);

		$params = array(
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
				echo "Data stored in the database successfully.";
				$sql = "SELECT sname,appn_num,centac_or_josaa,father_name,mother_name,dob,gender,phone,email,address_line1, address_line2, address_state,nationality,community,entry_mode,prgm_id, yoj FROM u_student where appn_num='$application_no' ";	
				$query = $conn -> query($sql);
				$fetched_data = $query->fetchAll(PDO::FETCH_ASSOC);

				foreach($fetched_data as $x)
				{
					echo "<div id='makepdf'>
					<table>
					<tr><td>Name</td><td>".$x['sname']."</td></tr>
					<tr><td>Application number</td><td>".$x['appn_num']."</td></tr>
					<tr><td>Admission number</td><td>".$x['centac_or_josaa']."</td></tr>
					<tr><td>Father name</td><td>".$x['father_name']."</td></tr>
					<tr><td>Mother name</td><td>".$x['mother_name']."</td></tr>
					<tr><td>Date </td><td>".$x['date']."</td></tr>
					<tr><td>Gender</td><td>".$x['gender']."</td></tr>
					<tr><td>Contact</td><td>".$x['contact']."</td></tr>
					<tr><td>Email ID</td><td>".$x['email']."</td></tr>
					<tr><td>Address</td><td>".$x['address']."</td></tr>
					<tr><td>Nationality</td><td>".$x['nationality']."</td></tr>
					<tr><td>Other Nation</td><td>".$x['other_nation']."</td></tr>
					<tr><td>Community</td><td>".$x['community']."</td></tr>
					<tr><td>State</td><td>".$x['state']."</td></tr>
					<tr><td>Other State</td><td>".$x['other_state']."</td></tr>
					<tr><td>Type</td><td>".$x['type']."</td></tr>
					<tr><td>Programme</td><td>".$x['programme']."</td></tr>
					<tr><td>Department</td><td>".$x['department']."</td></tr>
					<tr><td>Year of Joining</td><td>".$x['year_of_joining']."</td></tr>

					</table></div>";
					break;
				}
			}
		} else {
			// Insert failed
			echo "Error: " . $stmt->errorInfo()[2];
		}


		?>

		<button id="btnn">Download</button>
            <script>
				console.log('print pdf');
                var button = document.getElementById("btnn");
                var makepdf = document.getElementById("makepdf");
        
                button.addEventListener("click", function () {
					console.log("download btn clicked");
                    html2pdf().from(makepdf).save();
                });
            </script> 

</body>
</html>

