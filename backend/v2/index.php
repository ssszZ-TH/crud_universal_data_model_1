<?php
// index.php
// Handle CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// อ่าน /... ที่ป้อนเข้ามา
$request = $_SERVER['REQUEST_URI'];

// ลบ query string ออกจาก URL
$request = parse_url($request, PHP_URL_PATH);

// ลบ '/v2' ออกจาก URL
$request = str_replace('/v2', '', $request);


// สร้าง routing สำหรับ URL ต่างๆ
switch ($request) {
    
    case '/citizenship':
        require __DIR__ . '/controllers/citizenshipApi.php';
        break;

    case '/about':
        require __DIR__ . '/about.php';
        break;

    default:
        echo json_encode([
            'status' => 404,
            'data' => [],
            'message' => 'api url not found'
        ]);
        break;
}
?>
