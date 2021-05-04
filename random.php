<?php
session_start();
require_once "config.php";

if (!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true) {
    header("location: index.php");
    exit;
}

$id = $_SESSION['id'];
$authentication_code = 'EXPIRED';

$stmt = $link->prepare("SELECT code FROM code WHERE user_id = ? AND NOW() >= created_at AND NOW() <= expiration ORDER BY id_code DESC LIMIT 1");

if (
    $stmt &&
    $stmt->bind_param('i', $id) &&
    $stmt->execute() &&
    $stmt->store_result() &&
    $stmt->bind_result($code) &&
    $stmt->fetch()
) {
    $authentication_code = $code;
}

$stmt->close();
$link->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style type="text/css">
        body {
            background: #beafaa;
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


        h2 {
            text-align: center;
        }
    </style>

</head>

<body>
    <form>
        <h2>Pls. Copy your verification code. </h2>
        <input value="<?php echo $authentication_code; ?>"> </input>
    </form>
</body>

</html>