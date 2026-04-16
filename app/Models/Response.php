<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $primaryKey = 'response_id';

    protected $fillable = [
        'user_id',
        'complaint_id',
        'message',
        'action_photo',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function complaint() {
        return $this->belongsTo(Complaint::class, 'complaint_id', 'complaint_id');
    }
}
