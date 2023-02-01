<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'references';
    protected $guarded = [];

    public function setting()
    {
        return $this->hasOne(Setting::class, 'value', 'id');
    }
}
