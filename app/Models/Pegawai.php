<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

        /**
    * fillable
    *
    * @var array
    */
  
    protected $fillable = [
    'nama_pegawai',
    'alamat',
    'umur',
    'jenis_kelamin',
    'tugas',
    ]; 
}
