<?php
// Connect to DB
$db = new PDO("mysql:host=localhost;dbname=promprog", "promprog", "1221");

$st = $db->prepare("SELECT * FROM users WHERE login = :l and password = :p");
$st->bindParam(':l', $_REQUEST['login']);
$st->bindParam(':p', $_REQUEST['password']);
$st->execute();

$userData = $st->fetch(PDO::FETCH_ASSOC);

var_dump($result);

if(!empty($userData)) {
    echo json_encode([
        'status' => 'ok'
    ]); 
} else {
    echo json_encode([
        'status' => 'error',
        'description' => 'Credentials are invalid'
    ]); 
}


?>