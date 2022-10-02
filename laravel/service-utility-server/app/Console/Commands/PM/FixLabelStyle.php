<?php

namespace App\Console\Commands\PM;

use App\ProjectManage\Models\LabelCategory;
use Illuminate\Console\Command;

class FixLabelStyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pm:fix-label-style';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修复标签 style 字段';

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
        $categories = LabelCategory::query()->with('labels');
        $categories->each(function ($category) {
            $category->labels->each(function ($label) use ($category) {
                $label->update(['style' => $category->style]);
            });
        });
        $this->info('ok');
    }
}
