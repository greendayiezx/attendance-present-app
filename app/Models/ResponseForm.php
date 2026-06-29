<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseForm extends Model
{
    use HasFactory;
    protected $fillable = [
        "form_id",
        "nip",
        "nama",
        "tanda_tangan",
        "status",
    ];
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function form() {
        return $this->belongsTo(Form::class);
    }

}
