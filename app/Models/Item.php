<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    public $timestamps = true;
    protected $table = 'items';
    protected $fillable = [
        'collection_id',
        'name',
        'description',
        'condition'
    ];

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }
    public function images() {
        return $this->hasMany(ItemImage::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }
}
?>