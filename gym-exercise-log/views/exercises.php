<?php
include "../config/database.php";

$workout_id = $_GET['workout_id'];

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = $workout_id";
$workout_result = $conn->query($workout_sql);
$workout = $workout_result->fetch_assoc();

// Get exercises for this workout
$sql = "SELECT * FROM exercise_logs WHERE workout_id = $workout_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercises - <?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
    <div class="page-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Exercises</h1>
            <p class="page-subtitle"><?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></p>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a class="btn btn-primary" href="add_exercise.php?workout_id=<?= $workout_id ?>">➕ Add Exercise</a>
            <a class="btn btn-view" href="workouts.php">⬅ Back to Workouts</a>
        </div>

        <!-- Exercises Table -->
        <?php if ($result->num_rows > 0): ?>
        <table class="workout-table">
            <thead>
                <tr>
                    <th>Exercise Name</th>
                    <th>Muscle Group</th>
                    <th>Sets</th>
                    <th>Reps</th>
                    <th>Weight (kg)</th>
                    <th>Notes</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['exercise_name']) ?></td>
                    <td><?= htmlspecialchars($row['muscle_group']) ?></td>
                    <td><?= $row['sets'] ?></td>
                    <td><?= $row['reps'] ?></td>
                    <td><?= $row['weight'] ?></td>
                    <td><?= htmlspecialchars($row['notes']) ?></td>
                    <td>
                        <a class="btn btn-primary" href="edit_exercise.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                        <a class="btn btn-delete" href="delete_exercise.php?id=<?= $row['id'] ?>&workout_id=<?= $workout_id ?>"
                           onclick="return confirm('Delete this exercise?')">❌ Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="empty-state">
            No exercises added yet. Click "Add Exercise" to start tracking!
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
