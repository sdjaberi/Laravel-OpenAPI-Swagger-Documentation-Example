<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phrase extends Model
{
    use SoftDeletes;

    public $table = 'phrases';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'phrase',
        'base_id',
        'category_name',
        'phrase_category_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function phraseCategory()
    {
        return $this->belongsTo(PhraseCategory::class);
    }
}
