<?php

// Connect to DB
$db = new PDO("mysql:host=localhost;dbname=promprog", "promprog", "1221");

$st = $db->prepare("SELECT * FROM users WHERE token = :t");
$st->bindParam(':t', $_REQUEST['token']);
$st->execute();

$userData = $st->fetch(PDO::FETCH_ASSOC);

if( empty($userData) ){
    echo json_encode([
        'status' => 'error',
        'description' => 'Token is invalid'
    ]);
} else {
    if($userData['role'] == 1){
        $st = $db->prepare("SELECT * FROM orders WHERE courier_id IS NULL");
        $st->execute();

        $orderArr = $st->fetchall(PDO::FETCH_ASSOC);

        echo json_encode([
            'status' => 'ok',
            'orders' => $orderArr
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'description' => 'Access denied'
        ]);
    }
}

?>