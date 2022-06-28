<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
// if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
//     header("location: login.php");
//     exit;
// }
require_once "pdo.php";

if (isset($_POST['CRL_Definition']) && isset($_POST['submit'])) {
    $sql = "UPDATE complexityrisklevel
    SET CRL_Definition = :CRL_Definition
                WHERE CRL_ID = :CRL_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':CRL_Definition' => $_POST['CRL_Definition'],
        ':CRL_ID' => $_GET['CRL_ID']
    ));
    $_SESSION['success'] = 'Definition updated';
    header('Location: Admin_Menu.php');
    return;
}

$stmt = $pdo->prepare("SELECT * FROM complexityrisklevel where CRL_ID = :xyz");
$stmt->execute(array(":xyz" => $_GET['CRL_ID']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for CRL_ID';
    header('Location: Admin_Menu.php');
    return;
}
$CRL_ID = htmlentities($row['CRL_ID']);
$CRL_Name = htmlentities($row['CRL_Name']);
$CRL_Definition = htmlentities($row['CRL_Definition']);
$Score = score($CRL_ID, $row);

function score($CRL_ID, $row)
{
    if ($CRL_ID == 1) {
        return "less than " . htmlentities($row['CRL_MaxScore']);
    } else if ($CRL_ID == 2) {
        return htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
    } else if ($CRL_ID == 3) {
        $Score = htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
    } else {
        $Score = htmlentities($row['CRL_MinScore']) . " and over";
    }
}

?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <title>Update CRL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <style>
        #CRL {
            background-image: url(bg.jpeg);
            height: 100%;
        }

        body {
            background-image: linear-gradient(45deg, #49a09d, #5f2c82);
            height: 100%;
        }

        .card {
            background-color: rgb(30, 34, 48, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            text-align: center;
            width: 600px;
        }

        .card-title {
            margin-top: 0;
            margin-bottom: .5rem;
            font-size: 1.2rem;
            color: rgb(242, 246, 241);
        }

        .card-textarea {
            background-color: rgb(66, 85, 91, 0.5);
            border-radius: 10px;
            color: rgb(242, 246, 241);
        }

        .card-button {
            background-color: rgb(66, 85, 91, 0.5);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: rgb(242, 246, 241);
            width: 90px;
        }

        .card-button a {
            color: rgb(242, 246, 241);
        }

        .card-button a:hover {
            text-decoration: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <nav class="navbar fixed-top navbar-expand-md">
        <a class="navbar-brand" href="Admin_Menu.php">Admin</a>

        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
            <span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="main-navigation">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="Admin_Menu.php#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="Admin_Menu.php#UpdateCRL">Complexity and Risk Level</a>
                </li>

                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Question
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a class="nav-link" href="Admin_Menu.php#Section1">Section 1</a>
                            <a class="nav-link" href="Admin_Menu.php#Section2">Section 2</a>
                            <a class="nav-link" href="Admin_Menu.php#Section3">Section 3</a>
                            <a class="nav-link" href="Admin_Menu.php#Section4">Section 4</a>
                            <a class="nav-link" href="Admin_Menu.php#Section5">Section 5</a>
                            <a class="nav-link" href="Admin_Menu.php#Section6">Section 6</a>
                            <a class="nav-link" href="Admin_Menu.php#Section7">Section 7</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="page-header header container-fluid pt-5" id="CRL">
    <div>
            <div class="container-fluid">
                <div class="card container mt-5 pb-5">
                <form method="POST" class="form">
                        <form method="POST" class="form">
                        <h1 class="card-title mt-5">Update Complexity and Risk Level Definition</h1>
                        <h3 class="card-title">Complexity and Risk Level: <?= $CRL_ID . '. ' . $CRL_Name ?></h3>
                        <h3 class="card-title">Definition:</h3>
                        <textarea class="card-textarea" name="CRL_Definition" rows="7" cols="70"><?= $CRL_Definition ?></textarea>
                        <h3 class="card-title">Score: <?= $Score ?></h3>
                        <input type="hidden" name="CRL_ID" value="<?= $$CRL_ID ?>">
                        <input class="card-button" name="submit" type="submit" value="Update" />
                        <button class="card-button"><a href="Admin_Menu.php">Cancel</a></button>
                    </form>
                </div>
            </div>
        </div>
        </div>
        </div>
    </header>
</body>

</html>
