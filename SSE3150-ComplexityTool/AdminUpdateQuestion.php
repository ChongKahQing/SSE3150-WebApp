<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
// if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
//     header("location: login.php");
//     exit;
// }
require_once "pdo.php";

$stmt = $pdo->prepare("SELECT q.Ques_ID AS qid, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2,
q.Ques_Description AS ques, q.Clarifications AS cla,
r.Rating1 AS rat1, r.Rating2 AS rat2, r.Rating3 AS rat3, r.Rating4 AS rat4, r.Rating5 AS rat5,
q.Section_ID AS sid, s.Section_Name AS sec
FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
JOIN rating r ON q.Rating_ID = r.Rating_ID
JOIN section s ON q.Section_ID = s.Section_ID
WHERE q.Ques_ID = :xyz;");
$stmt->execute(array(":xyz" => $_GET['Ques_ID']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row === false) {
    $_SESSION['error'] = 'Bad value for Ques_ID';
    header('Location: Admin_Menu.php');
    return;
}
$KnowledgeArea1 = htmlentities($row['kan1']);
$KnowledgeArea2 = htmlentities($row['kan2']);
if ($KnowledgeArea2 != null) {
    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
} else {
    $KnowledgeArea = $KnowledgeArea1;
}
$Question = htmlentities($row['ques']);
$Clarifications = htmlentities($row['cla']);
$Rating1 = htmlentities($row['rat1']);
$Rating2 = htmlentities($row['rat2']);
$Rating3 = htmlentities($row['rat3']);
$Rating4 = htmlentities($row['rat4']);
$Rating5 = htmlentities($row['rat5']);
$Sec = htmlentities($row['sec']);
$Ques_ID = htmlentities($row['qid']);
$Section_ID = htmlentities($row['sid']);


if (isset($_POST['Question']) && isset($_POST['submit'])  && isset($_POST['rating1'])) {
    $sql = "UPDATE question
    SET Ques_Description = :Question
    WHERE Ques_ID = :Ques_ID";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':Question' => $_POST['Question'],
        ':Ques_ID' => $_GET['Ques_ID']
    ));

    $sql2 = "UPDATE rating
    SET Rating1 = :rating1,
    Rating2 = :rating2,
    Rating3 = :rating3,
    Rating4 = :rating4,
    Rating5 = :rating5
    WHERE Rating_ID = :Ques_ID";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute(array(
        ':rating1' => $_POST['rating1'],
        ':rating2' => $_POST['rating2'],
        ':rating3' => $_POST['rating3'],
        ':rating4' => $_POST['rating4'],
        ':rating5' => $_POST['rating5'],
        ':Ques_ID' => $_GET['Ques_ID']
    ));

    $_SESSION['success'] = 'Definition updated';
    header('Location: Admin_Menu.php#Section' . $Section_ID);
    return;
}
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <title>Update Question</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="menu.css">
    <style>
        .header {
            background-image: url(bg.jpeg);
            background-size: auto;
            background-attachment: fixed;
        }

        body {
            background: linear-gradient(45deg, #49a09d, #5f2c82);
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
            color: rgb(242, 246, 241);
        }

        .card-textarea,
        .card-text {
            background-color: rgb(66, 85, 91, 0.5);
            border-radius: 10px;
            color: rgb(242, 246, 241);
        }

        .card-text {
            text-align: center;
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

        .clari {
            margin-top: 0;
            margin-bottom: .5rem;
            font-size: 1.2rem;
            color: rgb(242, 246, 241);
            text-align: left;
        }

        .title {
            margin: 2rem;
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

    <header class="page-header header container-fluid pt-5" id="Ques">
        <div>
            <div class="container-fluid">
                <div class="card container mt-5 pb-5">
                    <form method="POST" class="form">
                        <h1 class="card-title">Update Question</h1>
                        <h3 class="card-title">Section <?= $Section_ID . '. ' . $Sec ?></h3>
                        <h3 class="card-title">Knowledge Area: <?= $KnowledgeArea ?></h3><br>
                        <h3 class="card-title">Question:</h3>
                        <textarea class="card-textarea" name="Question" rows="3" cols="70"><?= $Question ?></textarea><br>
                        <h3 class="card-title"><br>Clarifications: </h3>
                        <p class="clari"><?php echo nl2br($Clarifications); ?></p><br>
                        <h3 class="card-title">Rating 1:</h3>
                        <textarea class="card-text" name="rating1" rows="3" cols="70"><?= $Rating1 ?></textarea>
                        <h3 class="card-title">Rating 2:</h3>
                        <textarea class="card-text" name="rating2" rows="3" cols="70"><?= $Rating2 ?></textarea>
                        <h3 class="card-title">Rating 3:</h3>
                        <textarea class="card-text" name="rating3" rows="3" cols="70"><?= $Rating3 ?></textarea>
                        <h3 class="card-title">Rating 4:</h3>
                        <textarea class="card-text" name="rating4" rows="3" cols="70"><?= $Rating4 ?></textarea>
                        <h3 class="card-title">Rating 5:</h3>
                        <textarea class="card-text" name="rating5" rows="3" cols="70"><?= $Rating5 ?></textarea>
                        <input type="hidden" name="Ques_ID" value="<?= $Ques_ID ?>">
                        <br>
                        <br>
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
