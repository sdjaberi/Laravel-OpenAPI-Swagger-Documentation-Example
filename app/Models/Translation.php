<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translation extends Model
{
    use SoftDeletes;

    public $table = 'phrase_translations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'translation',
        'language_id',
        'phrase_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function phrase()
    {
        return $this->belongsTo(Phrase::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
