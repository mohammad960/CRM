<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class task extends Model
{
    use HasFactory;

	protected $guarded=[];

	public function employees()
    {
    	return $this->belongsTo(employee::class);
    }
	public function salaries()
    {
    	return $this->belongsTo(salary::class);
    }
	public function projects()
    {
    	return $this->belongsTo(project::class);
    }
}
