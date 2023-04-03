<?php 

    $_SESSION['regno'] = $_POST['regno'];

    // to get the name of the student
    $namequery = "SELECT sname FROM u_student where regno = '$_POST[regno]'";
    $name = mysqli_query($conn, $namequery);
    $y = mysqli_fetch_assoc($name);

    // setting the session variable name - why? is it necessary?
    $_SESSION['name'] = $y['sname'];


    // to fetch the details of the prgm the studentt is enrolled in 
    $prgmquery = "SELECT prgm_name from u_prgm 
                    inner join u_student 
                    on u_student.prgm_id = u_prgm.prgm_id 
                    where regno = '$_POST[regno]'";

    $prgm = mysqli_query($conn, $prgmquery);
    $w = mysqli_fetch_assoc($prgm);

    // setting the session variable prgm
    $_SESSION['prgm'] = $w['prgm_name'];


    $deptquery = "SELECT dept_name from u_dept 
                    inner join u_prgm 
                    on u_dept.dept_id=u_prgm.dept_id 
                    inner join u_student 
                    on u_student.prgm_id=u_prgm.prgm_id 
                    where regno='$_POST[regno]' ";
    $dept = mysqli_query($conn, $deptquery);

    $z= mysqli_fetch_assoc($dept);
    $_SESSION['dept'] = $z['dept_name'];

    foreach($subject as $x)
    {
        if($x['course_type']=='TY'){
            $x['course_type'] = 'Theory';
        }
        if($x['course_type']=='LB'){
            $x['course_type'] = 'Laboratory';
        }
        if($x['course_type']=='MC'){
            $x['course_type'] = 'Mandatory Course';
        }
        if($x['course_type']=='TY'){
            $x['course_type'] = 'Theory';
        }
        $pattern = "/A/";
        $y=preg_match($pattern, $x['session']);
        $_SESSION['yield'] = $y;
        if($y==1){
            $_SESSION['yield'] = 'May';
        }
        else{
            $_SESSION['yield']= 'Nov';
        }
        $result = mb_substr($x['session'], 0, 2);
        $_SESSION['r'] = $result;
    }
    
    //query to get the consolidated attendance of the student
    $attendance_q = "SELECT consolidated_attendance 
    from u_exam_regn where regno='$_POST[regno]' 
    and session = '$_POST[session]'";


    $attendance_r = mysqli_query($conn, $attendance_q);
    $attendance = mysqli_fetch_assoc($attendance_r);
    $_SESSION['consolidated_attendance'] = $attendance['consolidated_attendance'];

    

    //query to bring in all the history of arrears for that student
    $arrear_q = "SELECT regno, course_code, session from u_external_marks
    where regno='$_POST[regno]' and grade in ('F','Z')";

    $arrear_courses = mysqli_query($conn, $arrear_q);

    $arrears_array = array();
    
    foreach($arrear_courses as $arrear)
    {
        // echo("<br>Inside foreach<br>");
        // print_r($arrear);

        //pushing all the arrear history into arrears_array 
        array_push(
            $arrears_array, 
            array($arrear['regno'],$arrear['course_code'], $arrear['session'])
        );
    }
    // echo("<br>arrears array = ");
    // print_r($arrears_array) ;

    foreach ($arrears_array as $i => $row) {
        // echo("<br>row = ");    
        // print_r($row);

        $a_query = "SELECT * from u_external_marks 
            where regno='$row[0]' 
            and grade not in ('F','Z') 
            and course_code='$row[1]' ";

        // echo("<br>");

        $a = mysqli_query($conn,$a_query);
        // echo("<br>Subsquently passed courses<br>");
        // print_r($a);
        $x=mysqli_num_rows($a);
        // echo "$x";
        if($x>0){
            // echo "indside if";
            unset($arrears_array[$i]);
            // $arrears_array = array_diff($arrears_array, array($row[$i]));
        }
    }

    // echo("<br> after unset..");
    // print_r($arrears_array) ;

    $_SESSION['current_backlogs'] = $arrears_array;

    // echo("<br>printing the session variable");
    // print_r($_SESSION['current_backlogs']);
    // foreach ($arrears_array as $i => $row) {
    //     $_SESSION['arrear_coursecode'] = $row[1];
    // }
    // $arrear_ccode = $arrears_array[];

    // $course_dets_q=" SELECT u_course_regn.course_code,u_course_regn.sem,course_name,course_type from u_course_regn
    //  inner join u_course on u_course_regn.course_code=u_course.course_code where regno='$_POST[regno]' and
    //   u_course.course_code='$_SESSION[arrears_array]'";
    // $course_dets = mysqli_query($conn, $course_dets_q);

?>