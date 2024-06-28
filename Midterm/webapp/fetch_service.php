<?php

include('dbconnect.php');

if (isset($_GET['serviceId']) && is_numeric($_GET['serviceId'])) {
    $serviceId = $_GET['serviceId'];

    $query = "SELECT `service_name`, `service_description`, `service_price` FROM `tbl_services` WHERE `service_id` = :serviceId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':serviceId', $serviceId, PDO::PARAM_INT);
    $stmt->execute();

    $serviceDetails = $stmt->fetch(PDO::FETCH_ASSOC);

    echo json_encode($serviceDetails);
    exit;
} else {
    
    echo json_encode(['error' => 'Invalid service ID']);
    exit;
}
?>