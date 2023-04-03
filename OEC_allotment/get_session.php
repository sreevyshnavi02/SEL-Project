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
    <form action="preregister.php" method="post" class = "get_session_form">  
        <!-- Session as input -->
        <div class="input_session">
            <div class="label_session">
                <label>Enter Session</label>
            </div>

            <div class="label_session_month">
                <label for="session_month">Month:</label>
            </div>
            <select name="session_month" id="session_month">
                <option value="A">May</option>
                <option value="B">November</option>
            </select>

            <div class="label_session_year">
                <label for="session_year">Year:</label>
            </div>
            <input type="number" name="session_year" id="session_year">
        </div>
        
        <input type="submit" value="Proceed" name="submit_session" class = "submit_session">
    </form>
</body>
</html>