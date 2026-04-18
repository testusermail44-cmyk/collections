<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ItemImage extends Model
{
    public $timestamps = false;
    protected $table = 'item_images';
    protected $fillable = [
        'item_id',
        'url',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}