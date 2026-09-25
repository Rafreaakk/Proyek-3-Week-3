<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreActivityRequest $request,
        ActivityService $service
        ): RedirectResponse {
            $activity = $activity->create($request->validated());

            return to_route('activities.show', $activity)
                ->with('succes', 'Kegiatan berhasil dibuat.');
        }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
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
        //
    }
}
