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
    <form action="admin_generate_regno_2.php" method="post" class = "get_session_form">  
        <!-- yoj as input -->
        <div class="input_yoj">
            <div class="label_yoj">
                <label for="yoj">Enter Year of Joining</label>
            </div>

            <input type="number" name="yoj" id="yoj">
        </div>

        <div class="label_prgm">
            <label for="prgm_id">Program:</label>
        </div>
        <!-- fetching data from db -->
        <?php
            // prepare and execute the query to fetch program names
            $stmt = $conn->prepare("SELECT prgm_id, prgm_name, dept_id FROM u_prgm");
            $stmt->execute();

            // fetch the results into an array
            $prgms_offered = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <select name="prgm_id" id="prgm_id">
            <option value="" selected="selected">Select programme</option>
            <?php 
                foreach ($prgms_offered as $result) {
                    echo "<option value='$result[prgm_id]'>".$result['dept_id']." - ".$result['prgm_name'] . "</option><br>";
                }
            ?>
        </select>
        
        <input type="submit" value="Proceed" name="submit_session" class = "submit_session">
    </form>
</body>
</html>