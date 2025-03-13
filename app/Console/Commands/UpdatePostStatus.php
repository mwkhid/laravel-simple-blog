<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdatePostStatus extends Command
{
    protected $signature = 'posts:update-status';
    protected $description = 'Update scheduled posts to publish if publish_date is reached';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        DB::table('posts')
            ->where('status', 'scheduled')
            ->where('publish_date', '<=', now())
            ->update(['status' => 'publish']);

        $this->info('Post status updated successfully');
    }
}
