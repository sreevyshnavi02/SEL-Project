<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php 
        include 'header.php';
        $year =  $_POST['session_year'];
        $formatted_year = $year[strlen($year) - 2].$year[strlen($year) - 1];
        $_SESSION['chosen_session'] = $formatted_year.$_POST['session_month'];

        $session = $_SESSION['chosen_session'];

        $check_regn_track = $conn->prepare("SELECT * FROM u_registration_track WHERE session = :session");
        $check_regn_track->execute(['session' => $_SESSION['chosen_session']]);
        
        if($check_regn_track -> rowCount() == 0){
            //insert rows for each regn type for the session
            
            // oec
            $sql = "INSERT INTO u_registration_track (registration_type, session) VALUES ('OEC', :session)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['session' => $_SESSION['chosen_session']]);            
            
            // hm
            $sql = "INSERT INTO u_registration_track (registration_type, session) VALUES ('HM', :session)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['session' => $_SESSION['chosen_session']]);            
            
            // course
            $sql = "INSERT INTO u_registration_track (registration_type, session) VALUES ('COURSE', :session)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['session' => $_SESSION['chosen_session']]);            
            
            // exam
            $sql = "INSERT INTO u_registration_track (registration_type, session) VALUES ('EXAM', :session)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['session' => $_SESSION['chosen_session']]);            
        }

        $check_regn_track = $conn->prepare("SELECT * FROM u_registration_track WHERE session = :session");
        $check_regn_track->execute(['session' => $_SESSION['chosen_session']]);
        
        $results = $check_regn_track->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table class='manage_regns_table'>";
        
        foreach($results as $row){
            echo "<tr>";
            if ($row) {
                $type = $row['registration_type'];
                echo "<td>$type REGISTRATION</td>";
                if ($row['start_date'] == NULL || $row['end_date'] != NULL) {
                    // Registration is enabled, show disable button
                    echo '<td><button class = "small_btn" id = "'.$type.'-button" onclick="toggleRegistration(\''.$type.'\', \'enable\')">Enable '.$type.' registration</button></td>';
                } else if($row['end_date'] == NULL){
                    // Registration is disabled, show enable button
                    echo '<td><button class = "small_btn" id = "'.$type.'-button" onclick="toggleRegistration(\''.$type.'\', \'disable\')">Disable '.$type.' registration</button></td>';
                }
            } else {
                // Registration tracking not found, show error message
                echo 'Error: Registration tracking not found for '.$type.' and session '.$_SESSION['chosen_session'];
            }
            echo "</tr>";
        }
        echo "</table>"
            
            ?>



    <script>
        function toggleRegistration(type, status) {
            var xhttp = new XMLHttpRequest();
            console.log("function called with " + type);
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    console.log("over here" + this.responseText);

                    if (status == "enable") {
                        const btnn = document.getElementById(type + "-button");
                        btnn.innerHTML = "Disable " + type + " Registration";
                        btnn.onclick() = function{
                            toggleRegistration(\''.$type.'\', \'disable\');
                        }
                    } else {
                        const btnn = document.getElementById(type + "-button");
                        btnn.innerHTML = "Enable " + type + " Registration";
                        btnn.onclick() = function{
                            toggleRegistration(\''.$type.'\', \'enable\');
                        }
                    }
                }
            };
            xhttp.open("POST", "toggle_registration.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("type=" + type + "&status=" + status);
        }
    </script>

    <button class="small_btn" onclick="goback()">Back</button>

    <script>
        function goback() {
            window.location.href = "../student.php";
        }
    </script>
</body>
</html>