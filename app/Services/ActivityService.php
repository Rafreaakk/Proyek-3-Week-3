<?php 

namespace App\Services;

use App\Models\Activity;
use DomainException;

class ActivityService
{
    private const TRANSITIONS = [
        'Planned' => ['Planned', 'Ongoing'],
        'Ongoing' => ['Ongoing', 'Done'],
        'Done' => ['Done'],
    ];

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $nextStatus = $data['status'] ?? $activity->status;
        $this->ensureValidTransition($activity->status, $nextStatus);
        $activity->update($data);

        return $activity->refresh();
    }

    public function getFilteredActivities(?string $status, ?string $search = null, ?string $sortBy = 'activity_date', ?string $order = 'desc')
    {
        $query = \App\Models\Activity::query();
    
        $validStatuses = ['Planned', 'Ongoing', 'Done'];
        $status = $status ? ucfirst(strtolower($status)) : null;

        if ($status && in_array($status, $validStatuses)) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%'. $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $allowedSorts = ['activity_date', 'created_at', 'title'];
        $sortBy = in_array($sortBy, $allowedSorts) ? $sortBy : 'activity_date';
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $query->orderBy($sortBy, $order);

        return $query->paginate(10)->withQueryString();
    }

    private function ensureValidTransition(
        string $current,
        string $next
    ): void {
        $allowed = self::TRANSITIONS[$current] ?? [];

        if (! in_array($next, $allowed, true)) {
            throw new DomainException(
                "Transisi status {$current} ke {$next} tidak diizinkan."
            );
        }
    }

}