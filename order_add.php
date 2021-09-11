  
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
    if($userData['role'] == 0){
        $st = $db->prepare("INSERT INTO orders (client_id, product) VALUES (:id, :d)");
        $st->bindParam(':id', $userData['id']);
        $st->bindParam(':d', $_REQUEST['product']);
        $st->execute();

        echo json_encode([
            'status' => 'ok',
            'order_id' => $db->lastInsertId()
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'description' => 'Access denied'
        ]);
    }
}

?>