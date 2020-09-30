<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicField extends Model
{
    use HasFactory;

    protected $fillable = ['field'];

    protected $casts = ['field' => 'array'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->field = [
            ['', '' ,''],
            ['', '' ,''],
            ['', '' ,'']
        ];
    }
}
