<?php
// Get the input from user
$yoj = $_POST['yoj'];
$prgm_id = $_POST['prgm_id'];

// Prepare the query
$stmt = $pdo->prepare("SELECT regno, sname, dob FROM u_student WHERE yoj = :yoj AND prgm_id = :prgm_id ORDER BY sname, dob");

// Bind parameters and execute the query
$stmt->bindParam(':yoj', $yoj);
$stmt->bindParam(':prgm_id', $prgm_id);
$stmt->execute();

// Fetch the results as an associative array
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Print the results as a table
echo "<table>";
echo "<tr><th>Reg No.</th><th>Name</th><th>DOB</th></tr>";
foreach ($results as $row) {
    echo "<tr><td>{$row['regno']}</td><td>{$row['sname']}</td><td>{$row['dob']}</td></tr>";
}
echo "</table>";

?>
