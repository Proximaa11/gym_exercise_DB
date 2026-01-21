<?php
include "../config/database.php";

if (!isset($_GET['id'])) die("Exercise ID is missing.");

$id = $_GET['id'];
$exercise = $conn->query("SELECT * FROM exercise_logs WHERE id = $id")->fetch_assoc();
if (!$exercise) die("Exercise not found.");
$workout_id = $exercise['workout_id'];

if (isset($_POST['update'])) {
    $conn->query("UPDATE exercise_logs SET
        exercise_name='{$_POST['exercise_name']}',
        muscle_group='{$_POST['muscle_group']}',
        sets={$_POST['sets']},
        reps={$_POST['reps']},
        weight={$_POST['weight']},
        notes='{$_POST['notes']}'
        WHERE id=$id");
    header("Location: exercises.php?workout_id=$workout_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exercise</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Cormorant+Garamond:wght@300;400;500&display=swap" rel="stylesheet">

    <style>
        /* ==============================
           Root Variables
        ============================== */
        :root {
            --ivory: #F8F6F0;
            --cream: #EDE8DC;
            --sand: #D4C5B0;
            --deep-green: #1F3933;
            --forest: #2D4A3E;
            --gold: #B8956A;
            --slate: #4A5D5A;
            --charcoal: #3B3735;

            --font-primary: 'Playfair Display', serif;
            --font-secondary: 'Cormorant Garamond', serif;
        }

        /* ==============================
           Base Styles
        ============================== */
        body {
            font-family: var(--font-secondary);
            background-color: var(--ivory);
            color: var(--charcoal);
            margin: 0;
            padding: 2rem;
        }

        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: var(--cream);
            padding: 2rem;
            border: 1px solid var(--sand);
            border-radius: 6px;
        }

        h2 {
            text-align: center;
            font-family: var(--font-primary);
            color: var(--deep-green);
            margin-bottom: 1rem;
        }

        /* ==============================
           Form Styles
        ============================== */
        form label {
            display: block;
            margin: 0.3rem 0;
            font-weight: 500;
            color: var(--deep-green);
        }

        form input,
        form textarea {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid var(--sand);
            border-radius: 4px;
            font-family: var(--font-secondary);
        }

        form input:focus,
        textarea:focus {
            outline: none;
            border-color: var(--gold);
            background-color: #fff;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--forest);
            color: var(--ivory);
            font-family: var(--font-primary);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background-color: var(--deep-green);
        }

        .back-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
            color: var(--slate);
            text-decoration: none;
            font-family: var(--font-primary);
        }

        .back-link:hover {
            color: var(--forest);
        }
    </style>
</head>
<body>
<div class="container">
<h2>Edit Exercise</h2>
<form method="POST">
<label>Exercise Name:</label><input type="text" name="exercise_name" value="<?= htmlspecialchars($exercise['exercise_name']) ?>" required>
<label>Muscle Group:</label><input type="text" name="muscle_group" value="<?= htmlspecialchars($exercise['muscle_group']) ?>" required>
<label>Sets:</label><input type="number" name="sets" value="<?= $exercise['sets'] ?>" required>
<label>Reps:</label><input type="number" name="reps" value="<?= $exercise['reps'] ?>" required>
<label>Weight (kg):</label><input type="number" step="0.5" name="weight" value="<?= $exercise['weight'] ?>" required>
<label>Notes:</label><textarea name="notes"><?= htmlspecialchars($exercise['notes']) ?></textarea>
<button type="submit" name="update">Update Exercise</button>
</form>
<a class="back-link" href="exercises.php?workout_id=<?= $workout_id ?>">⬅ Back to Exercises</a>
</div>
</body>
</html>
