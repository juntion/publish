<?php

namespace App\Console\Commands;

use App\Models\AccessToken;
use Illuminate\Console\Command;

class CleanAccessTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:clean-access-tokens';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '清理 accessTokens';

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
        AccessToken::query()->where('expires_at', '<', now()->addDays(-2))->delete();
    }
}
