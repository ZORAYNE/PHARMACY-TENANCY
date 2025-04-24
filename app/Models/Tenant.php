<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Specifying that the primary key is 'id' (default behavior)

    protected $fillable = ['name', 'domain'];

    // Define the relationship to Admin
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    // Optionally define a relationship for users (if applicable)
    public function users()
    {
        return $this->hasMany(User::class);
    }
}

