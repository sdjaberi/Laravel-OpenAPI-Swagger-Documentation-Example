<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;

    public $table = 'projects';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'author_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
