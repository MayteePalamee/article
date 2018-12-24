<?php

namespace App\Http\Controllers\Mail;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;

class MailController extends Controller
{
    /**send mail */
    public function htmlmail(Request $request)
    {
        // Path or name to the blade template to be rendered
        $template_path = 'pages/mail';
        $sendmail = $request->input('contact-email');
        $sendmail = str_replace("\xE2\x80\x8B", "", $sendmail);
        
        try{
            $mail = ['name'=>$request->input('contact-name'),
            'email'=>$request->input('contact-email'),
            'phone'=>$request->input('contact-tel'),
            'content'=>$request->input('contact-message')];
            Mail::send($template_path,  $mail , function($message)use($sendmail) {
                // Set the sender
                $message->from(config('mail.from.address'),'Articale');
                // Set the receiver and subject of the mail.
                $message->to($sendmail ,'Receiver Name')->subject('Articale Email.');   
            });
            session()->flash('mail-success','send email successfully');
        }catch(\Exception $e){
            session()->flash('mail-error','send has a probleam.');
        }        
        return redirect()->route('contact');
    }
}
