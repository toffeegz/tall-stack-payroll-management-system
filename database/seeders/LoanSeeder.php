<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Loan;
use App\Models\LoanInstallment;
use Helper;
use Carbon\Carbon;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // loop thru user
        // how many loans? 50

        $users_id = User::all('id')->toArray();

        $loan_total = 100;
        $loan_count = 0;
        $details = [
            'Emergency Expenses',
            'Home Remodeling',
            'Debt Consolidation',
            'Alternative to payday loan',
            'Moving costs',
            'Large purchases',
            'Vehicle financing',
            'Wedding expenses',
            'Vacation expenses',
        ];

        $loans = [];
        for($i = 1; $i <= $loan_total; $i++) {
            $amount = rand(2000,12000);
            $date_approved = Carbon::now()->subDays(rand(7, 600));
            $installment_period = rand(1,6);
            $created_at = $date_approved->subDays(rand(2,3));
            $installment_amount = $amount / $installment_period;
            $status = 1;
            $approved = Helper::randomWithChance(90);

            if($approved === true) {
                $status = 2;
            } else {
                $status = 3;
            }

            
            $loans[] = [
                'loan_type_id' => 1,
                'user_id' => $users_id[$i]['id'],
                'project_id' => null,
                'amount' => $amount,
                'total_amount_to_pay' => $amount,
                'balance' => 0,
                'pay_next' => 0,
                'installment_amount' => $installment_amount,
                'date_approved' => $date_approved,
                'details' => $details[rand(0,8)],
                'status' => $status,
                'auto_deduct' => false,
                'install_period' => $installment_period,
                'created_at' => $created_at,
                'updated_at' => $created_at,
            ];
        }

        Loan::insert($loans);

        $loan_installments = [];
        $approved_loans = Loan::where('status', 2)->whereNull('deleted_at')->get();
        foreach($approved_loans as $approved_loan) {
            

            $install_period = $approved_loan->install_period;
            $date_approved = Carbon::parse($approved_loan->date_approved);
            for($i = 1; $i <= $install_period; $i++) {
                $add_days = [
                    6,13,29,
                ];
                
                $pay_date = $date_approved->addDays($add_days[rand(0,2)]);
                $loan_installments[] = [
                    'loan_id' => $approved_loan->id,
                    'user_id' => $approved_loan->user_id,
                    'amount' => $approved_loan->installment_amount,
                    'pay_date' => $pay_date,
                    'notes' => '',
                    'created_at' => $pay_date,
                    'updated_at' => $pay_date,
                ];
            }
        }

        LoanInstallment::insert($loan_installments);

    }
}
