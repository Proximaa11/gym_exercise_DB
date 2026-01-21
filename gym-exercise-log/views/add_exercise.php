<?php
include "../config/database.php";

$workout_id = $_GET['workout_id'];

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = $workout_id";
$workout_result = $conn->query($workout_sql);
$workout = $workout_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exercise - <?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Add Exercise</h1>
            <p class="page-subtitle"><?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></p>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label class="form-label">Exercise Name:</label>
                    <input class="form-input" type="text" name="exercise_name" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Muscle Group:</label>
                    <input class="form-input" type="text" name="muscle_group" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Sets:</label>
                    <input class="form-input" type="number" name="sets" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Reps:</label>
                    <input class="form-input" type="number" name="reps" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Weight (kg):</label>
                    <input class="form-input" type="number" step="0.5" name="weight" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Notes:</label>
                    <textarea class="form-textarea" name="notes"></textarea>
                </div>

                <button class="form-submit" type="submit" name="save">Add Exercise</button>
            </form>

            <div style="margin-top: 20px;">
                <a class="btn btn-view" href="exercises.php?workout_id=<?= $workout_id ?>">⬅ Back to Exercises</a>
            </div>
        </div>
    </div>
</body>
</html>

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
