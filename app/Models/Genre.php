<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genre extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'genres';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'title',
        'slug',
    ];

    protected $dates = ['deleted_at'];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'genres_relations', 'genre_id', 'film_id');
    }

    public function genreRelations()
    {
        return $this->hasMany(GenreRelation::class, 'genre_id');
    }
}
