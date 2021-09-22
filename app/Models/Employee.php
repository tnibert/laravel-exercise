<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = ["firstname", "lastname", "dob", "email", "company_id"];
    public $timestamps = false;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
