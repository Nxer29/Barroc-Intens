<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory;
    use HasRoles;
    protected $fillable = ['name','email','password','role_id','phone','department','is_employee'];
    public function role(){ return $this->belongsTo(Role::class); }
    public function createdCustomers(){ return $this->hasMany(Customer::class,'created_by'); }
}
