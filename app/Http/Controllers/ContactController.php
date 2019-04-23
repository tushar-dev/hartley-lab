<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Contact;
use App\ContactUser;
use Session;
use JeroenDesloovere\VCard\VCard;

class ContactController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {

        return view('contact.list');
    }

    public function getAjaxContacts() {

        $user_id = Auth::User()->id;
        $all_contacts = ContactUser::where(['user_id' => $user_id, 'is_shared' => '0'])->get();
                
        return Datatables::of($all_contacts)
             
                
                ->addColumn('first_name', function($regsiter_user){
                     return $regsiter_user->contact->first_name;
                })
                ->addColumn('middle_name', function($regsiter_user){
                     return $regsiter_user->contact->middle_name;
                })
                ->addColumn('last_name', function($regsiter_user){
                     return $regsiter_user->contact->last_name;
                })
                
               ->addColumn('primary_phone_no', function($regsiter_user){
                     return $regsiter_user->contact->primary_phone_no;
                })
               ->addColumn('secondary_phone_no', function($regsiter_user){
                     return $regsiter_user->contact->secondary_phone_no;
                })
              ->addColumn('email', function($regsiter_user){
                     return $regsiter_user->contact->email;
                })
                ->make(true);
    }

    public function createNewContact() {
        return view('contact.add');
    }

    public function saveNewContact(Request $request) {

        $user_id = Auth::user()->id;

        //validate data
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:contacts,email',
            'primary_phone_no' => 'required|digits:10|unique:contacts,primary_phone_no',
            'secondary_phone_no' => 'unique:contacts,secondary_phone_no|nullable',
        ]);
        $image_name = '';
        if (Input::hasFile('contact_image')) {
            $file = Input::file('contact_image');
            $image_name = $file->getClientOriginalName();
            $file->move(storage_path('images'), $image_name);
        }
        $arr_insert = array('first_name' => $_POST['first_name'],
            'middle_name' => $_POST['middle_name'],
            'last_name' => $_POST['last_name'],
            'primary_phone_no' => $_POST['primary_phone_no'],
            'secondary_phone_no' => $_POST['secondary_phone_no'],
            'email' => $_POST['email'],
            'contact_image' => $image_name
        );
        
        $contact = Contact::create($arr_insert);
        
        $arr_contact_user = new ContactUser();
        $arr_contact_user->user_id = $user_id;
        $arr_contact_user->contact_id = $contact->id;
        $arr_contact_user->is_shared = '0';
        $arr_contact_user->save();

        //store status message
        Session::flash('success_msg', 'Contact details has been added successfully!');
        return redirect()->route('contact.index');
    }

    public function editContact($id) {
        $id = base64_decode($id);

        $contact_detail = Contact::find($id);
        return view('contact.edit', ['contact_detail' => $contact_detail]);
    }

    public function updateContact($id, Request $request) {
        
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:contacts,email,' . $id,
            'primary_phone_no' => 'required|digits:10|unique:contacts,primary_phone_no,' . $id,
            'secondary_phone_no' => 'nullable|unique:contacts,secondary_phone_no,' . $id,
        ]);

        if (Input::hasFile('contact_image')) {
            
            $file = Input::file('contact_image');
            $image_name = $file->getClientOriginalName();
            $file->move(storage_path('images'), $image_name);
            
        } else {
            $image_name = $_POST['old_contact_image'];
        }
        $contact_detail = Contact::find($id);
        $contact_detail->first_name = $request->first_name;
        $contact_detail->middle_name = $request->middle_name;
        $contact_detail->last_name = $request->last_name;
        $contact_detail->primary_phone_no = $request->primary_phone_no;
        $contact_detail->secondary_phone_no = $request->secondary_phone_no;
        $contact_detail->contact_image = $image_name;
        $contact_detail->save();
        
        //store status message
        Session::flash('success_msg', 'Contact details has been updated successfully!');

        return redirect()->route('contact.index');
    }
    public function details($id) {
        $id = base64_decode($id);
        $contact_detail = Contact::find($id);
        return view('contact.details', ['contact_detail' => $contact_detail]);
    }
    
    
    public function userList(Request $request) {
        $id = $request->id;
        $user_id = Auth::user()->id;
        $existing_shares = ContactUser::select('user_id')->where('contact_id', $id)->pluck('user_id')->toArray();
        
        $arr_all_users = \App\User::select('name','id')->orderBy('name','ASC')->where('id','!=', $user_id)->get();
        
        $arr_filtered = $arr_all_users->reject(function ($user) use($existing_shares) {
            return in_array($user->id, $existing_shares) ;
        });
        
        $output = [];
        $str = '';
        foreach($arr_filtered as $user){
           $output[] = ['user_id'=>$user->id, 'name'=>$user->name]; 
        }
        return $output;
    }
    public function contactShareUpdate(Request $request) {
        $contact_id = $request->contact_id;
        $user_ids = $request->share_to_users;
        $data = array();
        foreach($user_ids as $id){
            $data[] = array('user_id'=>$id,'contact_id' => $contact_id, 'is_shared' => '1');
        }
        if(count($data)>0){
            ContactUser::insert($data);
            echo 'Contact has been shared successfully!';
        }else{
            echo 'Contact not shared!';
        }
        
    }
    
    public function sharedContact() {

        return view('contact.shared-list');
    }

    public function getAjaxSharedContacts() {

        $user_id = Auth::User()->id;
        $all_contacts = ContactUser::where(['user_id' => $user_id, 'is_shared' => '1'])->get();
                
        return Datatables::of($all_contacts)
                
                ->addColumn('first_name', function($regsiter_user){
                     return $regsiter_user->contact->first_name;
                })
                ->addColumn('middle_name', function($regsiter_user){
                     return $regsiter_user->contact->middle_name;
                })
                ->addColumn('last_name', function($regsiter_user){
                     return $regsiter_user->contact->last_name;
                })
                
               ->addColumn('primary_phone_no', function($regsiter_user){
                     return $regsiter_user->contact->primary_phone_no;
                })
               ->addColumn('secondary_phone_no', function($regsiter_user){
                     return $regsiter_user->contact->secondary_phone_no;
                })
              ->addColumn('email', function($regsiter_user){
                     return $regsiter_user->contact->email;
                })
                ->make(true);
    }
    
    public function sharedDetails($id) {
        $id = base64_decode($id);
        $contact_detail = Contact::find($id);
        return view('contact.shared-details', ['contact_detail' => $contact_detail]);
    }
    
    public function delete(Request $request) {
        $contact_detail = Contact::find($request->id);

        if($contact_detail->delete())
        {   
            echo 'Contact has been deleted successfully!';
        }
    }
    
    public function vCard() {
        $user_id = Auth::user()->id;
        $contacts = ContactUser::where('user_id', $user_id)->get();
        return view('contact.vcard', ['contacts' => $contacts]);
    }
    
    public function downloadVCard(Request $request){
        $contact_users = $request->contact_users;
        if($contact_users!=''){
            $contacts = Contact::whereIn('id', $contact_users)->get();
            $str_contacts = "";
            foreach($contacts as $contact){
                $vcard = new VCard();
                $vcard->addName($contact->last_name, $contact->first_name, $contact->middle_name, "", "");

                // add work data

                $vcard->addEmail($contact->email);
                $vcard->addPhoneNumber($contact->primary_phone_no, 'PREF;WORK');
                $vcard->addPhoneNumber($contact->secondary_phone_no, 'WORK');
//                $vcard->addPhoto(asset('storage/images/'.$contact->contact_image) );
                $str_contacts .= $vcard->getOutput();
            }
            $unique_file_name = time();
            \Storage::disk('local')->put($unique_file_name.'.vcf', $str_contacts);
            return response()->download(storage_path("app/".$unique_file_name.".vcf"), 'contacts.vcf');

        }else{
            return redirect()->route('vcard');
        }
    }

}
