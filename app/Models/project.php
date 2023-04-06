<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class project extends Model
{
    use HasFactory;
    use softDeletes;
	protected $guarded=[];

    public function getImageAttribute($value)
    {
        return $value == null?"2122136.png":$value;
    }

	public function employees()
    {
		return $this->belongsToMany(employee::class, 'employee_project');

    }

	public function tasks()
    {
        return $this->hasMany(task::class);
    }

	 public function clients()
    {
        return $this->belongsTo(client::class);
    }
}
