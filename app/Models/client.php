<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class client extends Model
{
    use HasFactory;
    use softDeletes;
    protected $dates = ['deleted_at'];
	protected $guarded=[];

	 public function projects()
    {
        return $this->hasMany(project::class);
    }
	public function quotations()
    {
        return $this->hasMany(quotation::class);
    }
}
