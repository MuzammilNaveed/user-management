<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lectures extends Model
{
    protected $table = 'lectures';
    protected $fillable = ['title','description','video_url','instructor','course_id','created_by'];
    use HasFactory;
}
