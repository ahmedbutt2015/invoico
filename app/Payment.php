<?php

namespace App;

use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Payment extends Model
{
    protected $primaryKey = "id";
    protected $table = "payment_histories";
    protected $guarded = [];
    public static function AddPayment($data, $user_id)
    {
        return self::create([
            "user_id" => $user_id,
            "amount" => $data['amount'],
            "card_number" => $data['card_number'],
            "cvc" => $data["cvc"],
            "month" => $data['month'],
            "year" => $data['year'],
        ]);
    }

    public static function payStripe($data, $amount, $description, $onSuccess)
    {

        $stripe = Stripe::setApiKey(env('STRIPE_SECRET'));
        try {
            $token = $stripe->tokens()->create([
                'card' => [
                    'number' => $data['card'],
                    'cvc' => $data['cvc'],
                    'exp_month' => $data['month'],
                    'exp_year' => $data['year'],
                ],
            ]);


            if (!isset($token['id'])) {
                return ["type" => "error", "msg" => "Not Paid"];
            }


            $charge = $stripe->charges()->create([
                'card' => $token['id'],
                'currency' => "USD",
                'amount' => $amount,
                'description' => $description,
            ]);

            if ($charge['status'] == 'succeeded') {
                $token = call_user_func($onSuccess);
                return ["type" => "paid","token"=>$token];
            } else {
                return ["type" => "error", "msg" => "Not Paid"];
            }
        } catch (Exception $e) {
            return ["type" => "exception", "msg" => $e->getMessage()];
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            return ["type" => "exception", "msg" => $e->getMessage()];
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            return ["type" => "exception", "msg" => $e->getMessage()];
        }
    }

    public static function checkPayment($token) {
        $record = DB::table("payment_for_registration")->where("token",$token)->first();
        if ($record && $record->status == "paid") {
            return true;
        }else {
            return false;
        }
    }


}
