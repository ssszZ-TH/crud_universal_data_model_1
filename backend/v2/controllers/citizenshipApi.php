<?php

require __DIR__ . '/../models/CitizenshipService.php'; // ดึง class CitizenshipService

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

// สร้าง instance ของ service
$citizenshipService = new CitizenshipService($pdo);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $citizenships = $citizenshipService->getById($id);
            if ($citizenships) {
                sendResponse(200, $citizenships);
            } else {
                sendResponse(404, [], 'Not found');
            }
        } else {
            $citizenships = $citizenshipService->getAll();
            sendResponse(200, $citizenships);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['fromdate'], $data['countryid'], $data['passportid'])) {
            $id = $citizenshipService->create($data);
            sendResponse(201, ['id' => $id], 'Create success');
        } else {
            sendResponse(400, [], 'Bad request');
        }
        break;

    case 'PUT':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = json_decode(file_get_contents('php://input'), true);
            if (isset($data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid'])) {
                $rowCount = $citizenshipService->update($id, $data);
                if ($rowCount > 0) {
                    sendResponse(200, [], 'Update success');
                } else {
                    sendResponse(404, [], 'Resource not found');
                }
            } else {
                sendResponse(400, [], 'Bad request JSON body invalid');
            }
        } else {
            sendResponse(400, [], 'Bad request: No ID params provided');
        }
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $rowCount = $citizenshipService->delete($id);
            if ($rowCount > 0) {
                sendResponse(200, [], 'Deleted');
            } else {
                sendResponse(404, [], 'Resource not found');
            }
        } else {
            sendResponse(400, [], 'Bad request: No ID params provided');
        }
        break;

    default:
        sendResponse(405, [], 'Method not allowed');
        break;
}
?>
