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
        $st = $db->prepare("UPDATE orders SET courier_id = :id WHERE id = :oid");
        $st->bindParam(':id', $userData['id']);
        $st->bindParam(':oid', $_REQUEST['order_id']);
        $st->execute();

        echo json_encode([
            'status' => 'ok'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'description' => 'Access denied'
        ]);
    }
}

?>