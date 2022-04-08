<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    public $table = 'languages';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'iso_code',
        'text_direction',
        'is_primary',
        'active',
        'local_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_language');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }
}
