<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCetakKtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullName',
        'birthPlace',
        'birthDate',
        'gender',
        'address',
        'rtRw',
        'village',
        'subdistrict',
        'religion',
        'maritalStatus',
        'occupation',
        'citizenship',
        'bloodType',
        'submittedBy',
    ];
}
