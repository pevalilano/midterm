<?php
include_once 'config.php';

session_start();

//Logout log

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];
    mysqli_query($link, "INSERT INTO activity_log (activity,username) VALUES('Logged out','$username')");

    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();
    
    header('location: index.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Welcome</title>

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

        button {

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

        h1 {
            font-size: 30px;
            text-align: center;
            margin-bottom: 40px;
        }

        .ca {
            font-size: 14px;
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            color: #444;
            align-items: center;
        }

        .ca:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div class="page-header">
            <h1><b>Welcome.</h1>
        </div>
        <CENTER>
            <button type="submit" name="submit" id="submit" class="btn btn-danger">Logout</button>
        </CENTER>
    </form>
</body>

</html>