<?php
include "../config/database.php";

// Validate workout_id
if (!isset($_GET['workout_id']) || empty($_GET['workout_id'])) {
    header("Location: workouts.php");
    exit();
}

$workout_id = intval($_GET['workout_id']);

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = ?";
$stmt = $conn->prepare($workout_sql);
$stmt->bind_param("i", $workout_id);
$stmt->execute();
$workout_result = $stmt->get_result();
$workout = $workout_result->fetch_assoc();

if (!$workout) {
    header("Location: workouts.php");
    exit();
}

$error_message = '';

// Handle form submission
if (isset($_POST['save'])) {
    $name = trim($_POST['exercise_name']);
    $muscle = trim($_POST['muscle_group']);
    $sets = intval($_POST['sets']);
    $reps = intval($_POST['reps']);
    $weight = floatval($_POST['weight']);
    $notes = trim($_POST['notes']);

    if (! empty($name) && !empty($muscle) && $sets > 0 && $reps > 0) {
        $sql = "INSERT INTO exercise_logs (workout_id, exercise_name, muscle_group, sets, reps, weight, notes) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issiiis", $workout_id, $name, $muscle, $sets, $reps, $weight, $notes);

        if ($stmt->execute()) {
            header("Location: exercises.php?workout_id=$workout_id");
            exit();
        } else {
            $error_message = "Error adding exercise:  " . $conn->error;
        }
        $stmt->close();
    } else {
        $error_message = "Please fill in all required fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Exercise - Gym Exercise Log</title>
    <link rel="stylesheet" href="../../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display: wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="page-container">
        <!-- Header -->
        <header class="page-header">
            <div class="ornament-top"></div>
            <h1 class="page-title">Add Exercise</h1>
            <p class="page-subtitle">
                <?= htmlspecialchars($workout['workout_type']) ?> • 
                <?= date('F j, Y', strtotime($workout['workout_date'])) ?>
            </p>
            <div class="divider"></div>
        </header>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a href="exercises.php?workout_id=<?= $workout_id ?>" class="btn">
                <span>⬅</span> Back to Exercises
            </a>
            <a href="workouts.php" class="btn">
                <span>📋</span> All Workouts
            </a>
            <a href="../../index.html" class="btn">
                <span>🏠</span> Home
            </a>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <?php if ($error_message): ?>
                <div style="padding: 1rem; background-color: #f8d7da; color: #721c24; margin-bottom: 1.5rem; border:  1px solid #f5c6cb;">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="exercise_name" class="form-label">Exercise Name *</label>
                    <input type="text" 
                           id="exercise_name" 
                           name="exercise_name" 
                           class="form-input" 
                           placeholder="e.g., Bench Press, Squat, Deadlift..."
                           required>
                </div>

                <div class="form-group">
                    <label for="muscle_group" class="form-label">Muscle Group *</label>
                    <select id="muscle_group" 
                            name="muscle_group" 
                            class="form-select" 
                            required>
                        <option value="">Select muscle group... </option>
                        <option value="Chest">Chest</option>
                        <option value="Back">Back</option>
                        <option value="Shoulders">Shoulders</option>
                        <option value="Biceps">Biceps</option>
                        <option value="Triceps">Triceps</option>
                        <option value="Legs">Legs</option>
                        <option value="Quadriceps">Quadriceps</option>
                        <option value="Hamstrings">Hamstrings</option>
                        <option value="Glutes">Glutes</option>
                        <option value="Calves">Calves</option>
                        <option value="Core">Core</option>
                        <option value="Abs">Abs</option>
                        <option value="Full Body">Full Body</option>
                        <option value="Cardio">Cardio</option>
                    </select>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap:  1rem;">
                    <div>
                        <label for="sets" class="form-label">Sets *</label>
                        <input type="number" 
                               id="sets" 
                               name="sets" 
                               class="form-input" 
                               min="1" 
                               max="100"
                               placeholder="3"
                               required>
                    </div>
                    <div>
                        <label for="reps" class="form-label">Reps *</label>
                        <input type="number" 
                               id="reps" 
                               name="reps" 
                               class="form-input" 
                               min="1" 
                               max="1000"
                               placeholder="10"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" 
                           id="weight" 
                           name="weight" 
                           class="form-input" 
                           step="0.5" 
                           min="0"
                           placeholder="0.0">
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" 
                              name="notes" 
                              class="form-textarea" 
                              placeholder="Record form notes, personal records, or areas for improvement... "></textarea>
                </div>

                <button type="submit" name="save" class="form-submit">
                    Add Exercise
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