<?php

require __DIR__ . '/../config/db.php';

class COUNTRYmodel 
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // READ: ดึงข้อมูลตาม countryid
    public function getById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.country WHERE countryid = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // READ: ดึงข้อมูลทั้งหมด
    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM public.country ORDER BY countryid ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE: เพิ่มข้อมูลประเทศใหม่
    public function create($data)
    {
        // ตรวจสอบข้อมูลที่จำเป็น
        if (!isset($data['isocode']) || !isset($data['countryname'])) {
            return ['error' => 'isocode และ countryname เป็นข้อมูลที่จำเป็น'];
        }

        $stmt = $this->pdo->prepare(
            "INSERT INTO public.country (isocode, countryname)
             VALUES (?, ?)"
        );

        $stmt->execute([
            strtoupper($data['isocode']), // แปลงเป็นตัวพิมพ์ใหญ่
            $data['countryname']
        ]);

        return $this->pdo->lastInsertId();
    }

    // UPDATE: อัปเดตข้อมูลประเทศ
    public function update($id, $data)
    {
        // ตรวจสอบว่ามีข้อมูลที่จะอัปเดตหรือไม่
        if (empty($data['isocode']) && empty($data['countryname'])) {
            return ['message' => 'No data provided for update.'];
        }

        $stmt = $this->pdo->prepare(
            'UPDATE public.country 
             SET isocode = ?, countryname = ?
             WHERE countryid = ?'
        );

		// ชื่อประเทศจะต้องเป็นตัวใหญ่
        $stmt->execute([
            strtoupper($data['isocode']),
            $data['countryname'],
            $id
        ]);

        if ($stmt->rowCount() > 0) {
            return $this->getById($id);
        } else {
            return ['message' => 'No changes made or record not found.'];
        }
    }

    // DELETE: ลบข้อมูลประเทศ
    public function delete($id)
    {
        // ดึงข้อมูลก่อนลบ
        $country = $this->getById($id);

        if (!$country) {
            return ['message' => 'Record not found.'];
        }

        try {
            $stmt = $this->pdo->prepare('DELETE FROM public.country WHERE countryid = ?');
            $stmt->execute([$id]);

            if ($stmt->rowCount() > 0) {
                return $country;
            } else {
                return ['message' => 'Failed to delete the record.'];
            }
        } catch (PDOException $e) {
            // จัดการกรณีมี foreign key constraint
            return ['error' => 'Cannot delete this country as it is referenced by other records.'];
        }
    }

    // เพิ่มเมธอดสำหรับค้นหาประเทศตาม ISO code
    public function getByIsoCode($isoCode)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM public.country WHERE isocode = ?');
        $stmt->execute([strtoupper($isoCode)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}