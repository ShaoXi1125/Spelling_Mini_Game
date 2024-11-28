<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Score extends Model
{
    use HasFactory;

    protected $table = 'scores';
    protected $fillable = ['player_id','score'];

    public function player(){
        return $this->belongsTo(Player::class);
    }
}
