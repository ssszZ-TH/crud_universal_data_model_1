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
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countrycountryid'], $data['passportpassportid']]);
        
        // คืนค่า id ที่เพิ่งเพิ่มเข้าไป
        return $this->pdo->lastInsertId();
    }

    // UPDATE: อัปเดตข้อมูล
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE public.citizenship 
             SET fromdate = ?, thrudate = ?, countrycountryid = ?, passportpassportid = ? 
             WHERE citizenshipid = ?'
        );

        // Execute คำสั่ง SQL พร้อมข้อมูลที่รับมา
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countrycountryid'], $data['passportpassportid'], $id]);
        
        // คืนค่าจำนวนแถวที่ได้รับผลกระทบ
        return $stmt->rowCount();
    }

    // DELETE: ลบข้อมูล
    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM public.citizenship WHERE citizenshipid = ?');
        $stmt->execute([$id]);
        
        // คืนค่าจำนวนแถวที่ถูกลบ
        return $stmt->rowCount();
    }
}
