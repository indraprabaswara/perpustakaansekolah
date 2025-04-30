<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    protected $fillable = [
        'book_code',
        'judul',
        'pengarang',
        'penerbit',
        'year',
        'status'
    ];
    public function transaction(){
        return $this->hasMany(Transaksi::class,'book_id');
    }
}
