<?php

/**
 * @access public
 * @author ssszz
 */

require __DIR__ . '/../models/MARITALSTATUSmodel.php';

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

$maritalstatusModel = new MARITALSTATUS($pdo);

switch ($method) {
  case 'GET':
    if (isset($_GET['id'])) {
      $result = $maritalstatusModel->getById($_GET['id']);
    } else {
      $result = $maritalstatusModel->getAll();
    }
    if (!$result) {
      sendResponse(404, [], 'not found');
      break;
    }
    sendResponse(200, $result, 'read success');
    break;

  case 'POST':
    $data = json_decode(file_get_contents('php://input'), true);
    $result = $maritalstatusModel->create($data);

    // ตรวจสอบว่าผลลัพธ์เป็นอาเรย์และมีคีย์ 'error' หรือไม่
    if (is_array($result) && isset($result['error'])) {
      sendResponse(400, [], $result['error']);
    } else {
      sendResponse(201, ['id' => $result], 'create success');
    }
    break;


  case 'PUT':
    $data = json_decode(file_get_contents('php://input'), true);
    $result = $maritalstatusModel->update($_GET['id'], $data);

    // ตรวจสอบว่าผลลัพธ์เป็นอาเรย์และมีคีย์ 'error' หรือไม่
    if (is_array($result) && isset($result['error'])) {
      sendResponse(400, [], $result['error']);
    } else {
      sendResponse(200, $result, 'update success');
    }
    break;


  case 'DELETE':
    $result = $maritalstatusModel->delete($_GET['id']);

    // ตรวจสอบว่าผลลัพธ์เป็นอาเรย์และมีคีย์ 'error' หรือไม่
    if (is_array($result) && isset($result['error'])) {
      sendResponse(400, [], $result['error']);
    } else {
      sendResponse(200, $result, 'delete success');
    }
    break;


  default:
    sendResponse(405, [], 'Method not allowed');
    break;
}