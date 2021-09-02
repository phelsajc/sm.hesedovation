<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Groups;
use App\GroupMembers;
use Auth;

//use App\Cart;
//use App\Coupon;
//use App\Wishlist;
use App\Order;
//use App\Currency;
use Mail;
use App\Mail\SendOrderMail;
use App\Notifications\UserEnroll;
use App\Course;
use App\User;
use Notification;
use Carbon\Carbon;
use App\InstructorSetting;
use App\PendingPayout;
use Illuminate\Support\Facades\Log;


class GroupsController extends Controller
{
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Manila');
        $c = new Groups;
        $c->name = $request->name;
        $c->description = $request->description;
        $c->created_by = Auth::user()->id;
        $c->course_id = $request->course_id;
        $c->created_dt = date("Y-m-d H:i");
        $c->save();
        echo $c->id;      
    }

    public function update(Request $request)
    {    
        Groups::where(['id' => $request->group_id])->update([
            'name' => $request->name,        
            'description' => $request->description, 
        ]);
        echo $request->group_id;
    }

    public function show($id)
    {    
        $data = Groups::where(['id' => $id])->first();
        echo $data;        
    }

    public function add_member(Request $request)
    {
        foreach ($request->user_grp_rquest as $key => $value) {
            $val = explode("#", $value);
            $data = GroupMembers::where(['user_id' => $val[0],'course_id' => $request->course])->first();
            if(!$data){
                $c = new GroupMembers;
                $c->type = $val[1];
                $c->grp_id = $request->grp;
                $c->user_id = $val[0];
                $c->course_id = $request->course;
                $c->save(); 
                $this->enrollToCourse($request->course,$val[0]);
            }
        }
        echo true;
      // echo $this->enrollToCourse($request->course);
    }

    private function enrollToCourse($course_id,$user_id)
    {
        $newOrderId = $this->getNextOrderId();
        $course_detail = Course::where(['id' => $course_id])->first();
        $created_order = Order::create([
            'course_id' => $course_id,
            'user_id' => $user_id,
            'instructor_id' =>  $course_detail->user_id,
            'order_id' => $newOrderId,
            'transaction_id' => $newOrderId, // its enroll
            'payment_method' => 'Group Enroll',//free or automatic enroll
            'total_amount' => 0.00,
            'coupon_discount' => 0,
            'currency' => 'PHP',
            'currency_icon' => "fa fa-pula",
            'duration' => $course_detail->duration,
            'enroll_start' => NULL,
            'enroll_expire' => NULL,
            'bundle_id' =>  NULL,
            'bundle_course_id' => NULL,
            'created_at'  => date("Y-m-d"),
        ]);

        /*sending email*/
        try {

            $x = 'You are successfully enrolled in a course';
            $order = $created_order;
            Mail::to(Auth::User()->email)->send(new SendOrderMail($x, $order));
        } catch (\Swift_TransportException $e) {
            
        }
        
        // Notification when user enroll
        $course = [
            'title' =>  $course_detail->title,
            'image' =>  $course_detail->preview_image,
        ];
        $enroll = Order::where('course_id', $course_detail->id)->get();

        if (!$enroll->isEmpty()) {
            foreach ($enroll as $enrol) {
                $user = User::where('id', $enrol->user_id)->get();
                Notification::send($user, new UserEnroll($course));
            }
        }
        return true;
    }

    private function getNextOrderId()
    {
        $lastOrder = Order::orderBy('created_at', 'desc')->first();

        if (!$lastOrder) {
            // We get here if there is no order at all
            // If there is no number set it to 0, which will be 1 at the end.
            $number = 0;
        } else {
            $number = substr($lastOrder->order_id, 3);
        }

        $orderId = '#' . sprintf("%08d", intval($number) + 1);

        Log::debug('created new order id : ' . $orderId);

        return $orderId;
    }

}
