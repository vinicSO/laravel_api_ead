<?php

namespace App\Models;

use App\Models\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, UuidTrait;

    public $incrementing = false;

    protected $keyType = 'uuid';

    protected $fillable = [
        'name'
    ];

    public function course () {
        return [
            'id' => $this->id,
            'name' => ucwords(strtolower($this->name))
        ];
    }

    public function lessons () {
        return $this->hasMany(Lesson::class);
    }
}
