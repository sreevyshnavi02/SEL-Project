<?php
include '../header.php';
// Check if a minimum of 10 students opt for a program as the first choice
    $opt_count_query = "SELECT COUNT(REGNO) AS opt_count, OPT1_PRGM_ID 
                        FROM u_hm_preregistration 
                        WHERE OPT1_PRGM_ID IS NOT NULL AND CGPA > 7.5 
                        GROUP BY OPT1_PRGM_ID 
                        HAVING opt_count >= 10;";
    $opt_count_result = $conn->query($opt_count_query);

    // Get the list of programs with at least 10 eligible students
    $eligible_programs = array();
    while ($row = $opt_count_result->fetch(PDO::FETCH_ASSOC)) {
    $eligible_programs[] = $row["OPT1_PRGM_ID"];
    }

    // Allot programs to eligible students
    $allotment_query = "INSERT INTO u_hm_allotment (regno, alloted_prgm, allotment_date) 
                        SELECT regno, opt1_prgm_id, CURRENT_DATE() 
                        FROM ( 
                        SELECT REGNO, OPT1_PRGM_ID, CGPA 
                        FROM u_hm_preregistration 
                        WHERE OPT1_PRGM_ID IN (" . implode(',', $eligible_programs) . ") AND CGPA > 7.5 
                        ORDER BY CGPA DESC 
                        LIMIT 40
                        ) AS eligible_students;";
    $conn->query($allotment_query);

    // Close the database connection

?>