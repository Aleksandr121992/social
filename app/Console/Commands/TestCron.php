<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Post;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test001';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test001';

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
        // dd (111);
        $x = Post::first();
        $x->post_title = $x->post_title.'1';
        $x->save();
    }
}
