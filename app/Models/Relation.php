<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    use HasFactory;

    protected $table = "relations";
    protected $fillable = ['name', 'furigana', 'gender', 'resisdence_card_number', 'my_number', 'dependent', 'user_id'];
}
