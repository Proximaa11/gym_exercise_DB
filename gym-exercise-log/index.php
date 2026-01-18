<?php
include "config/database.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gym Exercise Log</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f9f9f9;
            color: #333;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .menu {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        .menu a {
            text-decoration: none;
            padding: 15px 25px;
            background-color: #3498db;
            color: white;
            border-radius: 8px;
            transition: 0.2s;
        }
        .menu a:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<h1>Gym Exercise Log</h1>

<div class="menu">
    <a href="views/workouts.php">View Workouts</a>
    <a href="views/add_workout.php">Add Workout</a>
</div>

</body>
</html>
