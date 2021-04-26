<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = [
      'user_id',
      'time_in',
      'time_out',
      'date'
    ];

    protected $table="posts";

    public function user(){
        return $this->belongsTo(User::class);
    }
}
