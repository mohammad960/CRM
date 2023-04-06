<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class quotation extends Model
{
    use HasFactory;
	protected $guarded=[];
	public function employees()
    {
		return $this->belongsToMany(employee::class, 'employee_quotation');

    }

	 public function clients()
    {
        return $this->belongsTo(client::class);
    }
}
