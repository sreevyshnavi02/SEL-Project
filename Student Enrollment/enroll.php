<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <script>
        function check_appn_num(entered_appn_num){
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("txt").innerHTML = this.responseText;
            }
            };
            xmlhttp.open("GET", "check_appn_num.php?q=" + entered_appn_num, true);
            xmlhttp.send();
        }
    </script>


    <?php include '../header.php'; ?>
    <form action="enrolment_form_submit.php" method="post">
    <h1 class="main_heading"> STUDENT ENROLLMENT</h1>
    <table class="stud_enrollment_table">
            <!--------------------- First Name ------------------------------------------>
            <tr>
            <td>Full Name (with Initials at back)</td>
            <td><input type="text" name="Name" maxlength="100"  />
            </td>
            </tr>

            <!------------------------ Application number --------------------------------------->
            <tr>
            <td>Application number</td>
            <td><input type="text" name="appn_num" maxlength="20" onkeyup="check_appn_num(this.value)"/>
            <span id="txt"></span>
            </td>
            </tr>
            <!---------------------- Centac/Josaa ------------------------------------->
            <tr>
            <td>Centac/Josaa</td>
            <td>
            <input type="radio" name="Centac/Josaa" value="Centac" />
            Centac
            <input type="radio" name="Centac/Josaa" value="Josaa" />
            Josaa
            </td>
            </tr>
            <!--------------------- Father's Name ------------------------------------------>
            <tr>
            <td>Father's Name</td>
            <td><input type="text" name="Father_name" maxlength="50"  />

            </td>
            </tr>
            <!--------------------- Mother's Name ------------------------------------------>
            <tr>
            <td>Mother's Name</td>
            <td><input type="text" name="Mother_name" maxlength="50"  />

            </td>
            </tr>
            <!--------------------------Date Of Birth----------------------------------->
            <tr>
            <td>Date of Birth</td>
            <td><input type="date" name="dob" id="dob">
            </td>
            </tr>

            <!---------------------- Year ------------------------------------->
            <tr>
            <td>Year of Joining</td>
            <td>
            <input type="text" name="year" id="joining">
            </td>
            </tr>
            <!---------------------- Gender ------------------------------------->
            <tr>
            <td>Gender</td>
            <td>
            <input type="radio" name="Gender" value="Male" />
            Male
            <input type="radio" name="Gender" value="Female" />
            Female
            </td>
            </tr>
            <!-------------------------- Mobile Number ------------------------------------->
            <tr>
            <td>Mobile Number</td>
            <td>
            <input type="text" name="MobileNumber" maxlength="10" placeholder="Mobile Number"/>
            </td>
            </tr>

            <!-------------------------- Email ID ------------------------------------->
            <tr>
            <td>Email ID</td>
            <td><input type="email" name="EmailID" maxlength="100" placeholder="Your email ID"/></td>
            </tr>


            <!------------------------- Address ---------------------------------->
            <tr>
            <td>Address Line 1</td>
            <td>
                <input type="text" name="address_line1" />
            </td>
            </tr>
            <tr>
            <td>Address Line 2</td>
            <td>
                <input type="text" name="address_line2" />
            </td>
            </tr>
            <tr>
            <td>State</td>
            <td>
                <input type="text" name="address_state" />
            </td>
            </tr>


            <!---------------------- Nationality ------------------------------------->
            <tr>
            <td>Nationality</td>
            <td>
                <label>
                <input type="radio" name="Nationality" value="Indian" checked> Indian
                </label>
                <label>
                <input type="radio" name="Nationality" value="Others"> Others
                </label>
                <input type="text" name="Other_Nationality" maxlength="50" placeholder="Specify the Nationality" style="display: none;">
            </td>
            </tr>

            <script>
                document.querySelector('input[name="Nationality"][value="Others"]').addEventListener('change', function() {
                    var otherNationalityField = document.querySelector('input[name="Other_Nationality"]');
                    if (this.checked) {
                        otherNationalityField.style.display = 'block';
                    } else {
                        otherNationalityField.style.display = 'none';
                    }
                });
            </script>


            <!---------------------------- Community ----------------------------------->
            <tr>
            <td>Community</td>
            <td> 
            <select name="caste" id="caste">
            <option value = "obc"> Other Backward Caste
            </option> 
            <option value = "mbc"> Most Backward Caste
            </option>
            <option value = "bc"> Backward Caste
            </option>
            <option value = "oc"> Other Caste
            </option>
            <option value = "sc"> Scheduled Caste
            </option>
            <option value = "st"> Scheduled Tribes
            </option>
            </select>  
            </td>
            </tr>

            <!---------------------- Regular ------------------------------------->

            <tr>
            <td>Method Of Study</td>
            <td> 
            <select name="type" id="regular">
            <option value = "R"> Regular
            </option> 
            <option value = "L"> Lateral Entry
            </option>
            </select>  
            </td>
            </tr>


            <!---------------------------- Programme ----------------------------------->

            <!-- fetching data from db -->
            <?php
            // prepare and execute the query to fetch program names
            $stmt = $conn->prepare("SELECT prgm_id, prgm_name, dept_id FROM u_prgm");
            $stmt->execute();

            // fetch the results into an array
            $prgms_offered = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $stmt = $conn->prepare("SELECT dept_id, dept_name FROM u_dept");
            $stmt->execute();

            // fetch the results into an array
            $depts_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            

            <tr>
            <td>Programme:</td>
            <td>
                <select name="prgm" id="prgm">
                    <option value="" selected="selected">Select programme</option>
                    <?php 
                        foreach ($prgms_offered as $result) {
                            echo "<option value='$result[prgm_id]'>".$result['dept_id']." - ".$result['prgm_name'] . "</option><br>";
                        }
                    ?>
                </select>
            </td>
            
            </tr>
            
            <!--------------------- Photo ------------------------------------------>
            <!-- <tr>
            <td>Passport size photo upload</td>
            <td><input type="file" name="image" id="fileToUpload" required>
            </td>
            </tr> -->


            <!----------------------- Submit and Reset ------------------------------->
            <tr>
            <td colspan = '2'>
            <div class="buttons-flex">

                <input class="submit_option" type="reset" value="Reset">
                <input class="submit_option" type="submit" value="Submit">
            </div>
            </td>
            </tr>
        </table>
        </form>
</body>
</html>