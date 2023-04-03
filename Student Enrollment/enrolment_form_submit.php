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
        $address = $_REQUEST['Address'];
        $admission = $_REQUEST['Centac/Josaa'];
        $Gender = $_REQUEST['Gender'];
		$Programme = $_REQUEST['subject'];
		$Department = $_REQUEST['topic'];
		$Specialization = $_REQUEST['chapter'];
		$Nationality = $_REQUEST['Nationality'];
		$Other_Nation = $_REQUEST['Other_Nationality'];
		$Community = $_REQUEST['caste'];
		

		$date = $_REQUEST['dob'];

		echo("DOB = ". $date);
		$State = $_REQUEST['State'];
		$Other_State = $_REQUEST['Other_State'];
		$Year_Of_Joining = $_REQUEST['year'];
		$Type = $_REQUEST['type'];
		// $msg = "";
		// $image = $_FILES['image']['name'];
		// $target = "images/".basename($image);
		
		$sql = "INSERT INTO u_student(name,appn_num,centac_or_josaa,father_name,mother_name,DOB,GENDER,phone,EMAIL,address_line1, address_line2, address_state, nationality,community,type,programme,department,specialization,year_of_joining) VALUES ('$name',
			'$application_no','$admission','$father_name',
			'$mother_name','$date',
			'$Gender','$Contact','$email','$address',
			'$Nationality','$Other_Nation','$Community','$State',
			'$Other_State','$Type','$Programme','$Department','$Specialization','$Year_Of_Joining')";
		
		if(mysqli_query($conn, $sql)){
			echo "<h3>Data stored in a database successfully.</h3>";
			$sql = "SELECT name,application_no,admission,father_name,mother_name,date,gender,contact,email,address,nationality,other_nation,community,state,other_state,type,programme,department,specialization,year_of_joining FROM student where application_no='$application_no' ";	
			$query=mysqli_query($conn,$sql);
			foreach($query as $x)
			{
			echo "<div id='makepdf'>
			<table>
			<tr><td>Name</td><td>".$x['name']."</td></tr>
			<tr><td>Application number</td><td>".$x['application_no']."</td></tr>
			<tr><td>Admission number</td><td>".$x['admission']."</td></tr>
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
			<tr><td>Specialization</td><td>".$x['specialization']."</td></tr>
			<tr><td>Year of Joining</td><td>".$x['year_of_joining']."</td></tr>

			</table></div>";
			break;
			}
			
			//echo nl2br("\n$name\n $application_no\n$father_name\n$mother_name\n$email\n$address\n$Remark\n$Programme");
		} else{
			echo "ERROR: $sql. "
				. mysqli_error($conn);
		}
		// if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
		// 	$msg = "Image uploaded successfully";
		// }else{
		// 	$msg = "Failed to upload image";
		// }

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

