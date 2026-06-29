<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $fillable = ['title','description','start_date','end_date','code'];
    public function responses()
    {
        return $this->hasMany(ResponseForm::class);
    }
}
