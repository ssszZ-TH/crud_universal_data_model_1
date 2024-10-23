<?php

require __DIR__ . '/../models/COUNTRYmodel.php';

// กำหนดประเภทของ content ให้เป็น JSON
header('Content-Type: application/json');

// ฟังก์ชันสำหรับส่งผลลัพธ์ในรูปแบบ JSON
function sendResponse($status, $data = [], $message = '')
{
    echo json_encode([
        'status' => $status,
        'data' => $data,
        'message' => $message
    ]);
    exit;
}

// อ่าน method ของ request ที่เข้ามา
$method = $_SERVER['REQUEST_METHOD'];

// สร้าง instance ของ model
$countryModel = new COUNTRYmodel($pdo);

switch ($method) {
    case 'GET':
        // ค้นหาด้วย ID
        if (isset($_GET['id'])) {
            $country = $countryModel->getById($_GET['id']);
            if ($country) {
                sendResponse(200, $country);
            } else {
                sendResponse(404, [], 'ไม่พบข้อมูลประเทศ');
            }
        } 
        // ค้นหาด้วย ISO code
        else if (isset($_GET['isocode'])) {
            $country = $countryModel->getByIsoCode($_GET['isocode']);
            if ($country) {
                sendResponse(200, $country);
            } else {
                sendResponse(404, [], 'ไม่พบข้อมูลประเทศจาก ISO code ที่ระบุ');
            }
        }
        // ดึงข้อมูลทั้งหมด
        else {
            $countries = $countryModel->getAll();
            sendResponse(200, $countries);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        
        // ตรวจสอบข้อมูลที่จำเป็น
        if (empty($data['isocode']) || empty($data['countryname'])) {
            sendResponse(400, [], 'กรุณาระบุ ISO code และชื่อประเทศ');
        }

        // ตรวจสอบรูปแบบ ISO code (2 ตัวอักษร)
        if (strlen($data['isocode']) !== 2) {
            sendResponse(400, [], 'ISO code ต้องมีความยาว 2 ตัวอักษร');
        }

        // ตรวจสอบว่ามี ISO code นี้อยู่แล้วหรือไม่
        $existingCountry = $countryModel->getByIsoCode($data['isocode']);
        if ($existingCountry) {
            sendResponse(409, [], 'ISO code นี้มีอยู่ในระบบแล้ว');
        }

        $id = $countryModel->create($data);
        sendResponse(201, ['id' => $id], 'เพิ่มข้อมูลประเทศสำเร็จ');
        break;

    case 'PUT':
        if (!isset($_GET['id'])) {
            sendResponse(400, [], 'กรุณาระบุ ID ของประเทศ');
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        // ตรวจสอบว่ามีข้อมูลที่จะอัปเดตหรือไม่
        if (empty($data['isocode']) && empty($data['countryname'])) {
            sendResponse(400, [], 'กรุณาระบุข้อมูลที่ต้องการอัปเดต');
        }

        // ตรวจสอบรูปแบบ ISO code ถ้ามีการอัปเดต
        if (isset($data['isocode']) && strlen($data['isocode']) !== 2) {
            sendResponse(400, [], 'ISO code ต้องมีความยาว 2 ตัวอักษร');
        }

        $updatedData = $countryModel->update($_GET['id'], $data);
        
        if (isset($updatedData['message'])) {
            sendResponse(404, [], $updatedData['message']);
        } else {
            sendResponse(200, $updatedData, 'อัปเดตข้อมูลประเทศสำเร็จ');
        }
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            sendResponse(400, [], 'กรุณาระบุ ID ของประเทศ');
        }

        $result = $countryModel->delete($_GET['id']);

        if (isset($result['error'])) {
            sendResponse(409, [], $result['error']);
        } else if (isset($result['message'])) {
            sendResponse(404, [], $result['message']);
        } else {
            sendResponse(200, $result, 'ลบข้อมูลประเทศสำเร็จ');
        }
        break;

    default:
        sendResponse(405, [], 'Method not allowed');
}
?>