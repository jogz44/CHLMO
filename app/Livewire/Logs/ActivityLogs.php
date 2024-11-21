<?php

namespace App\Livewire\Logs;

use Livewire\Component;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityLogs extends Component
{
    public $logs = []; // Holds the logs to be displayed

    public function logActivity(string $description, $subject = null, $causer = null)
    {
        activity()
            ->performedOn($subject)
            ->causedBy($causer ?? Auth::user())
            ->log($description);

        $this->fetchLogs(); // Refresh logs
    }

    /**
     * Fetch recent activity logs from the database.
     */
    public function fetchLogs()
    {
        // Eager load the causer with roles (if using Spatie/Permission)
        $this->logs = Activity::latest()->take(10)
            ->with('causer.roles') // Eager load the roles
            ->get();
    }

    /**
     * Lifecycle hook for Livewire.
     */
    public function mount()
    {
        $this->fetchLogs();
    }

    public function render()
    {
        return view('livewire.logs.activity-logs', ['logs' => $this->logs]);
    }
}
