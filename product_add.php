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
    if($userData['role'] == 2){
        $st = $db->prepare("INSERT INTO product (title, price) VALUES (:tt, :p)");
        $st->bindParam(':tt', $_REQUEST['title']);
        $st->bindParam(':p', $_REQUEST['price']);
        $st->execute();

        echo json_encode([
            'status' => 'ok',
            'product_id' => $db->lastInsertId()
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'description' => 'Access denied'
        ]);
    }
}

?>