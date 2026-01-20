<?php
include "../config/database. php";

// Validate exercise ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location:  workouts.php");
    exit();
}

$id = intval($_GET['id']);

// Fetch exercise data
$sql = "SELECT * FROM exercise_logs WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: workouts.php");
    exit();
}

$exercise = $result->fetch_assoc();
$workout_id = $exercise['workout_id'];

// Get workout info
$workout_sql = "SELECT * FROM workouts WHERE id = ?";
$stmt = $conn->prepare($workout_sql);
$stmt->bind_param("i", $workout_id);
$stmt->execute();
$workout_result = $stmt->get_result();
$workout = $workout_result->fetch_assoc();

$error_message = '';

// Handle form submission
if (isset($_POST['update'])) {
    $name = trim($_POST['exercise_name']);
    $muscle = trim($_POST['muscle_group']);
    $sets = intval($_POST['sets']);
    $reps = intval($_POST['reps']);
    $weight = floatval($_POST['weight']);
    $notes = trim($_POST['notes']);

    if (!empty($name) && !empty($muscle) && $sets > 0 && $reps > 0) {
        $update_sql = "UPDATE exercise_logs SET 
                       exercise_name = ?, 
                       muscle_group = ?, 
                       sets = ?, 
                       reps = ?, 
                       weight = ?, 
                       notes = ? 
                       WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssiidsi", $name, $muscle, $sets, $reps, $weight, $notes, $id);

        if ($stmt->execute()) {
            header("Location: exercises. php?workout_id=$workout_id");
            exit();
        } else {
            $error_message = "Error updating exercise: " . $conn->error;
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
    <title>Edit Exercise - Gym Exercise Log</title>
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
            <h1 class="page-title">Edit Exercise</h1>
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
                <div style="padding: 1rem; background-color: #f8d7da; color:  #721c24; margin-bottom: 1.5rem; border: 1px solid #f5c6cb;">
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
                           value="<?= htmlspecialchars($exercise['exercise_name']) ?>"
                           required>
                </div>

                <div class="form-group">
                    <label for="muscle_group" class="form-label">Muscle Group *</label>
                    <select id="muscle_group" 
                            name="muscle_group" 
                            class="form-select" 
                            required>
                        <option value="">Select muscle group... </option>
                        <option value="Chest" <?= $exercise['muscle_group'] == 'Chest' ? 'selected' : '' ?>>Chest</option>
                        <option value="Back" <?= $exercise['muscle_group'] == 'Back' ? 'selected' : '' ?>>Back</option>
                        <option value="Shoulders" <?= $exercise['muscle_group'] == 'Shoulders' ?  'selected' : '' ?>>Shoulders</option>
                        <option value="Biceps" <?= $exercise['muscle_group'] == 'Biceps' ? 'selected' : '' ?>>Biceps</option>
                        <option value="Triceps" <?= $exercise['muscle_group'] == 'Triceps' ? 'selected' :  '' ?>>Triceps</option>
                        <option value="Legs" <?= $exercise['muscle_group'] == 'Legs' ? 'selected' :  '' ?>>Legs</option>
                        <option value="Quadriceps" <?= $exercise['muscle_group'] == 'Quadriceps' ? 'selected' : '' ?>>Quadriceps</option>
                        <option value="Hamstrings" <?= $exercise['muscle_group'] == 'Hamstrings' ? 'selected' :  '' ?>>Hamstrings</option>
                        <option value="Glutes" <?= $exercise['muscle_group'] == 'Glutes' ? 'selected' : '' ?>>Glutes</option>
                        <option value="Calves" <?= $exercise['muscle_group'] == 'Calves' ?  'selected' : '' ?>>Calves</option>
                        <option value="Core" <?= $exercise['muscle_group'] == 'Core' ? 'selected' : '' ?>>Core</option>
                        <option value="Abs" <?= $exercise['muscle_group'] == 'Abs' ? 'selected' : '' ?>>Abs</option>
                        <option value="Full Body" <?= $exercise['muscle_group'] == 'Full Body' ? 'selected' :  '' ?>>Full Body</option>
                        <option value="Cardio" <?= $exercise['muscle_group'] == 'Cardio' ? 'selected' : '' ?>>Cardio</option>
                    </select>
                </div>

                <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label for="sets" class="form-label">Sets *</label>
                        <input type="number" 
                               id="sets" 
                               name="sets" 
                               class="form-input" 
                               value="<?= htmlspecialchars($exercise['sets']) ?>"
                               min="1" 
                               max="100"
                               required>
                    </div>
                    <div>
                        <label for="reps" class="form-label">Reps *</label>
                        <input type="number" 
                               id="reps" 
                               name="reps" 
                               class="form-input" 
                               value="<?= htmlspecialchars($exercise['reps']) ?>"
                               min="1" 
                               max="1000"
                               required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" 
                           id="weight" 
                           name="weight" 
                           class="form-input" 
                           value="<?= htmlspecialchars($exercise['weight']) ?>"
                           step="0.5" 
                           min="0">
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea id="notes" 
                              name="notes" 
                              class="form-textarea"><?= htmlspecialchars($exercise['notes']) ?></textarea>
                </div>

                <button type="submit" name="update" class="form-submit">
                    Update Exercise
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