<?php
require_once "pdo.php";
session_start();
$project_id = $_SESSION['project_id'];
//if not all questions answered
if ( isset($_SESSION['questionerror']) ) {
    echo '<p style="color:red; margin-top:30px;">'.$_SESSION['questionerror']."</p>\n";
    unset($_SESSION['questionerror']);
    }


//check all question got answer
$stmt = $pdo->query("SELECT count(*) as total
FROM question
WHERE  section_id= 1");

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
    $_SESSION['question2'] = $_POST['rate2']; //to see if section 3.3 needed

    //determine cost
    switch($_POST['rate1']){
        case 1: $cost = '$1-5 million'; break;
        case 2: $cost = '$5-10 million'; break;
        case 3: $cost = '$10-25 million'; break;
        case 4: $cost = '$25-100 million'; break;
        case 5: $cost = 'over 100 million'; break;
    }

    //determine duration
    switch($_POST['rate5']){
        case 1: $duration = 'under 12 months'; break;
        case 2: $duration = '12-24 months'; break;
        case 3: $duration = '24-36 months'; break;
        case 4: $duration = '36-48 months'; break;
        case 5: $duration = 'over 48 months'; break;
    }
    //update project table cost and duration
    $sql = "UPDATE project
    SET financial_funds = :cost,
    project_duration = :duration
    WHERE project_id = $project_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
    ':cost' => $cost,
    ':duration' => $duration
    ));

    if($_POST['rate1'] == 5 && $_POST['rate3'] == 5 && $_POST['rate11'] == 5){
        $_SESSION['section1'] = 90;
        header('location: section2.php');
        exit();
    }else{
        $_SESSION['section1'] = calcScore($totalQues);
        header('location: section2.php');
        exit();
    }

}else{
    $_SESSION['questionerror'] = "Please answer all the questions!";
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
        <h1>Project Characteristic </h1>



            <h2>Cost</h2>
            <form method="post">
        <?php
$GLOBALS['x'] = 1;
showQuestion($pdo, 1, 2);
?>


        <h2>Investment portfolio management</h2>
        <?php
showQuestion($pdo, 3,3);
?>

        <h2>Human Resources</h2>
        <?php
showQuestion($pdo, 4, 4);
?>

<h2>Time</h2>
        <?php
showQuestion($pdo, 5, 5);
?>

<h2>Scope</h2>
        <?php
showQuestion($pdo, 6, 6);
?>

<h2>Communications</h2>
        <?php
showQuestion($pdo, 7, 7);
?>

<h2>Project Integration Management</h2>
        <?php
showQuestion($pdo, 8, 8);
?>

<h2>Cost</h2>
        <?php
showQuestion($pdo, 9, 10);
?>

<h2>Time</h2>
        <?php
showQuestion($pdo, 11, 18);
?>




        <input type="submit" class="btn btn-light btn-lg" name="dopost" value="Next"/>
        </form>


        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    </body>
</html>
