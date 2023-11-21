<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', // Tambahkan atribut untuk judul
        'description', // Tambahkan atribut untuk deskripsi
        'picture', // Tambahkan atribut untuk gambar
    ];
}
