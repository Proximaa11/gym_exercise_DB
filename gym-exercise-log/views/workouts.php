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
    <title>Workouts</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #f9f9f9; color: #333; }
        h2 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: center; }
        a { text-decoration: none; color: white; padding: 5px 10px; border-radius: 5px; }
        .add { background-color: #3498db; }
        .view { background-color: #2ecc71; }
        .delete { background-color: #e74c3c; }
        a:hover { opacity: 0.8; }
    </style>
</head>
<body>

<h2>My Workouts</h2>

<a class="add" href="add_workout.php">➕ Add Workout</a>
<a href="../index.php">⬅ Back to Main Page</a>

<table>
    <tr>
        <th>Date</th>
        <th>Type</th>
        <th>Notes</th>
        <th>Actions</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['workout_date'] ?></td>
        <td><?= $row['workout_type'] ?></td>
        <td><?= $row['notes'] ?></td>
        <td>
            <!-- View Exercises -->
            <a class="view" href="exercises.php?workout_id=<?= $row['id'] ?>">💪 Exercises</a>

            <!-- Delete Workout -->
            <a class="delete" href="delete_workout.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Delete this workout?')">❌ Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
