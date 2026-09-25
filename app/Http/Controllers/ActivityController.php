<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Services\ActivityService;
use Illuminate\Http\RedirectResponse;
use DomainException;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, ActivityService $service)
    {
        $status = $request->query('status');
        
        $activities = $service->getFilteredActivities($status);

        return view('activities.index', compact('activities', 'status'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('activities.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreActivityRequest $request,
        ActivityService $service
        ): RedirectResponse {
            $activity = $service->create($request->validated());

            return to_route('activities.show', $activity)
                ->with('succes', 'Kegiatan berhasil dibuat.');
        }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        return view('activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        return view('activities.edit', compact('activity'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateActivityRequest $request,
        Activity $activity,
        ActivityService $service
        ): RedirectResponse {
            try {
                $service->update($activity, $request->validated());
            } catch (DomainException $exception) {
                return back()
                    ->withErrors(['status' => $exception->getMessage()])
                    ->withInput();
        }

        return to_route('activities.show', $activity)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        $activity->delete();

        return to_route('activities.index')
            ->with('succes', 'Kegiatan berhasil dihapus.');
    }
}
