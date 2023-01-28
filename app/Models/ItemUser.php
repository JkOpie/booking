<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemUser extends Model
{
    use HasFactory;
    protected $table = 'item_user';

    protected $fillable = [
        'start_date',
        'end_date',
        'user_id',
        'item_id',
        'status',
        'receipt',
        'total_price',
        'receipt_original',
        'payment_type',
        'booking_number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->booking_number) {
                $maxId = static::withoutGlobalScope('own')->where('booking_number', 'LIKE', 'BN'.date('y').date('m').date('d').'-%')->max('booking_number');
                $newId = 1;
                if ($maxId) {
                  preg_match_all('/BN'.date('y').date('m').date('d').'-(\d+)/', $maxId, $matches);
                  $newId = (int)head($matches[1]) + 1;
                }
                $newIdStr = 'BN'.date('y').date('m').date('d').'-'.str_pad($newId, 5, '0', STR_PAD_LEFT);
                $model->booking_number = $newIdStr;
              }
        });

    }
}
