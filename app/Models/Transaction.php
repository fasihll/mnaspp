<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    protected $table = 'transactions';
    protected $fillable = [
        'student_id',
        'departement_id',
        'transaction_type',
        'status',
        'bukti',
    ];

    /**
     * Get the student associated with the transaction.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the department associated with the transaction.
     */
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
}
