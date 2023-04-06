<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class user extends Model implements
    \Illuminate\Contracts\Auth\Authenticatable
	{
    use HasFactory;
    use softDeletes;
	use Authenticatable;
	protected $guarded=[];
    protected $dates = ['deleted_at'];

	 public function employee()
    {
        return $this->hasOne(employee::class)->withTrashed();
    }



}
