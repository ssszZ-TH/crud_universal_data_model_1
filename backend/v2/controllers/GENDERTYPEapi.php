<?php

/**
 * @access public
 * @author ssszz
 */

require __DIR__ . '/../models/GENDERTYPEmodel.php';

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
$genderModel = new GENDERTYPE($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $result = $genderModel->getById($_GET['id']);
        } else {
            $result = $genderModel->getAll();
        }
        sendResponse(200, $result);
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['description'])) {
            sendResponse(400, [], 'กรุณาระบุชื่อเพศ');
            break;
        }
        if (empty($data['gendercode'])) {
            sendResponse(400, [], 'กรุณาระบุรหัสเพศ');
            break;
        }
        if (strlen($data['gendercode']) !== 1) {
            sendResponse(400, [], 'รหัสเพศต้องมีความยาว 1 ตัวอักษร');
            break;
        }

        $result = $genderModel->create($data);
        sendResponse(201, ['id' => $result], 'เพิ่มข้อมูลประเทศสำเร็จ');
        break;

    case 'PUT':
        // อ่านข้อมูลที่ส่งมา
        $data = json_decode(file_get_contents('php://input'), true);

        // ตรวจสอบความครบถ้วนของ request
        if (!isset($_GET['id'])) {
            sendResponse(400, [], 'กรุณาระบุ ID ของประเทศ');
            break;
        }
        if (empty($data['description'])) {
            sendResponse(400, [], 'กรุณาระบุชื่อเพศ');
            break;
        }
        if (empty($data['gendercode'])) {
            sendResponse(400, [], 'กรุณาระบุรหัสเพศ');
            break;
        }
        if (strlen($data['gendercode']) !== 1) {
            sendResponse(400, [], 'รหัสเพศต้องมีความยาว 1 ตัวอักษร');
            break;
        }

        // ตรวจสอบว่ามีข้อมูลที่จะอัปเดตหรือไม่
        $result = $genderModel->getById($_GET['id']);
        if (!$result) {
            sendResponse(404, [], 'ไม่พบข้อมูลที่จะเเก้ใข');
            break;
        }

        $result = $genderModel->update($_GET['id'], $data);
        sendResponse(200, $result, 'อัปเดตข้อมูลประเทศสำเร็จ');
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            sendResponse(400, [], 'กรุณาระบุ ID ของประเทศ');
            break;
        }

        $result = $genderModel->delete($_GET['id']);
        if (isset($result['error'])) {
            sendResponse(404, [], $result['error']);
        } else {
            sendResponse(200, $result, 'ลบข้อมูลประเทศสำเร็จ');
        }
        break;

    default:
        sendResponse(405, [], 'Method not allowed');
}