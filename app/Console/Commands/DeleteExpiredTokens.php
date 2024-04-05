<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:delete-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete expired tokens from the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::table('personal_access_tokens')->where('expires_at','<',now())->delete();
        $this->info('Expired tokens deleted successfully.');
    }
}
