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
    <table cellpadding = "10" class="stud_enrollment_table">
            <!--------------------- First Name ------------------------------------------>
            <tr>
            <td>Full Name (with Initials at back)</td>
            <td><input type="text" name="Name" maxlength="100"  />
            </td>
            </tr>

            <!------------------------ Application number --------------------------------------->
            <tr>
            <td>Application number</td>
            <td><input type="varchar" name="appn_num" maxlength="20" onkeyup="check_appn_num(this.value)"/>
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

            <select name="year" id="joining">
            <option value="-1">Year</option>
            <option value="2017">2017</option>
            <option value="2018">2018</option>
            <option value="2019">2019</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
            <option value="2023">2023</option>
            </select>
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
            <input type="text" name="MobileNumber" maxlength="10" placeholder="9870xxxxxx"/>
            </td>
            </tr>

            <!-------------------------- Email ID ------------------------------------->
            <tr>
            <td>Email ID</td>
            <td><input type="email" name="EmailID" maxlength="100" placeholder="name@gmail.com"/></td>
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
            <input type="radio" name="Nationality" value="Indian" />
            Indian
            <input type="radio" name="Nationality" value="Others" />
            Others
            </td>
            </tr>
            <!---------------------------- Nationality-Others ----------------------------------->
            <tr>
            <td><nbsp><nbsp>       If others specify</td>
            <td><input type="text" name="Other_Nationality" maxlength="50"/>
            </td>
            </tr>

            <!---------------------------- Community ----------------------------------->
            <tr>
            <td>Community</td>
            <td> 
            <select name="caste" id="caste">
            <option value = "obc"> Other Backward Caste
            </option> 
            <option value = "mbc"> Most Backword Caste
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
            <option value = "10"> Regular
            </option> 
            <option value = "20"> Lateral Entry
            </option>
            </select>  
            </td>
            </tr>


            <!---------------------------- Programme ----------------------------------->
            <tr>

            <tr>
            <td>Programme:</td>
            <td>
            <select name="subject" id="subject">
                <option value="" selected="selected">Select programme</option>
            </select></td></tr>
            <tr>
            <td>Department: </td>
            <td>
            <select name="topic" id="topic">
                <option value="" selected="selected">Select programme first</option>
            </select></td></tr>
            <tr>
            <td>Specialization: </td>
            <td><select name="chapter" id="chapter">
                <option value="" selected="selected">Select dept first</option>
            </select></td></tr>
            
            </tr>
            <!--------------------- Photo ------------------------------------------>
            <!-- <tr>
            <td>Passport size photo upload</td>
            <td><input type="file" name="image" id="fileToUpload" required> -->
            <!--------<input type="submit" value="Upload Image" name="submit">----->
            </td>
            </tr>


            <!----------------------- Submit and Reset ------------------------------->
            <tr>
            <td colspan="2" align="center">
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