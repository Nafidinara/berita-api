<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'judul_berita', 'gambar_berita', 'deskripsi_berita','kategori_berita',
     ];
}
