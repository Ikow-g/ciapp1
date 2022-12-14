<?php
namespace App\Models;
use CodeIgniter\Model;

class Pegawai extends Model
{
  protected $table = "pegawai";
  protected $primaryKey = "id";
  protected $allowedFields = [
    'nama',
    'email',
    'departemen',
    'alamat'
  ];
}