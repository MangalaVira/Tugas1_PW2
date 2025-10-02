<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'user_id', 'nama_transaksi', 'tipe_transaksi', 'jumlah', 'tanggal', 'keterangan'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

