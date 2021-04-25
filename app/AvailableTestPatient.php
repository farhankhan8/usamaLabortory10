<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvailableTestPatient extends Model
{
    
    public $table = 'available_test_patients';

    protected $fillable = [
        'available_test_id',
        'patient_id',
        'start_time',
        'state',
        'testResult',
      
    ];
     public function patients()
     {
         return $this->belongsTo(Patient::class);

     }
     public function available_tests()
     {
         return $this->belongsTo(AvailableTest::class);
     }
    //  public function av()
    //  {
    //      return $this->hasOne(Catagory::class);
    //  }
}
