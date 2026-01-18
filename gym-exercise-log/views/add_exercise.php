<?php
include "../config/database.php";

$workout_id = $_GET['workout_id'];

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = $workout_id";
$workout_result = $conn->query($workout_sql);
$workout = $workout_result->fetch_assoc();
?>

<h2>Add Exercise to <?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></h2>

<form method="POST">
    <label>Exercise Name:</label><br>
    <input type="text" name="exercise_name" required><br><br>

    <label>Muscle Group:</label><br>
    <input type="text" name="muscle_group" required><br><br>

    <label>Sets:</label><br>
    <input type="number" name="sets" required><br><br>

    <label>Reps:</label><br>
    <input type="number" name="reps" required><br><br>

    <label>Weight (kg):</label><br>
    <input type="number" step="0.5" name="weight" required><br><br>

    <label>Notes:</label><br>
    <textarea name="notes"></textarea><br><br>

    <button type="submit" name="save">Add Exercise</button>
</form>

<?php
if (isset($_POST['save'])) {
    $name = $_POST['exercise_name'];
    $muscle = $_POST['muscle_group'];
    $sets = $_POST['sets'];
    $reps = $_POST['reps'];
    $weight = $_POST['weight'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO exercise_logs 
        (workout_id, exercise_name, muscle_group, sets, reps, weight, notes)
        VALUES
        ($workout_id, '$name', '$muscle', $sets, $reps, $weight, '$notes')";

    if ($conn->query($sql)) {
        header("Location: exercises.php?workout_id=$workout_id");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
