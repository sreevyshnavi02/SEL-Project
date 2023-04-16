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
    <form action="admin_email_allot.php" method="post" class = "get_session_form">  
        <!-- yoj as input -->
        <div class="input_yoj">
            <div class="label_yoj">
                <label for="yoj">Enter Year of Joining</label>
            </div>

            <input type="number" name="yoj" id="yoj">
        </div>
        
        <input type="submit" value="Proceed" name="submit_session" class = "submit_session">
    </form>
</body>
</html>