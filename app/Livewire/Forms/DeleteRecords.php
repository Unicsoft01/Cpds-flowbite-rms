<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class DeleteRecords extends Form
{

    public function DeleteRecord($Model, $id)
    {
        $record = $Model::find($id);
        $record->delete();
    }

    public function Swal(){
        return 
            [
                  'title' => 'Great!',
                  'message' => 'Record Deleted successfully',
                  'icon' => 'success'
            ]; 
    }
}