<?php
include '../header.php';
// Get the current year for the first two digits of the register number
$currentYear = date("y");

// Department code for newly admitted students
$deptCode = "01";

// Regular entry code is 1, lateral entry code is 2
$entryCode = ($u_student["entry_mode"] == "regular") ? "1" : "2";

// Query to get the last used roll number for the department and entry mode
$sql = "SELECT MAX(SUBSTRING(REGNO, 7)) as last_roll_num FROM u_student WHERE SUBSTRING(REGNO, 1, 4) = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$currentYear.$deptCode.$entryCode]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$lastRollNum = $row["last_roll_num"];

// Increment the last roll number by 1 to generate the new roll number
$newRollNum = sprintf('%03d', ($lastRollNum + 1));

// Generate the register number by combining the year, department code, entry code, and roll number
$registerNumber = $currentYear . $deptCode . $entryCode . "00" . $newRollNum;

// Generate the email ID based on the register number
$emailID = $registerNumber . "@institution.edu";

// Update the u_student table with the generated register number and institution email ID
$updateSql = "UPDATE u_student SET REGNO = ?, EMAIL = ? WHERE email = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->execute([$registerNumber, $emailID, $u_student["EMAIL"]]);

// Print the generated register number and email ID
echo "Generated Register Number: $registerNumber<br>";
echo "Generated Email ID: $emailID";
?>
