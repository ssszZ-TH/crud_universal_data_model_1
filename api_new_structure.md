การจัดโครงสร้างโฟลเดอร์สำหรับโปรเจกต์ PHP แบบ OOP ควรคำนึงถึงการแบ่งส่วนต่าง ๆ ออกเป็นโมดูลที่ชัดเจน เพื่อให้โค้ดอ่านง่าย บำรุงรักษาได้สะดวก และสามารถปรับขยายในอนาคตได้ง่าย

โครงสร้างโฟลเดอร์ที่เป็นที่นิยมและเหมาะสมสำหรับการพัฒนาแบบ OOP อาจมีลักษณะดังนี้:

### โครงสร้างไฟล์และโฟลเดอร์:

```
/myapp
    /config
        db.php                   # การเชื่อมต่อฐานข้อมูลและการตั้งค่าต่าง ๆ
    /src
        /Controllers
            CitizenshipController.php   # คอนโทรลเลอร์สำหรับ citizenship
        /Models
            Citizenship.php       # โมเดลสำหรับ citizenship
        /Services
            CitizenshipService.php # บริการที่ใช้ร่วมกับ controller (ถ้าซับซ้อน)
    /public
        index.php                 # จุดเริ่มต้นของ API
    /vendor                      # สำหรับ composer (หากใช้งาน)
    /tests
        CitizenshipTest.php       # ไฟล์สำหรับการทดสอบ
    .htaccess                    # การกำหนดกฎการเข้าถึงไฟล์
    composer.json                # สำหรับ composer package management
```

### รายละเอียด:

#### 1. `/config`
- **`db.php`**: ใช้สำหรับการเชื่อมต่อฐานข้อมูลและการตั้งค่าทั่วไปของโปรเจกต์ เช่น ข้อมูลการเชื่อมต่อฐานข้อมูล

#### 2. `/src`
โฟลเดอร์นี้เป็นที่เก็บไฟล์ที่เกี่ยวกับ business logic และ MVC pattern แบ่งตามฟังก์ชันการทำงานดังนี้:

- **`/Controllers`**: เก็บไฟล์ที่จัดการกับ request ต่างๆ เช่น HTTP GET, POST, PUT, DELETE โดย controller จะติดต่อกับ model และส่งข้อมูลไปยัง view (หรือในที่นี้จะส่ง JSON response)

- **`/Models`**: เก็บไฟล์ที่เป็นการแทนข้อมูล (data representation) หรือเรียกว่า model ซึ่งจะเกี่ยวข้องกับฐานข้อมูลโดยตรง รวมถึงกฎของข้อมูล (เช่น การตรวจสอบความถูกต้องของข้อมูล)

- **`/Services`**: (ถ้ามี) จะใช้สำหรับเก็บ logic หรือ business rule ที่ซับซ้อน ซึ่งบางครั้งเราอาจไม่ต้องการให้ controller ทำงานหนักเกินไป บริการนี้จะช่วยทำให้โค้ดแบ่งแยกเป็นสัดส่วน

#### 3. `/public`
โฟลเดอร์นี้เป็นที่เก็บไฟล์ที่สามารถเข้าถึงได้จากภายนอก โดยจะใช้เป็น entry point ของโปรเจกต์ ซึ่งสามารถสร้างไฟล์ `index.php` เพื่อใช้เป็นจุดเริ่มต้นในการรับคำขอทั้งหมด (เช่น การ route URL ไปยัง controller ที่ถูกต้อง)

#### 4. `/vendor`
โฟลเดอร์นี้จะถูกสร้างขึ้นอัตโนมัติเมื่อใช้ Composer (PHP package manager) เพื่อจัดการ dependency ของโปรเจกต์ เช่น library ต่างๆ ที่เรานำมาใช้งาน

#### 5. `/tests`
โฟลเดอร์สำหรับเก็บไฟล์ทดสอบ (Unit test) เพื่อใช้ในการทดสอบการทำงานของโปรแกรมให้มั่นใจว่าถูกต้องตามที่ต้องการ

---

### ตัวอย่างโค้ดในแต่ละไฟล์:

#### 1. **`/config/db.php`**
```php
<?php
$host = 'db';
$db   = 'myapp'; 
$user = 'user'; 
$pass = 'password';  

$dsn = "pgsql:host=$host;dbname=$db";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $pdo->exec("SET NAMES 'utf8'");
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
```

#### 2. **`/src/Models/Citizenship.php`**
```php
<?php
class Citizenship {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query('SELECT * FROM public.citizenship ORDER BY citizenshipid ASC');
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM public.citizenship WHERE citizenshipid = ?');
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->pdo->prepare("INSERT INTO public.citizenship(fromdate, thrudate, countryid, passportid) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid']]);
        return $this->pdo->lastInsertId();
    }

    public function update($id, $data) {
        $stmt = $this->pdo->prepare('UPDATE public.citizenship SET fromdate = ?, thrudate = ?, countryid = ?, passportid = ? WHERE citizenshipid = ?');
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid'], $id]);

        return $this->getById($id);
    }

    public function delete($id) {
        $selectStmt = $this->pdo->prepare('SELECT * FROM public.citizenship WHERE citizenshipid = ?');
        $selectStmt->execute([$id]);
        $dataToDelete = $selectStmt->fetch();

        if ($dataToDelete) {
            $stmt = $this->pdo->prepare('DELETE FROM public.citizenship WHERE citizenshipid = ?');
            $stmt->execute([$id]);
            return $dataToDelete;
        }
        return null;
    }
}
?>
```

#### 3. **`/src/Controllers/CitizenshipController.php`**
```php
<?php
require_once '../Models/Citizenship.php';

class CitizenshipController {
    private $citizenship;

    public function __construct($pdo) {
        $this->citizenship = new Citizenship($pdo);
    }

    public function handleRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id) {
                    $data = $this->citizenship->getById($id);
                    $this->sendResponse($data ? 200 : 404, $data, $data ? 'Success' : 'Not found');
                } else {
                    $data = $this->citizenship->getAll();
                    $this->sendResponse(200, $data, 'Success');
                }
                break;

            case 'POST':
                $data = json_decode(file_get_contents('php://input'), true);
                if (isset($data['fromdate'], $data['countryid'], $data['passportid'])) {
                    $id = $this->citizenship->create($data);
                    $this->sendResponse(201, ['id' => $id], 'Created');
                } else {
                    $this->sendResponse(400, [], 'Bad request');
                }
                break;

            case 'PUT':
                if ($id) {
                    $data = json_decode(file_get_contents('php://input'), true);
                    $updatedData = $this->citizenship->update($id, $data);
                    $this->sendResponse(200, $updatedData, 'Updated');
                } else {
                    $this->sendResponse(400, [], 'No ID provided');
                }
                break;

            case 'DELETE':
                if ($id) {
                    $deletedData = $this->citizenship->delete($id);
                    $this->sendResponse($deletedData ? 200 : 404, $deletedData, $deletedData ? 'Deleted' : 'Not found');
                } else {
                    $this->sendResponse(400, [], 'No ID provided');
                }
                break;

            default:
                $this->sendResponse(405, [], 'Method not allowed');
                break;
        }
    }

    private function sendResponse($status, $data, $message) {
        echo json_encode(['status' => $status, 'data' => $data, 'message' => $message]);
        exit;
    }
}
?>
```

#### 4. **`/public/index.php`** (Entry point ของ API)
```php
<?php
require_once '../config/db.php';
require_once '../src/Controllers/CitizenshipController.php';

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;

$controller = new CitizenshipController($pdo);
$controller->handleRequest($method, $id);
?>
```

### สรุป
การจัดโครงสร้างโฟลเดอร์และไฟล์ให้เป็นระบบระเบียบตามหลัก OOP จะช่วยให้โปรเจกต์ของคุณมีความยืดหยุ่น และสามารถบำรุงรักษาได้ง่าย