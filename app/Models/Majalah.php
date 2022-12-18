<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majalah extends Model
{
    use HasFactory;

        /**
    * fillable
    *
    * @var array
    */
  
    protected $fillable = [
    'nama_majalah',
    'jenis_majalah',
    'penerbit',
    'harga_majalah',
    'jumlah_majalah',
    ]; 
}
