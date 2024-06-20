<?php

namespace App\Services;

use Illuminate\Http\Request;

use Swift_Mailer;
use Mail;

class SendMail
{
    	
    public static function send($to,$sujet,$contenu)
    {

        $swiftTransport =  new \Swift_SmtpTransport( env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION')); 
        $swiftTransport->setUsername( env('MAIL_USERNAME')); //adresse email
        $swiftTransport->setPassword( env('MAIL_PASSWORD')); // mot de passe email

        $swiftMailer = new Swift_Mailer($swiftTransport);
        Mail::setSwiftMailer($swiftMailer);
        $from= env('MAIL_FROM_ADDRESS');
        $fromname= env('MAIL_FROM_NAME'); 

        Mail::send([], [], function ($message) use ($to,$sujet, $contenu,$from,$fromname   ) {
                $message
                  ->to($to)
                //->bcc($chunk ?: [])
                    ->subject($sujet)
                       ->setBody($contenu, 'text/html')
                    ->setFrom([$from => $fromname]);         

        });
    }


    public static function send_pdf($to,$sujet,$contenu,$id)
    {
        try{
            $swiftTransport =  new \Swift_SmtpTransport( env('MAIL_HOST'), env('MAIL_PORT'), env('MAIL_ENCRYPTION')); 
            $swiftTransport->setUsername( env('MAIL_USERNAME')); //adresse email
            $swiftTransport->setPassword( env('MAIL_PASSWORD')); // mot de passe email

            $swiftMailer = new Swift_Mailer($swiftTransport);
            Mail::setSwiftMailer($swiftMailer);
            $from= env('MAIL_FROM_ADDRESS');
            $fromname= env('MAIL_FROM_NAME'); 

            Mail::send([], [], function ($message) use ($to,$sujet, $contenu,$from,$fromname,$id   ) {
                    $message
                    ->to($to)
                        ->subject($sujet)
                        ->setBody($contenu, 'text/html')
                        ->setFrom([$from => $fromname]);
                        
                $fullpath=storage_path().'\pdf\facture-'.$id.'.pdf';
                $name=basename($fullpath);
                $mime_content_type=mime_content_type ($fullpath);
        
                $message->attach($fullpath, array(
                        'as' => $name, // If you want you can chnage original name to custom name
                        'mime' => $mime_content_type)
                );

            });

            //return redirect()->route('invoices.index')
            //->with('success','Facture envoyée !');
            
        }catch(\Exception $e){           
            return redirect()->route('invoices.index');
        }


/*
        $from= 
        $fromname= 
        $data=array();
        $data["email"] = $to;
        $data["title"] = $sujet;
        $data["body"] = $contenu;;
        $data["from"] = env('MAIL_FROM_ADDRESS');
        $data["fromname"] = env('MAIL_FROM_NAME'); ;
   
        Mail::send([], $data, function($message)use($data, $pdf) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"])
                    ->setFrom([ $data["from"]=>  $data["fromname"]])
                    ->attach($pdf->output(), "facture.pdf");
        });
        */
    }
	
}