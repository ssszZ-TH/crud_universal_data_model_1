<?php
require __DIR__ . '/../config/db.php';

/**
 * @access public
 * @author ssszz
 */
class GENDERTYPE
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll()
  {
    $stmt = $this->pdo->query('SELECT * FROM public.gendertype ORDER BY gendertypeid ASC');
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM public.gendertype WHERE gendertypeid = ?');
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getByCode($code)
  {
    $stmt = $this->pdo->prepare('SELECT * FROM public.gendertype WHERE gendercode = ?');
    $stmt->execute([$code]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($data)
  {
    // ตรวจสอบข้อมูลที่จำเป็น
    if (!isset($data['gendercode']) || !isset($data['description'])) {
      return ['error' => 'gendercode และ description เป็นข้อมูลที่จำเป็น'];
    }

    $stmt = $this->pdo->prepare(
      "INSERT INTO public.gendertype (gendercode, description)
			 VALUES (?, ?)"
    );

    $stmt->execute([
      $data['gendercode'],
      $data['description']
    ]);


    if ($stmt->rowCount() > 0) {
      return $this->pdo->lastInsertId();
    } else {
      return ['message' => 'Failed to create the record.'];
    }
  }

  public function update($id, $data)
  {
    // ตรวจสอบว่ามีข้อมูลที่จะอัปเดตหรือไม่
    if (empty($data['gendercode']) && empty($data['description'])) {
      return ['error' => 'No data provided for update.'];
    }

    if (isset($data['gendercode']) && strlen($data['gendercode']) !== 1) {
      return ['error' => 'Gendertype code must be 1 characters long.'];
    }

    $stmt = $this->pdo->prepare(
      "UPDATE public.gendertype 
			 SET gendercode = ?, description = ?
			 WHERE gendertypeid = ?"
    );

    $stmt->execute([
      $data['gendercode'],
      $data['description'],
      $id
    ]);

    if ($stmt->rowCount() > 0) {
      return $this->getById($id);
    } else {
      return ['message' => 'Failed to update the record.'];
    }
  }

  public function delete($id)
  {
    // ดึงข้อมูลก่อนลบ
    $gender = $this->getById($id);

    if (!$gender) {
      return ['error' => 'Record not found.'];
    }

    $stmt = $this->pdo->prepare('DELETE FROM public.gendertype WHERE gendertypeid = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
      return $gender;
    } else {
      return ['error' => 'Failed to delete the record.'];
    }

  }

}
