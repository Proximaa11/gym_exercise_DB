<?php
include "../config/database.php";

// Get all workouts
$sql = "SELECT * FROM workouts ORDER BY workout_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workouts - Gym Exercise Log</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Use existing main stylesheet -->
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<div class="page-container">

    <header class="page-header">
        <h1 class="page-title">My Workouts</h1>
        <p class="page-subtitle">Track your progress with precision and style</p>
    </header>

    <div class="action-buttons">
        <a class="btn btn-primary" href="add_workout.php">➕ Add Workout</a>
        <a class="btn btn-view" href="../index.php">⬅ Back to Main Page</a>
    </div>

    <table class="workout-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Type</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['workout_date'] ?></td>
                <td><?= $row['workout_type'] ?></td>
                <td><?= $row['notes'] ?></td>
                <td>
                    <a class="btn btn-view" href="exercises.php?workout_id=<?= $row['id'] ?>">💪 Exercises</a>
                    <a class="btn btn-delete" href="delete_workout.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this workout?')">❌ Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

</div>
</body>
</html>
