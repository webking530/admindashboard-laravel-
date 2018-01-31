<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

use Mail;
use Carbon\Carbon;

use App\Models\Schedule;
use App\Mail\SendMail;

class SendEmail extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'auto:sendmail';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send email by schedule';

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
	 * @return int
	 */
	public function handle()
	{
		foreach($this->getSchedule() as $schedule) {
			if ($schedule['email']) {
					$this->sendCodeViaEmail($schedule);
					\Log::info('---------------------------');
					\Log::info($schedule);
			} else {
					echo 'No set email' . '<BR/>';
			}
		}

		\Log::info('Cron is working fine! '.Carbon::now());	
		$this->info('auto:sendmail Cummand Run successfully!');
	}

	function getSchedule() {
		$interval = 5;
		$now = Carbon::now()->second(0);
		$start_time = $now->toTimeString();
		$end_time = $now->addMinutes($interval)->toTimeString();

		$res = array();
		foreach (Schedule::where('approved', 1)->get() as $schedule) {
			foreach (explode(', ', $schedule->sending_time) as $time) {
				if ($time >= $start_time && $time < $end_time) {
					$arr = array();
					$arr['id'] = $schedule->id;
					$arr['site_id'] = $schedule->site_id;
					$arr['site'] = $schedule->site->name;
					$arr['email'] = $schedule->site->email;
					$arr['sending_time'] = $time;
					
					$res[] = $arr;
				}
			}
		}
		
		return $res;
	}
	
  function sendCodeViaEmail($schedule)
  {
    $data = [
        'title' => 'QrCode for the attend - schedule',
        'body' => 'This is for testing',
				'code' => $this->getCode($schedule),
				'sent_time' => Carbon::now()
        ];
    Mail::to($schedule['email'])->send(new SendMail($data));
    \Log::info('sent!!');
  }

  function getCode($schedule){
		$arr = array(
			'type' => 'schedules',
			'id' => Crypt::encryptString($schedule['id']),
			'site_id' => $schedule['site'].'_'.$schedule['site_id'],
			'site' => $schedule['site'],
			'start' => date('Y-m-d').' '.$schedule['sending_time']
		);
		// $start = date('Y-m-d').' '.$schedule['sending_time'];
    $code = \QrCode::format('png')->size(250)->margin(3)->generate(\json_encode($arr));
    return  'data:image/png;base64,' . base64_encode($code);
  }
}
