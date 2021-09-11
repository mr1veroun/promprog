<?php

// Connect to DB
$db = new PDO("mysql:host=localhost;dbname=promprog", "promprog", "1221");

$st = $db->prepare("SELECT * FROM users WHERE login = :l");
$st->bindParam(':l', $_REQUEST['login']);
$st->execute();

$userData = $st->fetch(PDO::FETCH_ASSOC);

if( !empty($userData) ){
    echo json_encode([
        'status' => 'error',
        'description' => 'User exists'
    ]);
} else {
    $token = md5($userData['login'] . $userData['password'] . microtime(true));
    
    $st = $db->prepare("INSERT INTO users (login, password, token) VALUES (:l, :p, :t)");
    $st->bindParam(':l', $_REQUEST['login']);
    $st->bindParam(':p', $_REQUEST['password']);
    $st->bindParam(':t', $token);
    $st->execute();
    
    echo json_encode([
        'status' => 'ok',
        'token' => $token,
        'user_id' => $db->lastInsertId()
    ]);
}

?>