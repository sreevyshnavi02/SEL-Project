<?php
 include '../header.php';

// Fetch compulsory courses from u_prgm_comp_course table
$regno = $_SESSION['regno'];

$sql = "SELECT comp.COURSE_CODE, c.COURSE_NAME, c.CREDITS, f.FNAME 
from u_course c, u_prgm_comp_course comp, 
u_student s, u_fac_course fc, u_faculty f 
where comp.prgm_id = s.prgm_id and
comp.course_code = c.course_code and
s.regno = ?";
// -- fc.course_code = comp.course_code and 
// -- f.faculty_id = fc.faculty_id and

$stmt = $conn->prepare($sql);
$stmt->execute([$regno]);
$compulsory_courses = $stmt->fetchAll();

// $_SESSION['session'] = '23A';
// Fetch OEC course from u_oec_allotment table
// $session = $_SESSION['session']; // Replace with a variable if needed
// $sql = "SELECT crs.COURSE_CODE, crs.COURSE_NAME, crs.CREDITS, f.FNAME 
//         FROM u_oec_allotment o 
//         INNER JOIN u_course crs ON o.COURSE_CODE = crs.COURSE_CODE 
//         LEFT JOIN u_faculty f ON fc.FACULTY_ID = f.FACULTY_ID 
//         WHERE o.REGNO = ? AND o.SESSION = ?";
// $stmt = $conn->prepare($sql);
// $stmt->execute([$regno, $session]);
// $oec_course = $stmt->fetch();

// Create an HTML table for the courses
echo '<table>';
echo '<thead><tr><th>Course Code</th><th>Course Name</th><th>Credits</th><th>Faculty Name</th></tr></thead>';
echo '<tbody>';

// Add the compulsory courses to the table
foreach ($compulsory_courses as $row) {
    print_r('$row');
    echo '<tr>';
    echo '<td>' . $row['COURSE_CODE'] . '</td>';
    echo '<td>' . $row['COURSE_NAME'] . '</td>';
    echo '<td>' . $row['CREDITS'] . '</td>';
    echo '<td>' . $row['FNAME'] . '</td>';
    echo '</tr>';
}

// Add the OEC course to the table
// if ($oec_course) {
//     echo '<tr>';
//     echo '<td>' . $oec_course['COURSE_CODE'] . '</td>';
//     echo '<td>' . $oec_course['COURSE_NAME'] . '</td>';
//     echo '<td>' . $oec_course['CREDITS'] . '</td>';
//     echo '<td>' . $oec_course['FNAME'] . '</td>';
//     echo '</tr>';
// }

?>