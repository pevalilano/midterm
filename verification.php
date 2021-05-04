<?php

session_start();

if (!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true) {
    header("location: index.php");
    exit;
}

require_once "config.php";

$code_err = "";

if (isset($_POST['login'])) {
    if (empty(trim($_POST["code"]))) {
        echo "<script>alert('PLEASE ENTER CODE');</script>";
    } else {

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        $id = $_SESSION["id"];

        $sql = "SELECT code FROM code WHERE user_id = '$id' AND NOW() >= created_at AND NOW() <= expiration ORDER BY id_code DESC limit 1";
        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            if ($row = $result->fetch_assoc()) {
                if ($row["code"] == $code) {
                    $_SESSION["loggedin"] = true;

                    // for activity log
                    $stmt1 = $link->prepare("INSERT INTO activity_log (activity, username) VALUES (?, ?)");
                    $stmt1->bind_param("ss", $activity, $username);
                    // // set parameters and execute
                    $activity = "Success Log in";
                    $username = $_SESSION['username'];

                    $stmt1->execute();
                    $stmt1->close();
                    
                    header('location: welcome.php');
                } else {
                    echo "<script>alert('WRONG CODE ERROR');</script>";
                }
            }
        } else {
            echo "<script>alert('EXPIRED CODE ERROR');</script>";
        }

        $link->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verification</title>

    <style type="text/css">
        body {
            background-image: url(bg1.jpg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        * {
            font-family: sans-serif;
            box-sizing: border-box;
        }

        form {
            width: 500px;
            border: 2px solid #ccc;
            padding: 30px;
            background: white;
            border-radius: 15px;

        }

        h2 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 40px;
        }

        input {
            font-size: 13px;
            display: block;
            background-color: #f6fcf7;
            border: 2px solid #ccc;
            padding: 10px;
            width: 95%;
            margin: 10px auto;
            border-radius: 5px;
        }

        label {
            color: #888;
            font-size: 18px;
            padding: 10px;
        }

        button {
            float: right;
            background: #599fc7;
            padding: 10px 15px;
            color: #fff;
            border-radius: 5px;
            margin-right: 10px;
            border: none;
            margin: 10px auto;
        }

        button:hover {
            opacity: .7;
        }

        .ca {
            font-size: 14px;
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            color: #444;
        }

        .ca:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <form role="form" method="post">
            <h2>Verification</h2>
            <div class="form-group">
                <label>Code</label>
                <input type="text" name="code" class="form-control">
            </div>
            <div class="form-group">
                <button type="submit" name="login" class="btn btn-primary">LOGIN</button><BR>
                <a class="ca" style=" color: black;" href="random.php" target="_blank">GET CODE</a>
            </div>
        </form>
    </div>
</body>

</html>