<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php include '../header.php'; ?>
    <form action="enrolment_form_submit.php" method="post">
    <h1 class="main_heading"> STUDENT ENROLLMENT</h1>
    <table cellpadding = "10">
        <form action="insertion.php" method="post" enctype="multipart/form-data">
            <!--------------------- First Name ------------------------------------------>
            <tr>
            <td>Full Name (with Initials at back)</td>
            <td><input type="text" name="FirstName" maxlength="100"  />
            </td>
            </tr>

            <!------------------------ Application number --------------------------------------->
            <tr>
            <td>Application number</td>
            <td><input type="varchar" name="LastName" maxlength="20" />
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
            <td>Date of Birth(DOB)</td>
            <td>
            <select name="BirthDay" id="Birthday_Day">
            <option value="-1">Day:</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
            </select>
            <select name="BirthdayMonth" id="Birthday_Month">
            <option value="-1">Month:</option>
            <option value="January">Jan(1)</option>
            <option value="February">Feb(2)</option>
            <option value="March">Mar(3)</option>
            <option value="April">Apr(4)</option>
            <option value="May">May(5)</option>
            <option value="June">Jun(6)</option>
            <option value="July">Jul(7)</option>
            <option value="August">Aug(8)</option>
            <option value="September">Sep(9)</option>
            <option value="October">Oct(10)</option>
            <option value="November">Nov(11)</option>
            <option value="December">Dec(12)</option>
            </select>
            <select name="BirthdayYear" id="Birthday_Year">
            <option value="-1">Year:</option>
            <option value="2021">2021</option>
            <option value="2020">2020</option>
            <option value="2019">2019</option>
            <option value="2018">2018</option>
            <option value="2017">2017</option>
            <option value="2016">2016</option>
            <option value="2015">2015</option>
            <option value="2014">2014</option>
            <option value="2013">2013</option>
            <option value="2012">2012</option>
            <option value="2011">2011</option>
            <option value="2010">2010</option>
            <option value="2009">2009</option>
            <option value="2008">2008</option>
            <option value="2007">2007</option>
            <option value="2006">2006</option>
            <option value="2005">2005</option>
            <option value="2004">2004</option>
            <option value="2003">2003</option>
            <option value="2002">2002</option>
            <option value="2001">2001</option>
            <option value="2000">2000</option>
            <option value="1999">1999</option>
            <option value="1998">1998</option>
            <option value="1997">1997</option>
            <option value="1996">1996</option>
            <option value="1995">1995</option>
            <option value="1994">1994</option>
            <option value="1993">1993</option>
            <option value="1992">1992</option>
            <option value="1991">1991</option>
            <option value="1990">1990</option>
            </select>
            </td>
            </tr>

            <!---------------------- Year ------------------------------------->
            <tr>
            <td>Year</td>
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
            (10 Digits Allowed)
            </td>
            </tr>

            <!-------------------------- Email ID ------------------------------------->
            <tr>
            <td>Email ID</td>
            <td><input type="email" name="EmailID" maxlength="100" placeholder="harry28@gmail.com"/></td>
            </tr>


            <!------------------------- Address ---------------------------------->
            <tr>
            <td>Address line 1<br /></td>
            <td><input type="text" name="Addressline1" /></td>
            </tr>
            <tr>
            <td>Address line 2<br /></td>
            <td><input type="text" name="Addressline2" /></td>
            </tr> 
            <tr>
            <td>City<br /></td>
            <td><input type="text" name="city" /></td>
            </tr>
            <!---------------------- State ------------------------------------->
            <tr>
            <td>State</td>
            <td>
            <input type="radio" name="State" value="Puducherry" />
            Puducherry
            <input type="radio" name="State" value="Others" />
            Others
            </td>
            </tr>
            
            <!---------------------------- State-Others ----------------------------------->
            <tr>
            <td><nbsp><nbsp>If others specify</td>
            <td><input type="text" name="Other_State" maxlength="50"/>
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
            <script>

            var subjectObject = {
                "B.Tech": {
                "Computer Science and Engineering":[],
                "Electronics and Communication Engineering":[],
                "Information Technology":[],
                "Electricals and Electronics Engineering":[],
                "Electronics and Instrumentation Engineering":[],
                "Chemical Engineering":[],
                "Mechanical Engineering": ["Mechanical", "Mechtronics"],
                "Civil Engineering":[],
                
                },
                
            "M.Tech": {
                "Computer Science and Engineering": ["Data Science", "Information Security"],
                "Electronics and Electrical Engineering":[],
                "Information Technology":["Internet of Things"],
                "Electronics and Instrumentation Engineering":[],
                "Electronics and Communication Engineering": ["ECE", "WC"],
                "Mechanical Engineering": ["Energy Technology", "PDM"],  
                "Civil Engineering":[],	
            },
            "Ph.d Scholars": {
                "Computer Science and Engineering": [],
                "Electronics and Electrical Engineering":[],
                "Information Technology":[],
                "Electricals and Electronics Engineering":[],
                "Electronics and Communication Engineering": [],
                "Civil Engineering":[],	
            },
                "MCA": {
                "Computer Science and Engineering": [], 
            },

            }
            window.onload = function() {
            var subjectSel = document.getElementById("subject");
            var topicSel = document.getElementById("topic");
            var chapterSel = document.getElementById("chapter");
            for (var x in subjectObject) {
                subjectSel.options[subjectSel.options.length] = new Option(x, x);
            }
            subjectSel.onchange = function() {
                //empty Chapters- and Topics- dropdowns
                chapterSel.length = 1;
                topicSel.length = 1;
                //display correct values
                for (var y in subjectObject[this.value]) {
                topicSel.options[topicSel.options.length] = new Option(y, y);
                }
            }
            topicSel.onchange = function() {
                //empty Chapters dropdown
                chapterSel.length = 1;
                //display correct values
                var z = subjectObject[subjectSel.value][this.value];
                for (var i = 0; i < z.length; i++) {
                chapterSel.options[chapterSel.options.length] = new Option(z[i], z[i]);
                }
            }
            }
            </script>
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
            <tr>
            <td>Passport size photo upload</td>
            <td><input type="file" name="image" id="fileToUpload">
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