<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'user_id',
        'tanggal_pinjam',
        'tanggal_batas_kembali',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_batas_kembali' => 'date',
        ];
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    // Relasi ke Detail Peminjaman
    public function detailPeminjaman()
    {
        return $this->hasMany(
            DetailPeminjaman::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }

    // Relasi ke Pengembalian
    public function pengembalian()
    {
        return $this->hasOne(
            Pengembalian::class,
            'id_peminjaman',
            'id_peminjaman'
        );
    }
}