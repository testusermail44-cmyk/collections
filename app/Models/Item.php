<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    public $timestamps = true;
    protected $table = 'items';
    protected $fillable = [
        'collection',
        'name',
        'image'
    ];
}
?>