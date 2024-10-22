<?php

require __DIR__ . '/../config/db.php'; // ดึง config ของ database

class CitizenshipService
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
        if (!isset($data['thrudate'])) {
            $data['thrudate'] = null;
        }

        $stmt = $this->pdo->prepare("INSERT INTO public.citizenship(fromdate, thrudate, countryid, passportid) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid']]);
        return $this->pdo->lastInsertId();
    }

    // UPDATE: อัปเดตข้อมูล
    public function update($id, $data)
    {
        $stmt = $this->pdo->prepare('UPDATE public.citizenship SET fromdate = ?, thrudate = ?, countryid = ?, passportid = ? WHERE citizenshipid = ?');
        $stmt->execute([$data['fromdate'], $data['thrudate'], $data['countryid'], $data['passportid'], $id]);
        return $stmt->rowCount();
    }

    // DELETE: ลบข้อมูล
    public function delete($id)
    {
        $stmt = $this->pdo->prepare('DELETE FROM public.citizenship WHERE citizenshipid = ?');
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }
}