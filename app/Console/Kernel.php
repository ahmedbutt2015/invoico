<?php

namespace App\Console;

use App\Payment;
use App\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $users = User::select("users.*", "plans.amount")
                ->leftJoin("plans", "plans.id", "users.plan_id")
                ->where("plan_id", ">", "1")->get();
            foreach ($users as $user) {
                $data = [
                    'cvc' => $user->cvc,
                    'number' => $user->card_number,
                    'exp_month' => $user->ex_month,
                    'exp_year' => $user->ex_year,
                ];
                Payment::payStripe($data, $user->amount, "Monthly Payment to " . config('app.name'), function () use ($user) {
                    $payment = [
                        "amount" => $user->amount,
                        "card_number" => $user->card_number,
                        "cvc" => $user->cvc,
                        "month" => $user->ex_month,
                        "year" => $user->ex_year,
                    ];
                    Payment::AddPayment($payment, $user->id);
                });
            }
        })->monthly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
