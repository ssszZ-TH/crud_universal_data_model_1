<?php
// Handle CORS
// กำหนด CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

include 'db.php';

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

switch ($method) {
    case 'GET':
        // Handle Read (GET)
        if (isset($_GET['id'])) {
            // Handle Read by ID
            $id = $_GET['id'];
            $stmt = $pdo->prepare('SELECT * FROM public.maritalstatus WHERE maritalstatusid = ?');
            $stmt->execute([$id]);
            $maritalstatus = $stmt->fetch();
            if ($maritalstatus) {
                sendResponse(200, $maritalstatus);
            } else {
                sendResponse(404, [], 'not found');
            }
        } else {
            // Handle Read all
            $stmt = $pdo->query('SELECT * FROM public.maritalstatus ORDER BY maritalstatus ASC');
            $maritalstatus = $stmt->fetchAll();
            sendResponse(200, $maritalstatus);
        }
        break;

    case 'POST':
        // รับข้อมูล JSON จาก body ของ request
        $data = json_decode(file_get_contents('php://input'), true);

        // ตรวจสอบว่ามีข้อมูลครบหรือไม่
        if (isset($data['maritalstatustypeid'], $data['fromdate'])) {
            // handle empty thrudate
            if (!isset($data['thrudate'])) {
                $data['thrudate'] = null;
            }

            // เตรียม statement ตอนเเรกลองเอาประโยค query เก็บในตัวเเปรก่อนค่อยนําไปใช้ จะทำให้ program bug
            $stmt = $pdo->prepare("INSERT INTO public.maritalstatus(maritalstatustypeid, fromdate, thrudate) VALUES (?, ?, ?)");

            // Execute คำสั่ง SQL พร้อมข้อมูลที่รับมา
            $stmt->execute([$data['maritalstatustypeid'], $data['fromdate'], $data['thrudate']]);

            // ส่ง response กลับไปว่าเสร็จสิ้น
            sendResponse(201, ['id' => $pdo->lastInsertId()], 'create success');
        } else {
            // ส่ง response กลับไปว่า input ไม่ถูกต้อง
            sendResponse(400, [], 'bad request');
        }
        break;


    case 'PUT':
        // ตรวจสอบว่ามีการส่ง ID มาใน query หรือไม่
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data = json_decode(file_get_contents('php://input'), true);

            // ตรวจสอบว่ามี resource ที่จะทำการอัปเดตหรือไม่
            $selectStmt = $pdo->prepare('SELECT * FROM public.maritalstatus WHERE maritalstatusid = ?');
            $selectStmt->execute([$id]);
            $existingData = $selectStmt->fetch(PDO::FETCH_ASSOC);

            if ($existingData) {
                // ตรวจสอบว่าข้อมูลที่ส่งมามีครบหรือไม่
                if (isset($data['maritalstatustypeid'], $data['fromdate'])) {

                    // handle empty thrudate
                    if (!isset($data['thrudate'])) {
                        $data['thrudate'] = null;
                    }

                    // อัปเดตข้อมูลในฐานข้อมูล
                    $stmt = $pdo->prepare('UPDATE public.maritalstatus SET maritalstatustypeid = ?, fromdate = ?, thrudate = ? WHERE maritalstatusid = ?');
                    $stmt->execute([$data['maritalstatustypeid'], $data['fromdate'], $data['thrudate'], $id]);

                    // ดึงข้อมูลที่เพิ่งอัปเดต
                    $selectStmt->execute([$id]);
                    $updatedData = $selectStmt->fetch(PDO::FETCH_ASSOC);

                    // ส่ง response กลับไปพร้อมข้อมูลที่อัปเดต
                    sendResponse(200, $updatedData, 'Resource updated');
                } else {
                    sendResponse(400, [], 'bad request json body invalid');
                }
            } else {
                sendResponse(404, [], 'Resource not found');
            }
        } else {
            sendResponse(400, [], 'bad request: No ID params provided');
        }
        break;



    case 'DELETE':
        // ตรวจสอบว่ามีการส่ง ID มาใน query หรือไม่
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // ดึงข้อมูลก่อนลบ
            $selectStmt = $pdo->prepare('SELECT * FROM public.maritalstatus WHERE maritalstatusid = ?');
            $selectStmt->execute([$id]);
            $dataToDelete = $selectStmt->fetch(PDO::FETCH_ASSOC);

            if ($dataToDelete) {
                // ลบข้อมูล
                $stmt = $pdo->prepare('DELETE FROM public.maritalstatus WHERE maritalstatusid = ?');
                $stmt->execute([$id]);

                // ส่ง response กลับไปพร้อมข้อมูลที่ถูกลบ
                sendResponse(200, $dataToDelete, 'deleted');
            } else {
                sendResponse(404, [], 'Resource not found');
            }
        } else {
            sendResponse(400, [], 'bad request: No ID params provided');
        }
        break;


    default:
        // Method not supported
        sendResponse(405, [], 'Method not allowed');
        break;
}
?>

?>