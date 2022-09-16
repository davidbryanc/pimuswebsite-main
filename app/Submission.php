<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    public $timestamps = false;

    public function team() {
        return $this->belongsTo("App\Team", "teams_id");
    }
}
