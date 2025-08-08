<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Awardee;
use App\Models\AwardeeAttachmentsList;
use App\Models\AwardeeTransferHistory;
use App\Models\Barangay;
use App\Models\Blacklist;
use App\Models\Dependent;
use App\Models\Purok;
use App\Models\RelocationSite;
use App\Models\Spouse;
use App\Models\TransferAttachmentsList;
use App\Models\TransferDocumentsSubmissions;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Livewire\Logs\ActivityLogs;
use Illuminate\Support\Facades\Auth;

class AwardeeList extends Component
{
    use WithPagination;

    // Filter properties
    public $relocation_site = '',  $status = '', $search = '', $startDate = '', $endDate = '';

    private function handleError(string $message, \Exception $e = null): void
    {
        if ($e) {
            logger()->error($message, [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }

        $this->dispatch('alert', [
            'title' => 'Error',
            'message' => $message,
            'type' => 'error'
        ]);
    }

    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $tmpPath = storage_path('livewire-tmp');
            // Delete files older than 24 hours
            foreach (glob("$tmpPath/*") as $file) {
                if (time() - filemtime($file) > 24 * 3600) {
                    unlink($file);
                }
            }
        })->daily();
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingRelocationSite(): void
    {
        $this->resetPage();
    }
    public function updatingStatus(): void
    {
        $this->resetPage();
    }
    public function resetFilters(): void
    {
        $this->reset([
            'relocation_site',
            'status',
            'search',
            'startDate',
            'endDate'
        ]);
    }

    public function render()
    {
        $query = Awardee::with([
            'taggedAndValidatedApplicant.applicant.person',
            'assignedRelocationSite',
            'actualRelocationSite',
        ]);

        // Apply relocation site filter
        if ($this->relocation_site) {
            $query->where(function($q) {
                $q->whereHas('assignedRelocationSite', function($subQ) {
                    $subQ->where('relocation_site_name', 'like', '%' . $this->relocation_site . '%');
                })->orWhereHas('actualRelocationSite', function($subQ) {
                    $subQ->where('relocation_site_name', 'like', '%' . $this->relocation_site . '%');
                });
            });
        }

        // Date range filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('grant_date', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        }

        // Advanced name search logic
        if ($this->search) {
            $keywords = explode(' ', strtolower($this->search)); // Split search into parts

            $query->where(function ($query) use ($keywords) {
                $query->whereHas('taggedAndValidatedApplicant.applicant.person', function ($q) use ($keywords) {
                    $q->where(function ($nameQuery) use ($keywords) {
                        foreach ($keywords as $word) {
                            $nameQuery->where(function ($subQuery) use ($word) {
                                $subQuery->whereRaw('LOWER(first_name) LIKE ?', ["%$word%"])
                                        ->orWhereRaw('LOWER(middle_name) LIKE ?', ["%$word%"])
                                        ->orWhereRaw('LOWER(last_name) LIKE ?', ["%$word%"])
                                        ->orWhereRaw('LOWER(suffix_name) LIKE ?', ["%$word%"]);
                            });
                        }
                    });
                });
            });
        }

        $awardees = $query->orderBy('created_at', 'desc')->paginate(5);

        // Optional debug logging
        foreach ($awardees as $awardee) {
            Log::info('Awardee details', [
                'awardee_id' => $awardee->id,
                'tagged_validated_id' => $awardee->tagged_and_validated_applicant_id,
                'person_name' => optional(optional(optional($awardee->taggedAndValidatedApplicant)->applicant)->person)->full_name,
                'is_blacklisted' => $awardee->is_blacklisted,
                'previous_awardee_name' => $awardee->previous_awardee_name
            ]);
        }

        $puroks = !empty($this->barangay)
            ? Purok::whereHas('barangay', function ($query) {
                $query->where('name', $this->barangay);
            })->pluck('name')
            : Purok::distinct()->pluck('name');

        return view('livewire.awardee-list', [
            'awardees' => $awardees,
            'relocationSites' => RelocationSite::all(),
            'puroks' => $puroks,
        ]);
    }

}
