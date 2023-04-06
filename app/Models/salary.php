<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class salary extends Model
{
    use HasFactory;

	protected $guarded=[];
	public function employees()
    {
    	return $this->belongsTo(employee::class);
    }
	public function tasks()
    {
        return $this->hasMany(task::class);
    }

}
