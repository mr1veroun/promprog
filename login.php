<?php

// Connect to DB
$db = new PDO("mysql:host=localhost;dbname=promprog", "promprog", "1221");

$st = $db->prepare("SELECT * FROM users WHERE login = :l and password = :p");
$st->bindParam(':l', $_REQUEST['login']);
$st->bindParam(':p', $_REQUEST['password']);
$st->execute();

$userData = $st->fetch(PDO::FETCH_ASSOC);

if( !empty($userData) ){
    $token = md5($userData['login'] . $userData['password'] . microtime(true));

    $st = $db->prepare("UPDATE users SET token = :t WHERE id = :id");
    $st->bindParam(':t', $token);
    $st->bindParam(':id', $userData['id']);
    $st->execute();


    echo json_encode([
        'status' => 'ok',
        'token' => $token
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'description' => 'Credentials are invalid'
    ]);
}

?>