<?php

namespace App\Controllers;

class PegawaiController extends BaseController
{

  // function__construct()
  // {
  //   $this->model = new \App\Models\Pegawai();
  // }

  public function index()
  {
    return view('pegawai_view');
  }
}