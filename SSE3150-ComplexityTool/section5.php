<?php
require_once "pdo.php";
session_start();

if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red; margin-top:30px;">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
    }
    

//check all question got answer
$stmt = $pdo->query("SELECT count(*) as total
FROM question
WHERE  section_id= 5");

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $totalQues = $row['total'];
}
$POSTtocheck = array();
for ($i = 1; $i <= $totalQues; $i++) {
    array_push($POSTtocheck, 'rate' . $i);
}
$checkButton = true;
foreach ($POSTtocheck as $key) {
    if (isset($_POST[$key])) {
        $checkButton = true;
    }
    else {
        $checkButton = false;
        break;
    }
}

//if all button is checked
if ($checkButton) {
   $_SESSION['section5'] = calcScore($totalQues);
header('location: section6.php');
exit();
}else{
    $_SESSION['error'] = "Please answer all the questions!";
}
?>

<html >
 <head>
 <meta charset="utf-8">
 <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">

 <link type="text/css" rel="stylesheet" href="sections.css">
 
        <?php
function showQuestion(PDO $pdo, $start, $end)
{
    $stmt = $pdo->query("SELECT q.ques_id, q.ques_description, r.rating_id, r.rating1, r.rating2, r.rating3, r.rating4, r.rating5 
            FROM question q
            JOIN rating r
            ON q.rating_id = r.rating_id
            WHERE q.ques_id BETWEEN $start and $end");

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $x = $GLOBALS['x'];
        echo(nl2br(htmlentities($row['ques_id'])) . ". ");
        echo(nl2br(htmlentities($row['ques_description'])) . "<br>");
        for ($i = 1; $i <= 5; $i++) {
            if ($row['rating' . $i] != null) {
                echo('<label class="container">');
                echo(htmlentities($row['rating' . $i]));
                echo("<input type='radio' style='margin-right:5px;'name='rate$x' value='$i'/>");
                echo('<span class="checkmark"></span></label>');
            }
        }
        echo("<br>");
        $GLOBALS['x']++;
    }
}

function calcScore($totalQues)
{
    $total = 0;
    for ($x = 1; $x <= $totalQues; $x++) {
        $total += $_POST['rate' . $x];
    }
    return $total;
}


?>

    </head>
    <body>

        <h1>Business Risks</h1>

        <h2>Human resources, Communications</h2>
        <form method="post">
        <?php
$GLOBALS['x'] = 1;
showQuestion($pdo, 39, 43);
?>

        <input type="submit" class="btn btn-light btn-lg" name="dopost" value="Next"/>
        </form>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>

    </body>
</html>