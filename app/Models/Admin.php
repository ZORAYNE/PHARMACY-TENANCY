<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'tenant_id', 'status'];

    // Define the relationship to Tenant
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    
}
