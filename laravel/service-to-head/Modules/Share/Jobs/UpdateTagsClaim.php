<?php

namespace Modules\Share\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Modules\Share\Entities\ResourceTag;

class UpdateTagsClaim implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tag;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(ResourceTag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->tag->resources->map(function ($resources) {
            $resources->searchable();
        });
    }
}
