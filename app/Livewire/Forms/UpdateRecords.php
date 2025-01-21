<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateRecords extends Form
{
    
    public function ApplyUpdate($record)
    {
        $record->update($this->all());
    }

    public function Swal(){
        return 
            [
                  'title' => 'Great!',
                  'message' => 'Record Updated successfully!',
                  'icon' => 'success'
            ]; 
    }
}