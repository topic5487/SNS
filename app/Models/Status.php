<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function user(){
        //一篇文章屬於一個用戶
        return $this->belongsTo(User::class);
    }
}
