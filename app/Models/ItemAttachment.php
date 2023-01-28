<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemAttachment extends Model
{
    use HasFactory;
    protected $table = 'items_attachment';
    protected $fillable = [
        'items_id',
        'filename_original',
        'filename'
    ];
}
