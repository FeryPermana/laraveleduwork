<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeFilter($query, $params)
    {
        if ($params->status) {
            $query->where(function ($query) use ($params) {
                $query->where('status', $params->status);
            });
        }

        if ($params->tanggal) {
            $query->where(function ($query) use ($params) {
                $query->whereDate('date_start', $params->tanggal);
            });
        }
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
