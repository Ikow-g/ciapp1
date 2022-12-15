<?php

namespace App\Controllers;

use App\Models\Pegawai;

class PegawaiController extends BaseController
{

  function __construct()
  {
    $this->model = new Pegawai();
  }

  public function index()
  {
    $jumlahBaris = 5;
    $katakunci = $this->request->getGet('katakunci');
    if ($katakunci) {
      $pencarian = $this->model->cari($katakunci);
    } else {
      $pencarian = $this->model;
    }
    $data['katakunci'] = $katakunci;
    $data['dataPegawai'] = $pencarian->orderBy('id', 'desc')->paginate($jumlahBaris);
    $data['pager'] = $this->model->pager;
    $data['nomor'] = ($this->request->getVar('page') == 1) ? '0' : $this->request->getVar('page');
    return view('pegawai_view', $data);
  }

  public function hapus($id)
  {
    ['id'=>$id];
    $this->model->delete($id);
    return redirect()->to('pegawai');
  }

  public function edit($id)
  {
    return json_encode($this->model->find($id));
  }

  public function simpan()
  {
    $validasi = \config\Services::validation();
    $aturan =[
      'nama'=> ['label'=> 'Nama', 'rules' => 'required', 'errors' => ['required' => '{field} harus diisi', 'min_length' => 'Minimum karakter untuk field {field} adalah 5 karakter']],
      'email' => [
        'label' => 'Email',
        'rules' => 'required|min_length[5]|valid_email',
        'errors' => [
          'required' => '{field} harus diisi',
          'min_length' => 'Minimum karakter untuk field {field} adalah 5 karakter',
          'valid_email' => 'Email yang kamu masukkan tidak valid'
        ]
      ],
      'alamat' => [
        'label' => 'Alamat',
        'rules' => 'required|min_length[5]',
        'errors' => [
          'required' => '{field} harus diisi',
          'min_length' => 'Minimum karakter untuk field {field} adalah 5 karakter'
        ]
      ],
    ];

    $validasi->setRules($aturan);
    if ($validasi->withRequest($this->request)->run()) {
      $id = $this->request->getPost('id');
      $nama = $this->request->getPost('nama');
      $email = $this->request->getPost('email');
      $departemen = $this->request->getPost('departemen');
      $alamat = $this->request->getPost('alamat');

      $data = [
        'id' => $id,
        'nama' => $nama,
        'email' => $email,
        'departemen' => $departemen,
        'alamat' => $alamat
      ];

      $this->model->save($data);

      $hasil['sukses'] = "Berhasil memasukkan data";
      $hasil['error'] = true;
    } else {
      $hasil['sukses'] = false;
      $hasil['error'] = $validasi->listErrors();
    }


    return json_encode($hasil);
  }

}
