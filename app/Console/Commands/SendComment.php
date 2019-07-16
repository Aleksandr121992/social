<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'comment:{comment}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Comment comment.';

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
        $user = \App\User::first();
        $comment = \App\Comment::create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id,
            'comment' => $this->argument('comment')
        ]);

        event(new \App\Events\ChatMessageWasReceived($comment, $user ,$post));
    }
}
