<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Member extends BaseController
{
  use ResponseTrait;

  public function __construct()
  {
    $this->memberModel = new \App\Models\MemberModel();
  }

  public function index()
  {
    $start = $this->request->getGet("last_id");
    $search = $this->request->getGet("search");

    $start = $start ? $start : 0;
    $search = $search ? $search : "";

    $limit = 10;

    $arrReady = $this->memberModel->where("id >", $start)
      ->like("Nama", $search)
      ->findAll($limit, 0);

    return $this->respond($arrReady, 200);
  }

  public function show($id)
  {
    $minified = $this->request->getGet("minified");
    $arrColumn = [
      "id",
      "KodeUser",
      // "password",
      "Nama",
      // "AlamatKTP",
      // "KotaKTP",
      // "PropinsiKTP",
      // "NegaraKTP",
      "Telepon",
      "JenisKelamin",
      // "NoInduk",
      // "created_at",
      // "updated_at",
      "Email",
      "AlamatDomisili",
      "KotaDomisili",
      "PropinsiDomisili",
      "NegaraDomisili",
      "TempatLahir",
      "Pekerjaan",
      "TanggalLahir",
      // "Status",
      "IDJabatan",
    ];

    // check is allowed ??

    $column = implode(", ", $arrColumn);

    $arrReady = $this->memberModel->select($column)
      ->find($id);

    return $this->respond($arrReady, 200);
  }

  public function create()
  {
    $arrSave = $this->request->getPost();
    if (!$arrSave) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $arrSave["Status"] = 1;

    $arrReady = [
      "result" => $this->memberModel->save($arrSave),
      "arr_err" => $this->memberModel->errors()
    ];

    return $this->respond($arrReady, 200);
  }



  public function update($id)
  {
    $arrSave = $this->request->getJSON(true);

    if (!$arrSave) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $arrSave["id"] = $id; // id ini diambil dari session / jwt cookies

    // check is allowed ??

    $result = $this->memberModel->save($arrSave);

    $arrReady = [
      "result" => $result
    ];

    return $this->respond($arrReady, 200);
  }

  public function delete($id)
  {
    // check is allowed ??

    $result = $this->memberModel->uro_delete($id);

    $arrReady = [
      "result" => $result
    ];

    return $this->respond($arrReady, 200);
  }
}
