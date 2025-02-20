<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GenreRelation extends Model
{
    use HasFactory;

    protected $table = 'genres_relations';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'film_id',
        'genre_id',
    ];

    /**
     * Define the many-to-many relationship with Genre
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genres_relations', 'film_id', 'genre_id');
    }

    /**
     * Define the relationship with Film
     */
    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}

