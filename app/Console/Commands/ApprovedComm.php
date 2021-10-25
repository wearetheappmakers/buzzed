<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\userComm;

class ApprovedComm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approve:comm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'approve user commission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userComm = userComm::get();
         $Date = date("Y-m-d");//Carbon::today()->toDateString();
        foreach ($userComm as $value) {
            // $apdate = $value->approvedDate->addDay(1);
            // dd($value->approvedDate);
            // dd($apdate);
            if($value->approvedDate == $Date){

                $value->update([
                    'status' => 1,
                ]);
            }
        }
    }
}
