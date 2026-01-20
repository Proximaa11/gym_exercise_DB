<?php
include "../config/database.php";

// Get all workouts
$sql = "SELECT * FROM workouts ORDER BY workout_date DESC";
$result = $conn->query($sql);
?>

<! DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Workouts - Gym Exercise Log</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <header class="page-header">
            <div class="ornament-top"></div>
            <h1 class="page-title">My Workouts</h1>
            <p class="page-subtitle">A comprehensive record of your training journey</p>
            <div class="divider"></div>
        </header>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="add_workout.php" class="btn btn-primary">
                <span>➕</span> Add New Workout
            </a>
            <a href="../../index.html" class="btn">
                <span>⬅</span> Back to Home
            </a>
        </div>

        <!-- Workouts Table -->
        <?php if ($result && $result->num_rows > 0): ?>
            <table class="workout-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Workout Type</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['workout_date']) ?></td>
                        <td><?= htmlspecialchars($row['workout_type']) ?></td>
                        <td><?= htmlspecialchars($row['notes']) ?></td>
                        <td>
                            <a href="exercises. php?workout_id=<?= $row['id'] ?>" class="btn btn-view">
                                💪 Exercises
                            </a>
                            <a href="delete_workout.php?id=<?= $row['id'] ?>" 
                               class="btn btn-delete"
                               onclick="return confirm('Are you certain you wish to remove this workout?  This action cannot be undone.')">
                                ❌ Delete
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="empty-state">
                <p>No workouts recorded yet. Begin your fitness journey by adding your first workout. </p>
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