<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class employee_project extends Model
{
    use HasFactory;
    
	protected $table="employee_project";
	protected $guarded=[];
}
