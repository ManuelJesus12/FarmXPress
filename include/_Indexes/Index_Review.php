<?php
if(!isset($c)) $c=PDOConnect($c);

if(isset($dirChangeVar) && $dirChangeVar==1) $dir="../"; else $dir="";
require_once $dir.'Models/Model_Review.php';
require_once $dir.'Controllers/Controller_Review.php';


// INITIALIZE MODEL AND CONTROLLER
$reviewModel = new ReviewModel($c);
$reviewController = new ReviewController($reviewModel);

if(isset($_GET['methodRev'])){
    $methods = explode('-', $_GET['methodRev']);
    // CONTROLLER FUNCTION HANDLING
    /*--------------------------------------------------------------------------*/
    if(in_array("insert", $methods))
        $message = $reviewController -> insertReview();
    if(in_array("update", $methods))
        $message = $reviewController -> updateReview();
    if(in_array("delete", $methods))
        $message = $reviewController -> deleteReview($_POST["id"]);
    /*--------------------------------------------------------------------------*/

    // INITIALIZE VIEW
}
?>