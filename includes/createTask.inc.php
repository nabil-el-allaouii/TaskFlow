<?php
require_once "../Classes/DataHost";
require_once "../Classes/Task";

if ($_SERVER["REQUEST_METHOD"] = $_POST) {
    $TaskType = $_POST["taskType"];
    $TaskTitle = $_POST["taskTitle"];
    $TaskDescription = $_POST["taskDescription"];
    $UserName = $_POST["taskAssignee"];

    $NewTask = new task($TaskTitle, $TaskDescription, $TaskType, $UserName);
    $NewTask->CreateTask();
    header("location: ../TaskFlow/index.php");
    exit();
}
