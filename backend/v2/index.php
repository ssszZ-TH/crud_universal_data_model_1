<?php
// กำหนด headers ทั้งหมดในครั้งเดียว
$headers = [
    "Access-Control-Allow-Origin: *",
    "Access-Control-Allow-Methods: POST, GET, PUT, DELETE",
    "Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With",
    "Access-Control-Allow-Credentials: true",
    "Content-Type: application/json"
];
foreach ($headers as $header) header($header);

// จัดการ URL
$request = str_replace('/v2', '', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// กำหนด routes และ controllers
$routes = [
    'citizenship' => 'CITIZENCHIP',
    'country' => 'COUNTRY',
    'gendertype' => 'GENDERTYPE',
    'maritalstatus' => 'MARITALSTATUS',
    'maritalstatustype' => 'MARITALSTATUSTYPE',
    'passport' => 'PASSPORT',
    'person' => 'PERSON',
    'personname' => 'PERSONNAME',
    'personnametype' => 'PERSONNAMETYPE',
    'physicalcharacteristic' => 'PHYSICALCHARACTORISTIC',
    'physicalcharacteristictype' => 'PHYSICALCHARACTORISTICTYPE'
];

// ตรวจสอบและโหลด controller
$path = trim($request, '/');
if (isset($routes[$path])) {
    require __DIR__ . "/controllers/{$routes[$path]}api.php";
} else {
    echo json_encode([
        'status' => 404,
        'data' => [],
        'message' => 'API URL not found'
    ]);
}
?>