<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Illuminate\Support\Str;
use Livewire\Form;

class Helpers extends Form
{
    public function fullName($surName, $middleName = '', $firstName)
    {
        $fname = $surName . " " . $middleName . " " . $firstName;
        return ucwords($fname);
    }
    
}