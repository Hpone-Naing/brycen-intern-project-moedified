<?php

namespace App\Http\Controllers;
use App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller {
   public function basic_email() {
      $data = array('name'=>"ဂုတ်မွန်ကြိ");
   
      Mail::send(['text'=>'mail'], $data, function($message) {
         $message->to('phlar1211@gmail.com', 'Tutorials Point')->subject
            ('Laravel Basic Testing Mail');
         $message->from('hponenaingtun@gmail.com','Hpone Naing Tun');
      });
      echo "Basic Email Sent. Check your inbox.";
   }
   public function html_email() {
      $data = array('name'=>"ဂုတ်မွန်ကြိ");
      Mail::send('mail', $data, function($message) {
         $message->to('eimonkyaw5521@gmail.com', 'Tutorials Point')->subject
            ('Laravel HTML Testing Mail');
         $message->from('hponenaingtun@gmail.com','Hpone Naing Tun');
      });
      echo "HTML Email Sent. Check your inbox.";
   }
   public function attachment_email() {
      $data = array('name'=>"ဂုတ်မွန်ကြိ");
      Mail::send('mail', $data, function($message) {
         $message->to('phlar1211@gmail.com', 'Tutorials Point')->subject
            ('Laravel Testing Mail with Attachment');
         $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
         $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
         $message->from('hponenaingtun@gmail.com','Hpone Naing Tun');
      });
      echo "Email Sent with attachment. Check your inbox.";
   }
}

