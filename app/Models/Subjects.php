<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    protected $fillable = [
        'subject_name',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
