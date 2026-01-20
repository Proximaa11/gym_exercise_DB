<?php
include "../config/database.php";

// Validate parameters
if (!isset($_GET['id']) || !isset($_GET['workout_id'])) {
    header("Location: workouts.php");
    exit();
}

$id = intval($_GET['id']);
$workout_id = intval($_GET['workout_id']);

// Delete exercise using prepared statement
$sql = "DELETE FROM exercise_logs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Redirect back to exercises page
header("Location:  exercises.php?workout_id=$workout_id");
exit();
?>