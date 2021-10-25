<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\OrderHeader;
use App\Models\Settings;

class ReturnDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'returndate:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $orders = OrderHeader::where('order_status_id',2)->get();
        
        $timestamp = time();
        $appID        = 5131;
        $key          = 'h2pPolLxwMo=';
        $secret       = 'sxSUAg21709yIbnlcv9JcDVxGkHj3nxe5L76covhdXIcZ4ThOdNzpmDRxczmqlEF1rMpb2R37BoOHYlf5CUx0g==';

        $sign = "key:". $key ."id:". $appID. ":timestamp:". $timestamp;
        $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
        $ch = curl_init();
        //  $appID = 5131;
        $sellerId = 44227;
        $header = array(
            "x-appid: ".$appID,
            "x-timestamp: ".$timestamp,
            "x-sellerid: ".$sellerId,
            "x-version:3", // for auth version 3.0 only
            "Authorization: ".$authtoken,
            "Content-Type: application/json",
        );

        foreach ($orders as $key => $value)
        {
            $names = 'SHRAYATI_'.$value->id.'';
            // $names = 'order_G5nkKKDE5kw7ZO';
            // dd($names);
            $data = array(
                "orders"=> [''.$names.'']
            );
            
            $data_json = json_encode($data);
            // dd($data_json);
            curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/track?oid=1');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
            $res = json_decode($server_output);
            
            if(isset($res->$names->events['5']))
            {
                $time = $res->$names->events['5']->time;
                $time = date('d-m-yy',strtotime($time));
                $returntime = date('d-m-yy',strtotime($time.'+10 days'));
                
                $update = OrderHeader::where('id',$value->id)->update(['order_status_id'=>4,'return_date'=>$returntime]);
            }
        }
    }
}
