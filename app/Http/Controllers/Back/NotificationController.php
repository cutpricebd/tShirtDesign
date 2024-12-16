<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use App\Models\Notification\Email;
use App\Models\Notification\Push;
use App\Models\PreUser;
use App\Models\User;
use App\Repositories\MediaRepo;
use App\Repositories\NotificationRepo;
use Illuminate\Http\Request;
use Notification;

class NotificationController extends Controller
{
    // Email
    public function email(){
        $emails = Email::latest('id')->get();

        return view('back.notification.email', compact('emails'));
    }

    public function emailSend(){
        return view('back.notification.emailSend');
    }

    public function emailSendSubmit(Request $request){
        $request->validate([
            // 'customers' => 'required',
            'status' => 'required',
            'subject' => 'required|max:255',
            'body' => 'required',
        ]);

        if(!env('APP_MAIL_STATUS')){
            return redirect()->back()->with('error-alert', 'Send email disabled!');
        }

        // Generate customers, emails and send
        $customers = array();
        $emails = array();

        if($request->status == 'Selected Customer'){
            foreach((array)$request->customers as $customer){
                $user = User::find($customer);
                if($user && $user->email){
                    NotificationRepo::sendEmailToUser($user, $request->subject, $request->body);

                    $customers[] = $user->id;
                    $emails[] = $user->email;
                }
            }
        }elseif($request->status == 'Newsletter Subscribers'){
            $subscribers = NewsletterSubscriber::where('status', 1)->latest('id')->get();

            foreach($subscribers as $subscriber){
                NotificationRepo::sendEmailToUser($subscriber, $request->subject, $request->body);

                $customers[] = $subscriber->id ?? '';
                $emails[] = $subscriber->email;
            }
        }else{
            if($request->status == 'Suspended Customer'){
                $users = User::where('status', 0)->get();
            }elseif($request->status == 'Pending Customer'){
                $users = PreUser::select('email', 'id', 'name')->groupBy('email')->distinct('email')->get();
            }elseif($request->status == 'Active Customer'){
                $users = User::where('status', 1)->get();
            }else{
                $users = User::get();
            }

            foreach($users as $user){
                NotificationRepo::sendEmailToUser($user, $request->subject, $request->body);

                $customers[] = $user->id ?? '';
                $emails[] = $user->email;
            }
        }

        $email = new Email;
        $email->subject = $request->subject;
        $email->body = $request->body;
        $email->customers = json_encode($customers);
        $email->emails = json_encode($emails);
        $email->save();

        return redirect()->back()->with('success-alert', 'Email send successful.');
    }

    public function emailShow(Email $email){
        return view('back.notification.emailShow', compact('email'));
    }
    public function newslatterSubscribers(){
        $subscribers = NewsletterSubscriber::get();

        return view('back.notification.newslatterSubscribers', compact('subscribers'));
    }
    public function deleteNewslatter($id){
        $newslatter = NewsletterSubscriber::findOrFail($id);
        $newslatter->delete();

        return redirect()->back()->with('success-alert', 'Subscriber deleted successful.');
    }

    public function push(){
        $pushes = Push::latest('id')->get();

        return view('back.notification.push', compact('pushes'));
    }
    public function pushSend(Request $request){
        $request->validate([
            'text' => 'required|max:255',
            'url' => 'max:255'
        ]);

        $push = new Push;
        $push->text = $request->text;
        $push->url = $request->url;

        if($request->file('image')){
            $uploaded_file = MediaRepo::upload($request->file('image'));
            $push->image = $uploaded_file['file_name'];
            $push->image_path = $uploaded_file['file_path'];
            $push->media_id = $uploaded_file['media_id'];
        }

        $push->save();

        if($push->image){
            $image = $push->img_paths['large'];
        }else{
            $image = null;
        }

        NotificationRepo::sendOneSignal($push->text, $push->url, $image);

        return redirect()->back()->with('success-alert', 'Push send successful.');
    }
}
