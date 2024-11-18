<?php

namespace App\Console\Commands;

use App\Services\Portal\Experience\ExperienceMailService;
use Illuminate\Console\Command;

class SendReviewPendingEmail extends Command
{

    protected ExperienceMailService $service;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ExperienceMailService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'experience:send-review-pending-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->service->onReviewPendent();

        return Command::SUCCESS;
    }
}
