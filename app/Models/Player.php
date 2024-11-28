<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Player extends Model
{
    use HasFactory;

    protected $table = 'players';

    protected $fillable = ['nickname'];

    public function scores(){
        return $this->hasMany(Score::class);//relation the data with score model
    }
}
