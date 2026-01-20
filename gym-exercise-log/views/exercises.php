<?php
include "../config/database.php";

// Validate workout_id
if (! isset($_GET['workout_id']) || empty($_GET['workout_id'])) {
    header("Location: workouts.php");
    exit();
}

$workout_id = intval($_GET['workout_id']);

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = ? ";
$stmt = $conn->prepare($workout_sql);
$stmt->bind_param("i", $workout_id);
$stmt->execute();
$workout_result = $stmt->get_result();
$workout = $workout_result->fetch_assoc();

if (!$workout) {
    header("Location: workouts.php");
    exit();
}

// Get exercises for this workout
$sql = "SELECT * FROM exercise_logs WHERE workout_id = ?  ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $workout_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercises - <?= htmlspecialchars($workout['workout_type']) ?> - Gym Exercise Log</title>
    <link rel="stylesheet" href="../../styles. css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond: wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <header class="page-header">
            <div class="ornament-top"></div>
            <h1 class="page-title">Exercise Log</h1>
            <p class="page-subtitle">
                <?= htmlspecialchars($workout['workout_type']) ?> • 
                <?= date('F j, Y', strtotime($workout['workout_date'])) ?>
            </p>
            <div class="divider"></div>
        </header>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="add_exercise.php?workout_id=<?= $workout_id ?>" class="btn btn-primary">
                <span>➕</span> Add Exercise
            </a>
            <a href="workouts.php" class="btn">
                <span>⬅</span> Back to Workouts
            </a>
            <a href="../../index.html" class="btn">
                <span>🏠</span> Home
            </a>
        </div>

        <!-- Workout Notes -->
        <?php if (! empty($workout['notes'])): ?>
            <div style="background-color: #EDE8DC; padding: 1. 5rem; margin-bottom: 2rem; border-left: 3px solid #B8956A;">
                <p style="margin:  0; color: #3B3735; font-style: italic;">
                    <strong>Workout Notes:</strong> <?= htmlspecialchars($workout['notes']) ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- Exercises Table -->
        <?php if ($result && $result->num_rows > 0): ?>
            <table class="workout-table">
                <thead>
                    <tr>
                        <th>Exercise Name</th>
                        <th>Muscle Group</th>
                        <th>Sets</th>
                        <th>Reps</th>
                        <th>Weight (kg)</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($row['exercise_name']) ?></strong></td>
                        <td><?= htmlspecialchars($row['muscle_group']) ?></td>
                        <td><?= htmlspecialchars($row['sets']) ?></td>
                        <td><?= htmlspecialchars($row['reps']) ?></td>
                        <td><?= htmlspecialchars($row['weight']) ?> kg</td>
                        <td><?= htmlspecialchars($row['notes']) ?></td>
                        <td>
                            <a href="edit_exercise.php?id=<?= $row['id'] ?>" class="btn btn-view" style="font-size: 0.85rem; padding: 0.5rem 0.75rem;">
                                ✏️ Edit
                            </a>
                            <a href="delete_exercise.php?id=<?= $row['id'] ?>&workout_id=<?= $workout_id ?>" 
                               class="btn btn-delete" 
                               style="font-size: 0.85rem; padding: 0.5rem 0.75rem;"
                               onclick="return confirm('Are you certain you wish to remove this exercise?  This action cannot be undone.')">
                                ❌ Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No exercises logged for this workout yet.  Begin by adding your first exercise. </p>
            </div>
        <?php endif; ?>

        <!-- Footer -->
        <footer class="footer">
            <div class="ornament-bottom"></div>
            <p class="footer-text">Excellence in Every Repetition</p>
        </footer>
    </div>
</body>
</html>