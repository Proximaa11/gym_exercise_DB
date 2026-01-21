<?php
include "../config/database.php";

$id = $_GET['id'];

$sql = "DELETE FROM workouts WHERE id = $id";
$conn->query($sql);

header("Location: workouts.php");
