<?php
session_start();
include "config.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $pass = validate($_POST['password']);

    date_default_timezone_set('Asia/Manila');
    $currentDate = date('Y-m-d H:i:s');
    $currentDate_timestamp = strtotime($currentDate);

    if (empty($username)) {
        echo "<script>alert('ENTER USERNAME');</script>";
    } else if (empty($pass)) {
        echo "<script>alert('ENTER PASSWORD');</script>";
    } else {
        //HASHING PASSWORD
        $pass = md5($pass);
        $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$pass' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            $_SESSION["verify"] = true;

            // for activity log
            $stmt1 = $link->prepare("INSERT INTO activity_log (activity, username) VALUES (?, ?)");
            $stmt1->bind_param("ss", $activity, $username);
            // // set parameters and execute
            $activity = "Attempted Log in";

            $stmt1->execute();
            $stmt1->close();

            // Generating code
            $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
            $code = substr(str_shuffle($permitted_chars), 0, 6);

            date_default_timezone_set('Asia/Manila');

            $currentDate = date('Y-m-d H:i:s');
            $currentDate_timestamp = strtotime($currentDate);
            $endDate_months = strtotime("+5 minutes", $currentDate_timestamp);
            $packageEndDate = date('Y-m-d H:i:s', $endDate_months);

            $user_id = $_SESSION["id"];
            $sql = "INSERT INTO code (user_id, code, created_at, expiration) VALUES('$user_id', '$code', '$currentDate', '$packageEndDate')";

            if (mysqli_query($link, $sql)) {
                header("Location: verification.php");
                exit();
            }

            exit();
        } else {
            $errorr = mysqli_error($link);
            echo "<script>alert('$username');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>

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
            height: 350px;
        }

        h2 {
            font-size: 30px;
            text-align: center;

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
            /*margin: 10px auto;*/
        }

        button:hover {
            opacity: .7;
        }


        .ca {
            font-size: 14px;
            display: inline-block;
            padding: 5px;
            text-decoration: none;
            color: #444;

        }

        .caa {
            font-size: 14px;
            padding: 10px;
            text-decoration: none;
            color: #444;
            float: left;
        }

        .ca:hover {
            text-decoration: underline;
        }

        .caa:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="wrapper">
        <form action="" method="post">
            <div class="next">
                <h2>Login</h2>
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" placeholder="Username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary" value="Login">Log In </button>
                    <button type="button" class="btn" name="register" onclick="window.location.href='signup.php'">Sign Up</button>
                </div>
                <div>
                    <!--  <a href="signup.php" class="ca">Create an account</a> <br> -->
                    <a href="forgotpass.php" class="caa">Forgot Password</a>
                </div>
        </form>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>