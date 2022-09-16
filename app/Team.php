<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public $timestamps = false;

    public function competitionCategory() {
        return $this->belongsTo("App\CompetitionCategory", "competition_categories_id");
    }

    public function submission() {
        return $this->hasMany("App\Submission", "teams_id");
    }

    public function user(){
        return $this->belongsToMany("App\User", "user_details", "teams_id", "nrp")
        ->withPivot("role", "id_card", "self_photo", "line", "borang", "gpa_recap", "schedule", "achievement_list", "competition_type");
    }
}
