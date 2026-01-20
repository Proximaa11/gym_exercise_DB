<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include "../config/database.php";

$type = isset($_GET['type']) ? $_GET['type'] : '';

$response = [];

try {
    switch ($type) {
        case 'workouts':
            $sql = "SELECT COUNT(*) as total FROM workouts";
            $result = $conn->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                $response['total'] = (int)$row['total'];
            } else {
                $response['total'] = 0;
            }
            break;
            
        case 'exercises': 
            $sql = "SELECT COUNT(*) as total FROM exercise_logs";
            $result = $conn->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                $response['total'] = (int)$row['total'];
            } else {
                $response['total'] = 0;
            }
            break;
            
        case 'days_active':
            $sql = "SELECT COUNT(DISTINCT DATE(workout_date)) as days FROM workouts";
            $result = $conn->query($sql);
            if ($result && $row = $result->fetch_assoc()) {
                $response['days'] = (int)$row['days'];
            } else {
                $response['days'] = 0;
            }
            break;
            
        default:
            $response['error'] = 'Invalid type parameter';
    }
} catch (Exception $e) {
    $response['error'] = $e->getMessage();
    $response['total'] = 0;
}

echo json_encode($response);

$conn->close();
?>