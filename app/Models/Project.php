<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'type_id', 'visible', 'url', 'description', 'img'];

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
