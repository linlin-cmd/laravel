<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use App\Tools\Tools;
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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            //定义类
            $tools =new Tools;
            //查询数据库
            $sign =DB::table('sign')->get();
            foreach ($sign as $key => $value) {
                //获取用户昵称
                $kao_openid =file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$tools->access_token()."&openid=".$value->openid."&lang=zh_CN");
                $kao_openid =json_decode($kao_openid,1);
                $nickname =$kao_openid['nickname'];
                //模板id
                $template_id ="egHVTScXlYyY9UuIfzCzWzXqkRMOd4hZNt-fwaF3II8";
                $url ="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$tools->access_token();
                $data =[
                    'touser'=>$value->openid,
                    'template_id'=>$template_id,
                    'data'=>[
                        'first'=>['value'=>''],
                        'keyword1'=>['value'=>$nickname],
                        'keyword2'=>['value'=>$value->integral]
                    ]
                ];
                $res =$tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
            }

            \Log::info('任务调动');
        // })->dailyAt('20:00');;
        })->cron('* * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
