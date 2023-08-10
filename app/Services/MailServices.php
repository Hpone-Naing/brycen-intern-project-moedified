<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

/**
 * Send Mail
 *
 * @author  Hpone Naing Htun
 * @create  2023/08/08
 */
class MailServices
{
   public $mailDatas, $mailTo, $mailForm, $mailSubject, $mailTemplate, $senderName, $receiverName;
   public function setmailDatas($mailDatas)
   {
      $this->mailDatas = $mailDatas;
   }

   public function setMailTo($mailTo)
   {
      $this->mailTo = $mailTo;
   }

   public function setMailFrom($mailForm)
   {
      $this->mailForm = $mailForm;
   }

   public function setMailSubject($mailSubject)
   {
      $this->mailSubject = $mailSubject;
   }

   public function setMailTemplate($mailTemplate)
   {
      $this->mailTemplate = $mailTemplate;
   }

   public function setSenderName($senderName)
   {
      $this->senderName = $senderName;
   }

   public function setMailReceiverName($receiverName)
   {
      $this->receiverName = $receiverName;
   }

   /**
    * send reset password mail with plain text format
    * @author HponeNaingTun
    * @create 08/08/2023
    * @return void
    */
   public function sendTextEmail()
   {
      $data = $this->mailDatas;

      Mail::send(['text' => $this->mailTemplate], $data, function ($message) {
         $message->to($this->mailTo, $this->receiverName)->subject($this->mailSubject);
         $message->from($this->mailForm, $this->senderName);
      });
   }

   /**
    * send mail with HTML format
    * @author HponeNaingTun
    * @create 08/08/2023
    * @return void
    */
   public function sendHtmlEmail(array $recipients)
   {
      $data = $this->mailDatas;
      // Mail::send($this->mailTemplate, $data, function ($message) {
      //    $message->to($this->mailTo, $this->receiverName)->subject($this->mailSubject);
      //    $message->from($this->mailForm, $this->senderName);
      // });
      foreach ($recipients as $recipientEmail) {
         Mail::send($this->mailTemplate, $data, function ($message) use ($recipientEmail) {
            $message->to($recipientEmail)->subject($this->mailSubject);
            $message->from($this->mailForm, $this->senderName);
         });
      }
   }

   /**
    * send reset mail with attach files 
    * @author HponeNaingTun
    * @create 08/08/2023
    * @return void
    */
   public function sendAttachmentEmail(array $recipients, array $attachments)
   {
      $data = $this->mailDatas;
      // Mail::send($this->mailTemplate, $data, function ($message) {
      //    $message->to($this->mailTo, $this->receiverName)->subject($this->mailSubject);
      //    $message->attach('C:\laravel-master\laravel\public\uploads\image.png');
      //    $message->attach('C:\laravel-master\laravel\public\uploads\test.txt');
      //    $message->from($this->mailForm, $this->senderName);
      // });
      foreach ($recipients as $recipientEmail) {
         Mail::send($this->mailTemplate, $data, function ($message) use ($recipientEmail, $attachments) {
             $message->to($recipientEmail)->subject($this->mailSubject);
             
             foreach ($attachments as $attachmentPath) {
                 $absolutePath = public_path($attachmentPath);
                 if (file_exists($absolutePath)) {
                     $message->attach($absolutePath);
                 }
             }
             $message->from($this->mailForm, $this->senderName);
         });
     }
   }
}
