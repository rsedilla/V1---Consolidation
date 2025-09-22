<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckConsolidators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-consolidators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Member Types:');
        foreach(\App\Models\MemberType::all() as $mt) {
            $this->line($mt->id . ': ' . $mt->name);
        }
        
        $this->info('VIP Statuses:');
        foreach(\App\Models\VipStatus::all() as $vs) {
            $this->line($vs->id . ': ' . $vs->name);
        }
        
        $this->info('Members with Consolidator type:');
        $consolidators = \App\Models\Member::whereHas('memberType', function($q) {
            $q->where('name', 'Consolidator');
        })->get();
        
        foreach($consolidators as $m) {
            $this->line($m->id . ': ' . $m->first_name . ' ' . $m->last_name);
        }
        
        $this->info('Total consolidators: ' . $consolidators->count());
        
        $this->info('Testing getAvailableConsolidators for admin user:');
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if ($adminUser) {
            $consolidators = $adminUser->getAvailableConsolidators();
            foreach($consolidators as $id => $name) {
                $this->line($id . ': ' . $name);
            }
        }
    }
}
