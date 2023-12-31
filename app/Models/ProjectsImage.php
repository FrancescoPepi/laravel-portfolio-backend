<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsImage extends Model
{
    use HasFactory;
    protected $fillable = ['project_id', 'filename'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
