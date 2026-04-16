<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name'
    ];

    public function complaints() {
        return $this->hasMany(Complaint::class, 'category_id', 'category_id');
    }
}
