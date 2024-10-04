<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
echo json_encode([
    'status' => 200,
    'data'=> null,
    'message' => 'this is root page not api',
]);

?>