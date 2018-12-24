<?php

namespace App\Http\Controllers\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    //
    public function storeContact(Request $request){
        try{
            if($request){
                /**store topic content images to DB. */
                DB::insert('insert into contact (name, email, tel, address, longitude,latitude,topic,description) values (?, ?, ?, ?, ?, ?, ? ,?)', 
                [   $request->input('company') ,
                    $request->input('email'), 
                    $request->input('tel'), 
                    $request->input('address'),
                    $request->input('longitude'),
                    $request->input('latitude'),
                    $request->input('topic'),
                    $request->input('description')]);
    
                return redirect('/management')->with('status', 'create contact successfully');
            }
        }catch(Exception $e){
            return redirect('contact/create')->with('error', 'these was a probleam create contact');
        }        
    }
    //
    public function selectContact(){
        $contact = DB::select('select * from contact');
        return response()->json($contact);
    }
    //
    public function viewsContact(){        
        return view('pages.management.contact.contact');
    }
    //
    public function editContact(Request $request, $id){
        $contact = DB::select('select * from contact where id = ? Order by create_at DESC', [$id]);
        return view('pages.management.contact.editcontact')->with(['contacts' =>  $contact]);
    }
    //
    public function updateContact(Request $request, $id){
        try{
            if($request){
                /**store topic content images to DB. */
                DB::update('update contact set name = ?, email = ?, tel = ?, address = ?, longitude = ?,latitude = ? ,topic = ?,description =? ', 
                [   $request->input('company') ,
                    $request->input('email'), 
                    $request->input('tel'), 
                    $request->input('address'),
                    $request->input('longitude'),
                    $request->input('latitude'),
                    $request->input('topic'),
                    $request->input('description')]);
    
                return redirect('/management')->with('status', 'update contact successfully');
            }
        }catch(Exception $e){
            return redirect('contact/eidt/'.$id)->with('error', 'these was a probleam update contact');
        }        
    }
    public function deleteContact(Request $request, $id){
        try{
            if($id){
                /**store topic content images to DB. */
                DB::update('delete from contact where id = ? ',[$id]);
                session()->flash('status', 'delete contact successfully!');
                return response()->json(['status' => 'delete contact successfully!']);
                //return redirect('/management')->with('status', 'delete contact successfully');
            }
        }catch(Exception $e){
            //return redirect('/management')->with('error', 'these was a probleam update contact');
            session()->flash('error', 'these was a probleam update contact!');
            return response()->json(['error' => 'these was a probleam update contact!']);
        }        
    }
}