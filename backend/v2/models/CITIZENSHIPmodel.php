<?php

require __DIR__ . '/../config/db.php'; // ดึง config ของ database

class CITIZENSHIPmodel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // READ: ดึงข้อมูลตาม citizenshipid
    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.citizenship WHERE citizenshipid = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ: ดึงข้อมูลทั้งหมด
    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM public.citizenship ORDER BY citizenshipid ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE: เพิ่มข้อมูลใหม่
    public function create($data)
    {
        // ตรวจสอบว่ามี thrudate หรือไม่ ถ้าไม่มีให้กำหนดเป็น null
        if (!isset($data['thrudate'])) {
            $data['thrudate'] = null;
        }

        // เตรียมคำสั่ง SQL สำหรับการเพิ่มข้อมูลใหม่
        $stmt = $this->pdo->prepare(
            "INSERT INTO public.citizenship (fromdate, thrudate, countrycountryid, passportpassportid)
             VALUES (?, ?, ?, ?)"
        );

        // Execute คำสั่ง SQL พร้อมข้อมูลที่รับมา
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid']]);

        // คืนค่า id ที่เพิ่งเพิ่มเข้าไป
        return $this->pdo->lastInsertId();
    }

    // UPDATE: อัปเดตข้อมูล
    // UPDATE: อัปเดตข้อมูล
    public function update($id, $data)
    {
        // อัปเดตข้อมูล
        $stmt = $this->pdo->prepare(
            'UPDATE public.citizenship 
         SET fromdate = ?, thrudate = ?, countrycountryid = ?, passportpassportid = ? 
         WHERE citizenshipid = ?'
        );

        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid'], $id]);

        // ตรวจสอบว่ามีการอัปเดตข้อมูลหรือไม่
        if ($stmt->rowCount() > 0) {
            // ดึงข้อมูลที่เพิ่งถูกอัปเดตกลับมา
            return $this->getById($id);
        } else {
            // ถ้าไม่มีการอัปเดต ให้คืนค่าข้อความแจ้งเตือน
            return ['message' => 'No changes made or record not found.'];
        }
    }


    // DELETE: ลบข้อมูล
    // DELETE: ลบข้อมูล
    public function delete($id)
    {
        // ดึงข้อมูลก่อนลบเพื่อคืนค่ากลับไปหลังจากลบ
        $citizenship = $this->getById($id);

        // ถ้าไม่พบข้อมูล ให้คืนข้อความแจ้งเตือน
        if (!$citizenship) {
            return ['message' => 'Record not found.'];
        }

        // ลบข้อมูล
        $stmt = $this->pdo->prepare('DELETE FROM public.citizenship WHERE citizenshipid = ?');
        $stmt->execute([$id]);

        // ตรวจสอบว่ามีการลบข้อมูลหรือไม่
        if ($stmt->rowCount() > 0) {
            // คืนค่าข้อมูลที่ถูกลบ
            return $citizenship;
        } else {
            // ถ้าไม่มีการลบ ให้คืนข้อความแจ้งเตือน
            return ['message' => 'Failed to delete the record.'];
        }
    }

}
