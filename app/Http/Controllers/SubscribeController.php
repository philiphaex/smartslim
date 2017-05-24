<?php

namespace App\Http\Controllers;

use App\User;
use App\Role;
use App\Price;
use App\Business;
use App\Payment;
use Mollie\Laravel\Facades\Mollie;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    //
    public function index()
    {
        session()->forget('invoice');
        return view('subscription.subscribe');

    }

    public function subscribe(Request $request)
    {
        $subscription = $request->get('subscription');
        $payment_option = $request->get('checkboxes');

        $subscription_info = Role::find($subscription);
        $price_info = Price::where('role_id','=',$subscription)->first();

        session(['role_id' => $subscription]);


        if ($payment_option == 'invoice'){
            return view('subscription.invoice',[
                'sub'=>$subscription_info,
                'price'=>$price_info,
            ]);
        }
        if ($payment_option == 'bank'){
            return view('subscription.bank',[
                'sub'=>$subscription_info,
                'price'=>$price_info,

            ]);
        }

    }

    public function invoice(Request $request)
    {

        //Attaching role to user
        $user_id=session('user_id');
        $role_id=session('role_id');
        $user = User::where('id', '=', $user_id)->first();
        $test =session('invoice');
        if($test =='created'){
            return redirect('subscribe/success');
        }
        if($test == null){
            $user->attachRole($role_id);
        }
        //Business registration
        $business = new Business;
        $business->user_id = $user_id;
        $business->name = $request->business;
        $business->vat = $request->vat;
        if ($request->paymentconditions == 'on'){
            $business->paymentconditions = true;
        }

        if ($request->address_business == 'on'){
            $business->street = $user->street;
            $business->street_number = $user->street_number;
            $business->street_bus_number = $user->street_bus_number;
            $business->zipcode = $user->zipcode;
        }else{
            $business->street = $request->street;
            $business->street_number = $request->street_number;
            $business->street_bus_number = $request->street_bus_number;
            $business->zipcode = $request->zipcode;
        }
        $business->save();

        $price_info = Price::where('role_id','=',$role_id)->first();
        $price = $price_info->price;

        //payment registratie
        //Amount on invoice
        $amount = $price * $request->frequency;
        //Number of invoices on year basis
        if($price>0){

            $frequency =   12 / $request->frequency;
        }else{
            $frequency = 0;
        }

        $payment = new Payment;
        $payment->user_id = $user_id;
        $payment->payment_option = 'invoice';
        $payment->amount = $amount;
        $payment->frequency = $frequency;
        $payment->status = 0;

        $payment->save();

        $role = Role::find($role_id);


        session(['invoice' => 'created']);
        session(['user' => $user]);
        session(['business' => $business]);
        session(['role' => $role]);
        session(['payment' => $payment]);


            return view('subscription.success', [
                'user'=>$user,
                'business'=>$business,
                'role'=>$role,
                'payment'=>$payment,
            ]);



    }
    public function banktransfer(Request $request){
        //Attaching role to user
        $user_id=session('user_id');
        $role_id=session('role_id');
        $user = User::where('id', '=', $user_id)->first();
        $test =session('online_payment');
        if($test=='success'){
            return redirect('subscribe/success');
        }
        if($test == null){
            $user->attachRole($role_id);
        }
        //Business registration
        $business = new Business;
        $business->user_id = $user_id;
        $business->name = $request->business;
        $business->vat = $request->vat;
        if ($request->paymentconditions == 'on'){
            $business->paymentconditions = true;
        }

        if ($request->address_business == 'on'){
            $business->street = $user->street;
            $business->street_number = $user->street_number;
            $business->street_bus_number = $user->street_bus_number;
            $business->zipcode = $user->zipcode;
        }else{
            $business->street = $request->street;
            $business->street_number = $request->street_number;
            $business->street_bus_number = $request->street_bus_number;
            $business->zipcode = $request->zipcode;
        }
        $business->save();

        $price_info = Price::where('role_id','=',$role_id)->first();
        $price = $price_info->price;

        //payment registratie
        //Amount on invoice

        //Number of invoices on year basis
        $amount = $price * 12;
        $payment = new Payment;
        $payment->user_id = $user_id;
        $payment->payment_option = 'online_payment';
        $payment->amount = $amount;
        $payment->frequency = 1;
        $payment->status = 0;

        $payment->save();

        $role = Role::find($role_id);


        session(['online_payment' => 'created']);
        session(['user' => $user]);
        session(['business' => $business]);
        session(['role' => $role]);
        session(['payment' => $payment]);

       $pay_mollie = Mollie::api()->payments()->create([
            "amount"      => $amount,
            "description" => "Inschrijving SmartSlim",
            "redirectUrl" => 'http://smartslim.dev/subscribe/success',
            "webhookUrl" => url('banktransfer/success'),
        ]);

        $pay_mollie = Mollie::api()->payments()->get($pay_mollie->id);

        if ($pay_mollie->isPaid())
        {
            session(['online_payment' => 'success']);
        }

    /*    return view('subscription.success', [
            'user'=>$user,
            'business'=>$business,
            'role'=>$role,
            'payment'=>$payment,
        ]);*/


    }

    public function finish()
    {

        return view('subscription.success', [
            'user'=>session('user'),
            'business'=>session('business'),
            'role'=>session('role'),
            'payment'=>session('payment'),
            ]);
    }
}
