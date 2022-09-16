<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionCategory extends Model
{
    public $timestamps = false;
    // public $table = "competition_categories";
    
    public function team() {
        return $this->hasMany("App\Team", "competition_categories_id");
    }
}
