<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departements';
    protected $fillable = [
        'name',
        'semester',
        'cost',
    ];

    /**
     * Get the students associated with the department.
     */
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    /**
     * Get the transactions associated with the department.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
