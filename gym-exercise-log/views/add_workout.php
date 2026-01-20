<?php 
include "../config/database.php";

$success_message = '';
$error_message = '';

if (isset($_POST['save'])) {
    $date  = $_POST['workout_date'];
    $type  = $_POST['workout_type'];
    $notes = $_POST['notes'];

    // Use prepared statements for security
    $stmt = $conn->prepare("INSERT INTO workouts (workout_date, workout_type, notes) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $date, $type, $notes);

    if ($stmt->execute()) {
        header("Location: workouts.php");
        exit();
    } else {
        $error_message = "Error saving workout: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout - Gym Exercise Log</title>
    <link rel="stylesheet" href="../../styles. css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2? family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond: wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <header class="page-header">
            <div class="ornament-top"></div>
            <h1 class="page-title">Add Workout</h1>
            <p class="page-subtitle">Document your training with precision and care</p>
            <div class="divider"></div>
        </header>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="workouts.php" class="btn">
                <span>⬅</span> Back to Workouts
            </a>
            <a href="../../index.html" class="btn">
                <span>🏠</span> Home
            </a>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <?php if ($error_message): ?>
                <div style="padding: 1rem; background-color: #f8d7da; color: #721c24; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="workout_date" class="form-label">Date</label>
                    <input type="date" 
                           id="workout_date" 
                           name="workout_date" 
                           class="form-input" 
                           required
                           value="<?= date('Y-m-d') ?>">
                </div>

                <div class="form-group">
                    <label for="workout_type" class="form-label">Workout Type</label>
                    <select id="workout_type" 
                            name="workout_type" 
                            class="form-select" 
                            required>
                        <option value="">Select a type... </option>
                        <option value="Push">Push</option>
                        <option value="Pull">Pull</option>
                        <option value="Legs">Legs</option>
                        <option value="Cardio">Cardio</option>
                        <option value="Full Body">Full Body</option>
                        <option value="Upper Body">Upper Body</option>
                        <option value="Lower Body">Lower Body</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" 
                              name="notes" 
                              class="form-textarea" 
                              placeholder="Record any observations, achievements, or areas for improvement... "></textarea>
                </div>

                <button type="submit" name="save" class="form-submit">
                    Save Workout
                </button>
            </form>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="ornament-bottom"></div>
            <p class="footer-text">Excellence in Every Repetition</p>
        </footer>
    </div>
</body>
</html>