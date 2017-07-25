<?php

namespace App\Console\Commands;

use App\Thread;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChangeThreadStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thread:changeStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all threads and update statuses on 2 and 3.';

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
        /*
         * 1 - nepotrjeno
         * 2 - v_razpravi - 15 dni, samo ta ima opcijo spreminjanja predloga
         * 3 - v_glasovanju - 14 dni, nima opcije spreminjanja
         * 4 - posredovano - nima opcije glasovanja
         * 5 - organ_sprejel - nima opcije glasovanja
         * 6 - organ_zavrnil  nima opcije glasovanja
         * 7 - neustrezno - nima opcije glasovanja
         */
        $date = new Carbon; //  DateTime string will be 2014-04-03 13:57:34
        $date->subDays(15);
//        dd($date);
        $threads = Thread::where('thread_status_id', '=', 2)->where('in_discussion_from', '<', $date->toDateTimeString() )->get();

        foreach($threads as $thread){
            $thread->changeStatus(3);
        }

    // poišči vse, ki imajo status 3 & 14 dni since update ->

        $date = new Carbon; //  DateTime string will be 2014-04-03 13:57:34
        $date->subDays(14);

        $threads = Thread::where('thread_status_id', '=', 3)->where('in_voting_from', '<', $date->toDateTimeString() )->get();
//        dd($threads);
        foreach($threads as $thread)
            $numberOfVotes = $thread->neededVotesToPass();
            //če je dovolj glasov in pro > against
            if($numberOfVotes[1] < 1 && $thread->isUpVotedOn > $thread->isDownVotedOn) {
                $thread->changeStatus(4);
            } else {
                $thread->changeStatus(7);
            }
    }
}
