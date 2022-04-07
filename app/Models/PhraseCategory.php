<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhraseCategory extends Model
{
    use SoftDeletes;

    public $table = 'phrase_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'filename',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function phrases()
    {
        return $this->hasMany(Phrase::class); //'phrase_category_id'
    }
}
