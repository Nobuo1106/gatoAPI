<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'post_id','file_path'];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(Signup::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}
