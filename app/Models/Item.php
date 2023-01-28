<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $fillable = [
        'name',
        'description',
        'category_id',
        'type_id',
        'user_id',
        'status',
        'price',
        'state',
        'city'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function attachments()
    {
        return $this->hasMany(ItemAttachment::class, 'items_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(ItemUser::class, 'item_user', 'user_id','item_id');
    }

}
