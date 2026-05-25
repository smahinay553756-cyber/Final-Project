<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRemovalRequest extends Model
{
    protected $fillable = ['target_user_id', 'requested_by', 'status', 'reviewed_by', 'reason'];

    public function targetUser()  { return $this->belongsTo(User::class, 'target_user_id'); }
    public function requester()   { return $this->belongsTo(User::class, 'requested_by'); }
    public function reviewer()    { return $this->belongsTo(User::class, 'reviewed_by'); }
}
