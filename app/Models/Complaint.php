<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $primaryKey = 'complaint_id';

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'evidence_photo',
        'status',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function responses() {
        return $this->hasMany(Response::class, 'complaint_id', 'complaint_id');
    }
}
