<?php include "../config/database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Workout - Gym Exercise Log</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container page-container">
        <!-- Page Header -->
        <header class="page-header">
            <h1 class="page-title">Add Workout</h1>
            <p class="page-subtitle">Document your latest training session with precision</p>
        </header>

        <!-- Form Section -->
        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label class="form-label" for="workout_date">Date</label>
                    <input class="form-input" type="date" name="workout_date" id="workout_date" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="workout_type">Workout Type</label>
                    <select class="form-select" name="workout_type" id="workout_type" required>
                        <option value="Push">Push</option>
                        <option value="Pull">Pull</option>
                        <option value="Legs">Legs</option>
                        <option value="Cardio">Cardio</option>
                        <option value="Full Body">Full Body</option>
                        <option value="Anterior">Anterior</option>
                        <option value="Posterior">Posterior</option>
                        <option value="Upper">Upper</option>
                        <option value="Lower">Lower</option>             
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="notes">Notes</label>
                    <textarea class="form-textarea" name="notes" id="notes" placeholder="Optional notes about your workout"></textarea>
                </div>

                <button class="form-submit" type="submit" name="save">Save Workout</button>
            </form>
        </div>
        </div>
        <div class="action-buttons2">
        <a class="btn btn-view" href="../index.php">⬅ Back to Main Page</a>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="ornament-bottom"></div>
            <p class="footer-text">Est. 2026 • Excellence in Every Repetition</p>
        </footer>
    </div>
</body>
</html>

<?php
// PHP processing (unchanged)
if (isset($_POST['save'])) {
    $date  = $_POST['workout_date'];
    $type  = $_POST['workout_type'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO workouts (workout_date, workout_type, notes)
            VALUES ('$date', '$type', '$notes')";

    if ($conn->query($sql)) {
        header("Location: workouts.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
