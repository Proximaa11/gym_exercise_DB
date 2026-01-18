<?php
include "../config/database.php";

// Make sure an exercise ID is provided
if (!isset($_GET['id'])) {
    die("Exercise ID is missing.");
}

$id = $_GET['id'];

// Fetch exercise data
$sql = "SELECT * FROM exercise_logs WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Exercise not found.");
}

$exercise = $result->fetch_assoc();
$workout_id = $exercise['workout_id'];

// Handle form submission
if (isset($_POST['update'])) {
    $name = $_POST['exercise_name'];
    $muscle = $_POST['muscle_group'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $weight = $_POST['weight'];
    $notes = $_POST['notes'];

    $update_sql = "UPDATE exercise_logs SET
        exercise_name='$name',
        muscle_group='$muscle',
        sets=$sets,
        reps=$reps,
        weight=$weight,
        notes='$notes'
        WHERE id=$id";

    if ($conn->query($update_sql)) {
        // Redirect back to the exercises list for this workout
        header("Location: exercises.php?workout_id=$workout_id");
        exit;
    } else {
        echo "Error updating exercise: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exercise</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; color: #333; }
        h2 { color: #2c3e50; }
        input, textarea, select { width: 300px; padding: 5px; margin-bottom: 10px; }
        button { padding: 10px 15px; background-color: #3498db; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #2980b9; }
    </style>
</head>
<body>

<h2>Edit Exercise</h2>

<form method="POST">
    <label>Exercise Name:</label><br>
    <input type="text" name="exercise_name" value="<?= htmlspecialchars($exercise['exercise_name']) ?>" required><br>

    <label>Muscle Group:</label><br>
    <input type="text" name="muscle_group" value="<?= htmlspecialchars($exercise['muscle_group']) ?>" required><br>

    <label>Sets:</label><br>
    <input type="number" name="sets" value="<?= $exercise['sets'] ?>" required><br>

    <label>Reps:</label><br>
    <input type="number" name="reps" value="<?= $exercise['reps'] ?>" required><br>

    <label>Weight (kg):</label><br>
    <input type="number" step="0.5" name="weight" value="<?= $exercise['weight'] ?>" required><br>

    <label>Notes:</label><br>
    <textarea name="notes"><?= htmlspecialchars($exercise['notes']) ?></textarea><br>

    <button type="submit" name="update">Update Exercise</button>
</form>

<br>
<a href="exercises.php?workout_id=<?= $workout_id ?>">⬅ Back to Exercises</a>

</body>
</html>
