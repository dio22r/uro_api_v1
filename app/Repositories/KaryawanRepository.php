<?php

namespace App\Repositories;

use App\Entities\Karyawan;
use App\Models\KaryawanModel;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\RequestTrait;

class KaryawanRepository
{
  protected $karyawan;
  protected $karyawanModel;

  public function __construct()
  {
    $this->karyawan = new Karyawan();
    $this->karyawanModel = new KaryawanModel();
  }

  public function retrieve($type, $search = "", $start = 0, $limit = 10)
  {

    if ($type == "rekanku") {
      $arrId = $this->karyawanModel
        ->join("project_member as t1", "karyawan.KodeUser = t1.KodeUser")
        ->select("t1.IDProject")
        ->findAll();

      return $arrId;

      // $this->karyawanModel->join("project_member as t1")->whereIn("id");
    }

    // return $this->karyawanModel
    //   ->like("karyawan.Nama", $search, "both")
    //   ->findAll($limit, $start);
  }

  public function retrieve_by_id($id)
  {
    return $this->karyawan->fill($this->karyawanModel->find($id));
  }

  public function insert($arrPost)
  {
    $this->memberModel->setValidationRule('password', 'required|min_length[8]');
    $this->memberModel->setValidationMessage('password', [
      'required' => 'Password harus di isi minimal 8 Karakter',
      'min_length' => 'Password harus di isi minimal 8 Karakter'
    ]);

    $this->memberModel->setValidationRule('pass_confirm', 'required_with[password]|matches[password]');
    $this->memberModel->setValidationMessage('pass_confirm', [
      'required_with' => 'Konfirmasi Password harus di isi minimal 8 Karakter',
      'matches' => 'Password tidak sama'
    ]);


    $this->karyawan->fill($arrPost);

    $this->karyawan->gen_activation_code();
    $this->karyawan->setPassword($arrPost["password"]);

    $arrReady = [
      "result" => $this->memberModel->save($this->karyawan),
      "arr_err" => $this->memberModel->errors()
    ];

    return $arrReady;
  }

  public function update()
  {
    $this->karyawan->fill($this->request);
  }

  public function delete()
  {
  }
}
