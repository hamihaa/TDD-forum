<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class WeeklyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

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
        $users = User::where('get_newsletter', 1)->get();

        $lastPosts = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->limit(5)->get();

        $lastWithResponse = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->whereIn('thread_status_id', [5, 6])->limit(5)->get();

        $mostVoted = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->withCount('votes')->orderBy('votes_count', 'desc')->limit(5)->get();

        $mostCommented = \App\Thread::where('created_at', '<', \Carbon\Carbon::now()->subDays(7))->withCount('replies')->orderBy('replies_count', 'desc')->limit(5)->get();

        foreach ($users as $user) {
            Mail::send('emails.newsletter', compact('lastPosts', 'lastWithResponse', 'mostVoted', 'mostCommented'), function ($message) use ($user) {
                $message->from('predlagam.vladi@test.test', 'Tedenski bilten na predlagam.vladi');
                $message->to($user->email);
            });
        }
    }
}
