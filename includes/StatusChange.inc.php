<?php 
require_once "../Classes/DataHost";
require_once "../Classes/Task";
if($_SERVER["REQUEST_METHOD"] = $_POST){
    $task_id = $_POST['task_id'];
    $task_status = $_POST['task_status'];
}

$NewMOdify = new Task("","","","");
$NewMOdify->ModifyStatus($task_status , $task_id);

header("location: ../html/index.php");
