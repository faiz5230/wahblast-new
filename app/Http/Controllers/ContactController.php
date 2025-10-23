<?php

namespace App\Http\Controllers;

use App\Imports\ContactsImport;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    public function contacts()
    {
        $contacts = Contact::where('user_id', Auth::id())->get();
        return view('admin.contact.contacts', compact('contacts'));
    }

    public function addContact()
    {
        return view('admin.contact.add-contact');
    }

    public function storeContact(Request $request)
    {
        $this->validate($request, [
            'phone_number' => 'required',
            'name' => 'required'
        ],[
            'phone_number.required' => 'Nomor telepon tidak boleh dikosongkan',
            'name.required' => 'Nama tidak boleh dikosongkan'
        ]);

        $number = $request->phone_number;
        $reg = 62;
        if($number[0] == 0)
        {
            Contact::create([
                'name' => $request->name,
                'phone_number' => $reg.substr($number,1),
                'user_id' => Auth::id()
            ]);
            toast('Contact berhasil disimpan!','success');
        }
        else if($number[0] == 6)
        {
            Contact::create([
                'name' => $request->name,
                'phone_number' => $number,
                'user_id' => Auth::id()
            ]);
            toast('Contact berhasil disimpan!','success');
        }
        else{
            toast('Format nomor nya salah, silahkan cek kembali!','error');
        }
        
        return redirect()->route('admin.contacts');
    }

    public function editContact($id)
    {
        $contact = Contact::find($id); 
        return view('admin.contact.edit-contact', compact('contact'));
    }

    public function updateContact(Request $request,$id)
    {
        $contacts = Contact::find($id);
        $contacts->update($request->all());
        toast('Contact berhasil diperbarui!', 'success');
        return redirect()->route('admin.contacts');
    }

    public function destroyContact($id)
    {
        $contacts = Contact::find($id);
        $contacts->delete();
        toast('Contact berhasil dihapus!','success');
        return redirect()->route('admin.contacts');
    }

    public function importContacts()
    {
        return view('admin.contact.import');
    }

    public function processImportContacts(Request $request)
    {
        // Validasi file yang diupload
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);

        // Menangkap file yang diupload
        $file = $request->file('file');

        try {
            Excel::import(new ContactsImport, $file);

            toast('Berhasil import contacts', 'success');
            return redirect()->route('admin.contacts');
        } catch (\Exception $e) {
            toast($e->getMessage(), 'error');
            return redirect()->route('admin.contacts');
        }
    }

    public function contactsApi(Request $request)
    {
        if(!User::find($request->account_key))
		{
			return response()->json(['message' => 'Gagal mengambil data contact', 'statusCode' => 400], 400);
		}

        $contacts = Contact::select('id','name','phone_number')->where('user_id', $request->account_key)->get();
        return response(['message' => 'Berhasil mendapatkan data kontak', 'data' => $contacts, 'statusCode' => 200], 200);
    }

    public function destroyAllContact() 
    {
        $contacts = Contact::where('user_id', Auth::id());
        if(!$contacts->count())
        {
            toast('Gagal menghapus semua kontak', 'error');
            return redirect()->back();
        }
        $contacts->truncate();
        toast('Semua kontak berhasil dihapus', 'success');
        return redirect()->back();
    }
}
