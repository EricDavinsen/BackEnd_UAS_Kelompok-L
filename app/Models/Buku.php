<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

        /**
    * fillable
    *
    * @var array
    */
  
    protected $fillable = [
    'judul_buku',
    'penerbit',
    'harga_buku',
    'jumlah_buku',
    ]; 
}
