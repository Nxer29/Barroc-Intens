<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    public $timestamps=false;
    protected $fillable=['parent_type','parent_id','filename','url','uploaded_by','uploaded_at'];
}
