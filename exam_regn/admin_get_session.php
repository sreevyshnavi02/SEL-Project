<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PTU-COE</title>
</head>
<body>
    <?php include '../header.php' ?>
    <form action="admin_attendance.php" method="post" class = "get_session_form">  
        <!-- Session as input -->
        <div class="input_session">
            <div class="label_session">
                <label for="select_session">Session:</label>
            </div>
            <select name="session" id="select_session">
                <option value="">Please choose the session</option>
                <option value="18B">Nov - 2018</option>
                <option value="19A">May - 2019</option>
                <option value="19B">Nov - 2019</option>
                <option value="20A">May - 2020</option>
                <option value="20B">Nov - 2020</option>
                <option value="21A">May - 2021</option>
                <option value="20B">Nov - 2021</option>
                <option value="21A">May - 2022</option>
            </select>
        </div>
        
        <input type="submit" value="Proceed" name="submit_session" class = "submit_session">
    </form>
</body>
</html>