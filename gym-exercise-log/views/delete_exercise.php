<?php
include "../config/database.php";

$id = $_GET['id'];
$workout_id = $_GET['workout_id'];

$sql = "DELETE FROM exercise_logs WHERE id=$id";
$conn->query($sql);

header("Location: exercises.php?workout_id=$workout_id");
?>
