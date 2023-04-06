<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class employee extends Model
{
    use HasFactory;
    use softDeletes;
	protected $guarded=[];

    public function getImageAttribute($value)
    {
        return $value == null?"2122136.png":$value;
    }

	public function attendances()
    {
        return $this->hasMany(attendance::class);
    }

	public function projects()
    {
		return $this->belongsToMany(project::class, 'employee_project');

    }
   public function quotations()
    {
		return $this->belongsToMany(quotation::class, 'employee_quotation');

    }
	public function tasks()
    {
        return $this->hasMany(task::class);
    }
	public function salaries()
    {
        return $this->hasMany(salary::class);
    }
	 public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function position()
    {
        return $this->belongsTo(position::class);
    }
}
