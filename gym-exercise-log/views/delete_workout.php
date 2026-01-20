<?php
include "../config/database.php";

// Validate ID
if (!isset($_GET['id'])) {
    header("Location: workouts.php");
    exit();
}

$id = intval($_GET['id']);

// First, delete all exercises associated with this workout
$delete_exercises = "DELETE FROM exercise_logs WHERE workout_id = ?";
$stmt = $conn->prepare($delete_exercises);
$stmt->bind_param("i", $id);
$stmt->execute();

// Then delete the workout
$delete_workout = "DELETE FROM workouts WHERE id = ?";
$stmt = $conn->prepare($delete_workout);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

// Redirect back to workouts page
header("Location: workouts.php");
exit();
?>