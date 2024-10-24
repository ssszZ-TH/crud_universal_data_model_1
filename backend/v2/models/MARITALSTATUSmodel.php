<?php

require __DIR__ . '/../config/db.php';

/**
 * @access public
 * @author ssszz
 */
class MARITALSTATUS
{
  private $pdo;

  public function __construct($pdo)
  {
    $this->pdo = $pdo;
  }

  public function getAll()
  {
    $stmt = $this->pdo->query('SELECT * FROM public.maritalstatus ORDER BY maritalstatusid ASC');
    return $stmt->fetchAll();
  }

  public function getById($id)
  {
    if (empty($id)) {
      return ['error' => 'findById the id cannot be empty.'];
    }
    $stmt = $this->pdo->prepare('SELECT * FROM public.maritalstatus WHERE maritalstatusid = ?');
    $stmt->execute([$id]);
    // ถ้าหา id นั้นไม่เจอ pdo จะ return false
    return $stmt->fetch();
  }

  public function create($data)
  {
    if (empty($data['fromdate'])) {
      return ['error' => 'missing fromdate'];
    }
    if (empty($data['thrudate'])) {
      $data['thrudate'] = null;
    }
    if (empty($data['maritalstatustypeid'])) {
      return ['error' => 'missing maritalstatustypeid'];
    }
    $stmt = $this->pdo->prepare(
      "INSERT INTO public.maritalstatus(
        fromdate, thrudate, maritalstatustypemaritalstatustypeid)
        VALUES (?, ?, ?)"
    );
    $stmt->execute([
      $data['fromdate'],
      $data['thrudate'],
      $data['maritalstatustypeid']
    ]);

    if ($stmt->rowCount() > 0) {
      return $this->pdo->lastInsertId();
    } else {
      return ['error' => 'Failed to create the record.'];
    }
  }
  

  public function update($id, $data)
  {
    // ตรวจสอบว่ามีข้อมูลที่จะอัปเดตหรือไม่
    if (empty($data['fromdate'])) {
      return ['error' => 'missing fromdate'];
    }
    if (empty($data['thrudate'])) {
      $data['thrudate'] = null;
    }
    if (empty($data['maritalstatustypeid'])) {
      return ['error' => 'missing maritalstatustypeid'];
    }
    if (empty($id)) {
      return ['error' => 'missing id'];
    }

    // ดึงข้อมูลก่อนอัปเดต
    $maritalstatus = $this->getById($id);
    if (!$maritalstatus) {
      return ['error' => 'Record not found.'];
    }

    $stmt = $this->pdo->prepare(
      "UPDATE public.maritalstatus
      SET fromdate=?, thrudate=?, maritalstatustypemaritalstatustypeid=?
      WHERE maritalstatusid = ?"
    );

    $stmt->execute([
      $data['fromdate'],
      $data['thrudate'],
      $data['maritalstatustypeid'],
      $id
    ]);

    if ($stmt->rowCount() > 0) {
      return $this->getById($id);
    } else {
      return ['error' => 'Failed to update the record.'];
    }
  }

  public function delete($id)
  {
    // ดึงข้อมูลก่อนลบ
    $maritalstatus = $this->getById($id);

    if (!$maritalstatus) {
      return ['error' => 'Record not found.'];
    }

    $stmt = $this->pdo->prepare('DELETE FROM public.maritalstatus WHERE maritalstatusid = ?');
    $stmt->execute([$id]);

    if ($stmt->rowCount() > 0) {
      return $maritalstatus;
    } else {
      return ['error' => 'Failed to delete the record.'];
    }
  }
}
