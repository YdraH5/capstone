<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\DueDate;
use Carbon\Carbon;
class UpdateDueDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-due-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    public function __construct()
    {
        parent::__construct();
    }
    protected $description = 'Update due dates for all renters';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dueDates = DueDate::all();
        foreach ($dueDates as $dueDate) {
            $nextDueDate = Carbon::parse($dueDate->due_date)->addMonth();
            $dueDate->update(['due_date' => $nextDueDate]);
        }

        $this->info('Due dates updated successfully!');
        // return Command::SUCCESS;
    }
}
