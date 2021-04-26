<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Shift extends Model
{
    use HasFactory;

    protected $table="shifts";
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
