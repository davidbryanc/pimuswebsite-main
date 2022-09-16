<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    public $timestamps = false;
    protected $primaryKey = 'nrp';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nrp', 'email', 'nama', 'password', 'tiket_vote', 'divisi', 'verificated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function team(){
        return $this->belongsToMany("App\Team", "user_details", "nrp", "teams_id")
        ->withPivot("role", "id_card", "self_photo", "line", "borang", "gpa_recap", "schedule", "achievement_list", "competition_type");
    }
}
