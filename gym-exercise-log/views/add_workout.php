<?php include "../config/database.php"; ?>

<h2>Add Workout</h2>

<form method="POST">
    <label>Date:</label><br>
    <input type="date" name="workout_date" required><br><br>

    <label>Workout Type:</label><br>
    <select name="workout_type" required>
        <option value="Push">Push</option>
        <option value="Pull">Pull</option>
        <option value="Legs">Legs</option>
        <option value="Cardio">Cardio</option>
    </select><br><br>

    <label>Notes:</label><br>
    <textarea name="notes"></textarea><br><br>

    <button type="submit" name="save">Save Workout</button>
</form>

<?php
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
