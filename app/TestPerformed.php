<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestPerformed extends Model
{
    public $table = 'test_performeds';

    protected $fillable = [
        'available_test_id',
        'patient_id',
        'start_time',
        'state',
        'testResult',
      
    ];
     public function pat()
     {
         return $this->hasMany(Patient::class);

     }
     public function avail()
     {
         return $this->hasMany(AvailableTest::class);
     }
     public function av()
     {
         return $this->hasOne(Catagory::class);
     }
}
