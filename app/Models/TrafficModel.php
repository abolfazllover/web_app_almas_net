<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrafficModel extends Model
{
    use HasFactory;
    protected $table='traffic';
    protected $fillable=['code', 'token', 'playload'];
}
