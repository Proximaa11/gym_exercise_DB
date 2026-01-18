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

<h2>Exercises for <?= $workout['workout_date'] ?> - <?= $workout['workout_type'] ?></h2>

<a href="add_exercise.php?workout_id=<?= $workout_id ?>">➕ Add Exercise</a>
<a href="workouts.php">⬅ Back to Workouts</a>

<table border="1" cellpadding="8">
    <tr>
        <th>Name</th>
        <th>Muscle Group</th>
        <th>Sets</th>
        <th>Reps</th>
        <th>Weight (kg)</th>
        <th>Notes</th>
        <th>Action</th>
    </tr>

    <?php while ($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= $row['exercise_name'] ?></td>
        <td><?= $row['muscle_group'] ?></td>
        <td><?= $row['sets'] ?></td>
        <td><?= $row['reps'] ?></td>
        <td><?= $row['weight'] ?></td>
        <td><?= $row['notes'] ?></td>
        <td>
            <a href="edit_exercise.php?id=<?= $row['id'] ?>">✏️ Edit</a> |
            <a href="delete_exercise.php?id=<?= $row['id'] ?>&workout_id=<?= $workout_id ?>"
               onclick="return confirm('Delete this exercise?')">❌ Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
