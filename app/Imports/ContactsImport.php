<?php

namespace App\Imports;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['name']) || !isset($row['phone_number'])) {
            throw new \Exception('Kolom "name" dan "phone_number" tidak ditemukan'); 
        }

        $existingContact = Contact::where('phone_number', $row['phone_number'])->first();
    
        if ($existingContact) {
            return null;
        }

        return new Contact([
            'name'         => $row['name'],
            'phone_number' => $row['phone_number'],
            'user_id' => Auth::id()
        ]);
    }
}
