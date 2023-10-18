<?php

namespace App\Services;

class LeadScoringService
{
    public function getLeadScore ($lead)
    {
     return rand(1, 10);   
    }
}