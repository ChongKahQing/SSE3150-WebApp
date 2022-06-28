<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["login"]) || $_SESSION["login"] !== true){
 header("location: login.php");
exit;
}


?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">

<head>
    <title>Menu</title>
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

        table tr td:last-child {
            width: 120px;
        }

        table {
            padding: 15px;
            color: rgb(242, 246, 241);
            border-radius: 20px;
            border: 0.5px solid rgba(255, 255, 255, 0.18);
            width: max-content;
        }

        table th,
        td {
            padding: 5px 5px 5px 5px;
            color: rgb(242, 246, 241);
        }

        table th {
            text-align: center;
        }

        table td {
            text-align: left;
            vertical-align: top;
        }

        .ratingtable {
            text-align: center;
        }

        .ka {
            text-align: center;
        }

        .ques,
        .clari,
        .rate {
            text-align: left;
        }

        .edit {
            text-align: center;
        }

        .card {
            background-color: rgb(94, 108, 98, 0.5);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            text-align: center;
            width: max-content;
        }

        .card-title {
            margin-top: 0;
            margin-bottom: .5rem;
            margin-left: 300px;

            color: rgb(242, 246, 241);
            text-align: center;
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

        .fa-pencil {
            color: rgb(242, 246, 241);
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
                    <a class="nav-link" href="#home">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#UpdateCRL">Complexity and Risk Level</a>
                </li>

                <li>
                    <div class="dropdown">
                        <button class="dropbtn">Question
                            <i class="fa fa-caret-down"></i>
                        </button>
                        <div class="dropdown-content">
                            <a class="nav-link" href="#Section1">Section 1</a>
                            <a class="nav-link" href="#Section2">Section 2</a>
                            <a class="nav-link" href="#Section3">Section 3</a>
                            <a class="nav-link" href="#Section4">Section 4</a>
                            <a class="nav-link" href="#Section5">Section 5</a>
                            <a class="nav-link" href="#Section6">Section 6</a>
                            <a class="nav-link" href="#Section7">Section 7</a>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <header class="page-header header container-fluid" id="home">
        <div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12"></div>
                    <div class="mt-5 mb-3 clearfix">
                        <br>
                        <h1 class="card-title">Dear <b><?php echo htmlspecialchars($_SESSION["username"]);
                                                        ?></b>, welcome back to manage our site.</h1><br>
                        <?php
                        require_once "pdo.php";

                        if (isset($_SESSION['error'])) {
                            echo '<p style ="color:red">' . $_SESSION['error'] . "</p>\n";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<p style ="color:green">' . $_SESSION['success'] . "</p>\n";
                            unset($_SESSION['success']);
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <header class="page-header header container-fluid" id="UpdateCRL">
        <div>
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <h2 class="card-title">Complexity and Risk Level Definition</h2>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        if (isset($_SESSION['error'])) {
                            echo '<p style ="color:red">' . $_SESSION['error'] . "</p>\n";
                            unset($_SESSION['error']);
                        }
                        if (isset($_SESSION['success'])) {
                            echo '<p style ="color:green">' . $_SESSION['success'] . "</p>\n";
                            unset($_SESSION['success']);
                        }

                        // Attempt select query execution
                        $sql = "SELECT * FROM complexityrisklevel";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Complexity and Risk Level");
                            echo ("</th><th>");
                            echo ("Definition");
                            echo ("</th><th>");
                            echo ("Score");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $CRL_ID = htmlentities($row['CRL_ID']);
                                $CRL_Name = htmlentities($row['CRL_Name']);
                                $CRL_Definition = htmlentities($row['CRL_Definition']);
                                $Score = "undefined";
                                if ($CRL_ID == 1) {
                                    $Score =  "less than " . htmlentities($row['CRL_MaxScore']);
                                } else if ($CRL_ID == 2) {
                                    $Score = htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
                                } else if ($CRL_ID == 3) {
                                    $Score =  htmlentities($row['CRL_MinScore']) . " to " . htmlentities($row['CRL_MaxScore']);
                                } else {
                                    $Score = htmlentities($row['CRL_MinScore']) . " and over";
                                }

                                echo "<tr><td>";
                                echo ($CRL_ID . ". " . $CRL_Name);
                                echo ("</td><td>");
                                echo nl2br($CRL_Definition);
                                echo ('<a href="AdminUpdateCRL.php?CRL_ID=' . $row['CRL_ID'] . '" class="mr-3" title="Edit Definition" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td><td class='ratingtable'>");
                                echo ($Score);
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </header>

    <header class="page-header header container-fluid" id="Question">
        <br>
        <br>
        <div id="Section1">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 1";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 1: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 1
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo ("<tr><td  class='ka'>");
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section2">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 2";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 2: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 2
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section3">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 3";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 3: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 3
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section4">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 4";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 4: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 4
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section5">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 5";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 5: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 5
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section6">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 6";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 6: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 6
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <br>
        <div id="Section7">
            <div class="container-fluid">
                <div class="card container">
                    <div class="row mb-5">
                        <div class="col-md-12"></div>
                        <div class="mt-5 mb-3 clearfix">
                            <?php
                            require_once "pdo.php";
                            $sql = "SELECT Section_Name FROM section where Section_ID = 7";
                            $stmt = $pdo->query($sql);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                            if ($row === false) {
                                $_SESSION['error'] = 'Bad value for Section_ID';
                                header('Location: Admin_Menu.php');
                                return;
                            }
                            $Section_Name = htmlentities($row['Section_Name']);
                            ?>
                            <h2 class="card-title">Section 7: <?= $Section_Name ?></h1>
                        </div>
                        <?php
                        // Include pdo file
                        require_once "pdo.php";

                        // Attempt select query execution
                        $sql = "SELECT q.Ques_ID, ka1.KA_Name AS kan1, ka2.KA_Name AS kan2, q.Ques_Description AS ques, q.Clarifications AS cla, r.Rating1 AS rat1, IFNULL(r.Rating2, '') AS rat2, IFNULL(r.Rating3, '') AS rat3, IFNULL(r.Rating4, '') AS rat4, IFNULL(r.Rating5, '') AS rat5
                                    FROM question q JOIN knowledgearea ka1 ON q.KA_ID1 = ka1.KA_ID
                                    LEFT OUTER JOIN knowledgearea ka2 ON q.KA_ID2 = ka2.KA_ID
                                    JOIN rating r ON q.Rating_ID = r.Rating_ID
                                    WHERE q.Section_ID = 7
                                    ORDER BY q.Ques_ID;";
                        $stmt = $pdo->query($sql);
                        if ($result = $pdo->query($sql)) {
                            echo ('<table border="1">' . "\n");
                            echo ("<tr><th>");
                            echo ("Knowledge Area");
                            echo ("</th><th>");
                            echo ("Question");
                            echo ("</th><th>");
                            echo ("Clarifications");
                            echo ("</th><th>");
                            echo ("Rating");
                            echo ("</th><th>");
                            echo ("");
                            echo ("</th></tr>");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $KnowledgeArea1 = htmlentities($row['kan1']);
                                $KnowledgeArea2 = htmlentities($row['kan2']);
                                if ($KnowledgeArea2 != null) {
                                    $KnowledgeArea = $KnowledgeArea1 . ", " . $KnowledgeArea2;
                                } else {
                                    $KnowledgeArea = $KnowledgeArea1;
                                }
                                $Question = htmlentities($row['ques']);
                                $Clarifications = htmlentities($row['cla']);
                                $Rating = "1= " . htmlentities($row['rat1']);
                                $Rating2 = htmlentities($row['rat2']);
                                $Rating3 = htmlentities($row['rat3']);
                                $Rating4 = htmlentities($row['rat4']);
                                $Rating5 = htmlentities($row['rat5']);
                                if ($Rating2 != null) {
                                    $Rating = $Rating . "\n2= " . $Rating2;
                                }
                                if ($Rating3 != null) {
                                    $Rating = $Rating . "\n3= " . $Rating3;
                                }
                                if ($Rating4 != null) {
                                    $Rating = $Rating . "\n4= " . $Rating4;
                                }
                                if ($Rating5 != null) {
                                    $Rating = $Rating . "\n5= " . $Rating5;
                                }
                                echo "<tr><td  class='ka'>";
                                echo ($KnowledgeArea);
                                echo ("</td><td class='ques'>");
                                echo nl2br($row['Ques_ID'].". ".$Question);
                                echo ("</td><td class='clari'>");
                                echo nl2br($Clarifications);
                                echo ("</td><td class='rate'>");
                                echo nl2br($Rating);
                                echo ("</td><td class='edit'>");
                                echo ('<a href="AdminUpdateQuestion.php?Ques_ID=' . $row['Ques_ID'] . '" class="mr-3" title="Edit Question" data-toggle="tooltip">
                            <span class="fa fa-pencil"></span></a>');
                                echo ("</td></tr>");
                            }
                            echo ('</table>');
                        } else {
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
</body>

</html>
