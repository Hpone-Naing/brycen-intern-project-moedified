<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ConstantKeys;
use Illuminate\Http\Request;
use App\Services\MailServices;

class MailController extends Controller
{
    use ConstantKeys;
    protected  $mailServices;

    /**
     * Constructor to assign EmployeeInterface
     */
    public function __construct(MailServices $mailServices)
    {
        $this->mailServices = $mailServices;
    }
    public function sendBirthdayWishMail(Request $request)
    {

        $emails = explode(",",  $request->emails);

        $mailServices = $this->mailServices;
        $mailServices->setMailTemplate('mail');
        $mailServices->setMailFrom($this->DEFAULT_EMAIL);
        $mailServices->setSenderName($this->DEFAULT_SENDER_NAME);
        $mailServices->setMailReceiverName($request->birthay_person_name);
        $mailServices->setMailSubject("Happy Birthday! " . $request->birthay_person_name);
        $mailContents = [
            'name' => $request->birthay_person_name,
            'content' => 'A wish for you on your birthday, whatever you ask may you receive, whatever you seek may you find, whatever you wish may it be fulfilled on your birthday and always. Happy birthday!',
        ];
        $mailServices->setmailDatas($mailContents);
        $attachments = ['company/for-employees/birthdaywish.jpg'];
        try {
            $mailServices->sendAttachmentEmail($emails, $attachments);
            return response()->json(
                [
                    "code" => 200,
                    "status" => "success",
                ]
            );
        } catch(Exception $e) {
            return response()->json(
                [
                    "code" => 500,
                    "status" => "error",
                ]
            );
        }
        
    }
}
