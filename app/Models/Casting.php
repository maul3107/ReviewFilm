<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Casting extends Model
{
    use HasFactory;

    protected $table = 'castings';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'photo',
        'stage_name',
        'real_name',
        'film_id',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class, 'film_id');
    }
}
