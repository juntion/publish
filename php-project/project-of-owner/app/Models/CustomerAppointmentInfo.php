<?php

namespace App\Models;

class CustomerAppointmentInfo extends BaseModel
{
    protected $table = 'customer_appointment_info';
    protected $primaryKey = 'id';

    public function caseNumbers()
    {
        return $this->hasOne('App\Models\CaseNumber', 'case_number', 'case_number');
    }
}
