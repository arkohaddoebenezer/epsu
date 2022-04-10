<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Gitplus\Arkesel as Sms;
use App\Http\Resources\MessageResource;
use App\Mail\BulkEMail;
use App\Mail\InstructorsMail;
use App\Mail\SingleEmail;
use App\Mail\StudentsMail;
use App\Models\Chapter;
use App\Models\Congregation;
use App\Models\Instructor;
use App\Models\Member;
use App\Models\Members;
use App\Models\Messages;
use App\Models\Package;
use App\Models\Presbytery;
use App\Models\Profession;
use App\Models\ProfessionalGroup;
use App\Models\Promotion;
use App\Models\Student;
use App\Models\StudentRegistration;
use App\Models\User;
use App\Models\Zone;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{

    public function sendSingleSms(Request $request)
    {

        // return $request->all();
        $validator = Validator::make($request->all(), [
            "notificationBody" => "required",
            "notificationType" => "required",
            "recipient" => "required",
        ], [
            "notificationBody.required" => "Sms body cannot be empty",
            "notificationType.required" => "Please select sms type",
            "recipient.required" => "Please select the recipient of this message",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => join(" ", $validator->errors()->all()),
            ]);
        }


        $member = Members::find($request->recipient);


        if (!empty($member->phone)) {
            $sms = new Sms("EPSU", env("ARKESEL_SMS_API_KEY"));
            $response = $sms->send($member->phone, $request->notificationBody);

            Messages::create([
                "recipients" => $member->title . ' ' . $member->fname . ' ' . $member->mname . ' ' . $member->lname,
                "type" => $request->notificationType,
                "details" => $request->notificationBody,
                "createuser" => $request->createuser,
            ]);

            return response()->json([
                "ok" => true,
                "msg" => "Response from Arkesel",
                "data" => $response, $member->phone
            ]);
        }
    }

    public function sendSingleEmail(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "emailType" => "required",
            "recipient" => "required",
            "subject" => "required",

        ], [
            "subject.required" => "Email subject cannot be null",
            "email.required" => "Email body cannot be empty",
            "emailType.required" => "Please select email type",
            "recipient.required" => "Please select recipient of this message",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Sending email failed." . join(". ", $validator->errors()->all()),
            ]);
        }

        try {
            $member = Members::find($request->recipient);;
            if (!empty($member->email)) {
                Mail::to($member->email)->send(new SingleEmail([
                    "subject" => $request->subject,
                    "body" => $request->email,
                ]));
            }

            DB::table("tblmessage")->insert([
                "recipients" => $member->title . ' ' . $member->fname . ' ' . $member->mname . ' ' . $member->lname,
                "type" => $request->emailType,
                "details" => $request->email,
                "subject" => $request->subject,
                "createuser" => $request->createuser,
            ]);
            return response()->json([
                "ok" => true,
                "msg" => "Email has been sent"
            ]);
        } catch (\Throwable $e) {
            Log::error("Failed sending single email: " . $e->getMessage());
            return response()->json([
                "ok" => false,
                "msg" => "Sending single email failed",
                "error" => [
                    "msg" => $e->__toString(),
                    "err_msg" => $e->getMessage(),
                    "fix" => "Please complete all required fields",
                ]
            ]);
        }
    }
    
    // public function sendbulksms(Request $request)
    // {

    //     $validator = Validator::make($request->all(), [
    //         "notificationBody" => "required",
    //         "notificationType" => "required",
    //         "recipient" => "required",
    //     ],[
    //         "notificationBody.required" => "Sms body cannot be empty",
    //         "notificationType.required" => "Please select sms type",
    //         "recipient.required" => "Please select the recipient of this message",

    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             "ok" => false,
    //             "msg" => join(" ", $validator->errors()->all()),
    //         ]);
    //     }


    //             $smsRecipients = User::select("phone")
    //                 ->where('prof_code',$request->recipient)
    //                 ->where("deleted", "0")
    //                 ->get();

    //             $professionCount = count($smsRecipients);
    //             $sms = new Sms("MMRA", env("ARKESEL_SMS_API_KEY"));
    //             foreach ($smsRecipients as $key => $smsRecipient) {
    //                 $recipients[] = $smsRecipient->phone;
    //                 $numbers = join(",", $recipients);
    //                 if (count($recipients) === 100 || ($key + 1 === $professionCount)) {
    //                     $responses = $sms->send($numbers, $request->notificationBody);
    //                     $recipients = [];
    //                 }
    //             }

    //             $profession = ProfessionalGroup::where('prof_code',$request->recipient)->where('deleted',"0")->first();

    //             DB::table("tblmessage")->insert([
    //                 "transid" => 'Trans'.strtoupper(bin2hex(random_bytes(5))),
    //                 "recipients" => $profession->prof_desc,
    //                 "type" => $request->notificationType,
    //                 "details" => $request->notificationBody,
    //                 "deleted" => "0",
    //                 "createuser" => "admin",
    //                 "createdate" => date("Y-m-d"),
    //             ]);

    //             return response()->json([
    //                 "ok" => true,
    //                 "msg" => "Response from Arkesel",
    //                 "data" => [
    //                     "responses" => $responses,
    //                 ]
    //             ]);



    // }


    public function sentsingleSms()
    {

        $sms = Messages::where("deleted", 0)->where('type', 'single-sms')->orderByDesc("createdate")->get();

        return response()->json([
            "data" => MessageResource::collection($sms)
        ]);
    }

    public function sentbulkSms()
    {

        $sms = Messages::where("deleted", 0)->where('type', 'bulk-sms')->orderByDesc("createdate")->get();

        return response()->json([
            "data" => MessageResource::collection($sms)
        ]);
    }

    public function sentBulkEmail()
    {

        $sms = Messages::where("deleted", 0)->where('type', 'bulk-email')->orderByDesc("createdate")->get();

        return response()->json([
            "data" => MessageResource::collection($sms)
        ]);
    }

    public function sentSingleEmail()
    {

        $sms = Messages::where("deleted", 0)->where('type', 'single-email')->orderByDesc("createdate")->get();

        return response()->json([
            "data" => MessageResource::collection($sms)
        ]);
    }



    public function sendBulkEmail(Request $request)
    {

        // return $request->all();
        $validator = Validator::make($request->all(), [
            "email" => "required",
            "emailType" => "required",
            // "recipient" => "required",
            "subject" => "required",
            "recipientGroup" => "required",


        ], [
            "subject.required" => " Email subject cannot be null",
            "email.required" => "Email body cannot be empty",
            "emailType.required" => "Please select email type",
            // "recipient.required" => "Please select recipient of this message",
            "recipientGroup.required" => "Please select the recipient group of this message",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => "Sending email failed." . join(". ", $validator->errors()->all()),
            ]);
        }


        switch (strtolower($request->recipientGroup)) {
            case "chapter":
                $members = Member::select("email")
                    ->where("deleted", "0")
                    ->where('chapter', $request->recipientSelection1)
                    ->whereNotNull("email")
                    ->get();

                foreach ($members as $member) {
                    if (!empty($member->email)) {

                        $recipients[] = $member->email;
                    }
                }

                if (!empty($recipients)) {

                    Mail::to($recipients)->send(new BulkEMail([
                        "subject" => $request->subject,
                        "body" => $request->email,
                    ]));
                }

                $chapter = Chapter::where('code', $request->recipientSelection1)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $chapter->desc,
                    "type" => $request->emailType,
                    "details" => $request->email,
                    "subject" => $request->subject,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Email has been sent"
                ]);



                break;

            case "presbytery":
                $members = Member::select("email")
                    ->where("deleted", "0")
                    ->where('presbytery', $request->recipientSelection2)
                    ->whereNotNull("email")
                    ->get();

                foreach ($members as $member) {
                    if (!empty($member->email)) {

                        $recipients[] = $member->email;
                    }
                }

                if (!empty($recipients)) {

                    Mail::to($recipients)->send(new BulkEMail([
                        "subject" => $request->subject,
                        "body" => $request->email,
                    ]));
                }

                $presbytery = Presbytery::where('pres_code', $request->recipientSelection2)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $presbytery->pres_desc,
                    "type" => $request->emailType,
                    "details" => $request->email,
                    "subject" => $request->subject,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Email has been sent"

                ]);


                break;

            case "zone":
                $members = Member::select("email")
                    ->where("deleted", "0")
                    ->where('zone', $request->recipientSelection3)
                    ->whereNotNull("email")
                    ->get();

                foreach ($members as $member) {
                    if (!empty($member->email)) {

                        $recipients[] = $member->email;
                    }
                }

                if (!empty($recipients)) {

                    Mail::to($recipients)->send(new BulkEMail([
                        "subject" => $request->subject,
                        "body" => $request->email,
                    ]));
                }


                $zone = Zone::where('code', $request->recipientSelection3)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $zone->desc,
                    "type" => $request->emailType,
                    "details" => $request->email,
                    "subject" => $request->subject,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Email has been sent"

                ]);


                break;

            case "congregation":
                $members = Member::select("email")
                    ->where("deleted", "0")
                    ->where('congregation', $request->recipientSelection3)
                    ->whereNotNull("email")
                    ->get();

                foreach ($members as $member) {
                    if (!empty($member->email)) {

                        $recipients[] = $member->email;
                    }
                }

                if (!empty($recipients)) {

                    Mail::to($recipients)->send(new BulkEMail([
                        "subject" => $request->subject,
                        "body" => $request->email,
                    ]));
                }

                $congregation = Congregation::where('cong_ode', $request->recipientSelection4)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $congregation->cong_desc,
                    "type" => $request->emailType,
                    "details" => $request->email,
                    "subject" => $request->subject,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Email has been sent"

                ]);


                break;
        }
    }






    public function sendDueNoticeSms(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => "required",
            "number" => "required",
            "package" => "required",
            "days" => "required",
        ], [
            "name.required" => "Name of recipient not provided",
            "number.required" => "No recipient found",
            "package.required" => "No package found",
            "days.required" => "Days to expiry unknown",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => join(" ", $validator->errors()->all()),
            ]);
        }

        // $package = Package::where("pack_code", $request->package)
        // ->where('deleted', '0')
        // ->first();

        // return $package;
        $user = User::where('phone', $request->number)->where('deleted', "0")->first();


        // return $user;
        // return $request->all();
        // $message = "Hello {$user->fname} {$user->mname} {$user->lname}, your {$package->pack_desc} expires in {$request->days}.Kindly renew your subscirption to enjoy more amazing benefits";

        // if (!empty($user->phone)) {

        //     $sms = new Sms("MMRA", env("ARKESEL_SMS_API_KEY"));
        //     $response = $sms->send($user->phone, $message);



        //     return response()->json([
        //         "ok" => true,
        //         "msg" => "Response from Arkesel",
        //         "data" => $response,
        //     ]);
        // }

    }



    public function sendbulksms(Request $request)
    {

        // return $request->all();
        $validator = Validator::make($request->all(), [
            "notificationBody" => "required",
            "notificationType" => "required",
            // "recipient-selection" => "required",
            "recipientGroup" => "required",
        ], [
            "notificationBody.required" => "Sms body cannot be empty",
            "notificationType.required" => "Please select sms type",
            // "recipient-selection.required" => "Please provide a corresponding option for the recipient selected",
            "recipientGroup.required" => "Please select the recipient group of this message",

        ]);

        if ($validator->fails()) {
            return response()->json([
                "ok" => false,
                "msg" => join(" ", $validator->errors()->all()),
            ]);
        }


        $recipients = [];
        switch (strtolower($request->recipientGroup)) {
            case "chapter":
                $members = Member::select("phone")
                    ->where("deleted", "0")
                    ->where('chapter', $request->recipientSelection1)
                    ->whereNotNull("phone")
                    ->get();


                $membersCount = count($members);
                // return $membersCount;

                $sms = new Sms('GESAM', env("ARKESEL_SMS_API_KEY"));
                foreach ($members as $key => $member) {
                    $recipients[] = $member->phone;
                    $numbers = join(",", $recipients);
                    if (count($recipients) === 100 || ($key + 1 === $membersCount)) {
                        $responses = $sms->send($numbers, $request->notificationBody);
                        $recipients = [];
                    }
                }

                // $profession = Member::where('prof_code',$request->recipient)->where('deleted',"0")->first();
                $chapter = Chapter::where('code', $request->recipientSelection1)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $chapter->desc,
                    "type" => $request->notificationType,
                    "details" => $request->notificationBody,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Response from Arkesel",
                    "data" => [
                        "responses" => $responses, $numbers
                    ]
                ]);


                break;

            case "presbytery":
                $members = Member::select("phone")
                    ->where("deleted", "0")
                    ->where('presbytery', $request->recipientSelection2)
                    ->whereNotNull("phone")
                    ->get();

                $membersCount = count($members);
                $sms = new Sms('GESAM', env("ARKESEL_SMS_API_KEY"));
                foreach ($members as $key => $member) {
                    $recipients[] = $member->mobile_phone;
                    $numbers = join(",", $recipients);
                    if (count($recipients) === 100 || ($key + 1 === $membersCount)) {
                        $responses = $sms->send($numbers, $request->notificationBody);
                        $recipients = [];
                    }
                }
                $presbytery = Presbytery::where('pres_code', $request->recipientSelection2)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $presbytery->pres_desc,
                    "type" => $request->notificationType,
                    "details" => $request->notificationBody,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Response from Arkesel",
                    "data" => [
                        "responses" => $responses,
                    ]
                ]);


                break;

            case "zone":
                $members = Member::select("phone")
                    ->where("deleted", "0")
                    ->where('zone', $request->recipientSelection3)
                    ->whereNotNull("phone")
                    ->get();

                $membersCount = count($members);
                $sms = new Sms('GESAM', env("ARKESEL_SMS_API_KEY"));
                foreach ($members as $key => $member) {
                    $recipients[] = $member->mobile_phone;
                    $numbers = join(",", $recipients);
                    if (count($recipients) === 100 || ($key + 1 === $membersCount)) {
                        $responses = $sms->send($numbers, $request->notificationBody);
                        $recipients = [];
                    }
                }

                $zone = Zone::where('code', $request->recipientSelection3)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $zone->desc,
                    "type" => $request->notificationType,
                    "details" => $request->notificationBody,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Response from Arkesel",
                    "data" => [
                        "responses" => $responses,
                    ]
                ]);


                break;

            case "congregation":
                $members = Member::select("phone")
                    ->where("deleted", "0")
                    ->where('congregation', $request->recipientSelection4)
                    ->whereNotNull("phone")
                    ->get();

                $membersCount = count($members);
                $sms = new Sms('GESAM', env("ARKESEL_SMS_API_KEY"));
                foreach ($members as $key => $member) {
                    $recipients[] = $member->mobile_phone;
                    $numbers = join(",", $recipients);
                    if (count($recipients) === 100 || ($key + 1 === $membersCount)) {
                        $responses = $sms->send($numbers, $request->notificationBody);
                        $recipients = [];
                    }
                }

                $congregation = Congregation::where('cong_ode', $request->recipientSelection4)->where('deleted', "0")->first();
                DB::table("tblmessage")->insert([
                    "transid" => 'Trans' . strtoupper(bin2hex(random_bytes(5))),
                    "recipients" => $congregation->cong_desc,
                    "type" => $request->notificationType,
                    "details" => $request->notificationBody,
                    "deleted" => "0",
                    "createuser" => "admin",
                    "createdate" => date("Y-m-d"),
                ]);

                return response()->json([
                    "ok" => true,
                    "msg" => "Response from Arkesel",
                    "data" => [
                        "responses" => $responses,
                    ]
                ]);


                break;
        }
    }
}
