<?php

// Connect to DB
$db = new PDO("mysql:host=localhost;dbname=promprog", "promprog", "1221");

$st = $db->prepare("SELECT * FROM product");
$st->execute();

$productArr = $st->fetchall(PDO::FETCH_ASSOC);

echo json_encode($productArr);

?>