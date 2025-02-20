<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Film extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'films';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'title',
        'poster',
        'description',
        'release_year',
        'duration',
        'creator',
        'trailer',
        'user_id',
    ];

    /**
     * Auto-generate UUID saat membuat record baru.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($film) {
            if (!$film->id) {
                $film->id = (string) Str::uuid();
            }
        });
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genres_relations', 'film_id', 'genre_id');
    }

    public function genreRelations()
    {
        return $this->hasMany(GenreRelation::class, 'film_id');
    }

    public function castings()
    {
        return $this->hasMany(Casting::class, 'film_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'film_id');
    }
}
