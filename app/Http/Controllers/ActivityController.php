<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Category;
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
    public function index(\Illuminate\Http\Request $request, \App\Services\ActivityService $service)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $sortBy = $request->query('sort_by', 'activity_date');
        $order = $request->query('order', 'desc');

        $activities = $service->getFilteredActivities($status, $search, $sortBy, $order);

        return view('activities.index', compact('activities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Mengambil semua data kategori dari database
        $categories = Category::all();

        //Melempar data kategori tersebut ke halaman form
        return view('activities.create', compact('categories'));
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
        $categories = Category::all();
        return view('activities.edit', compact('activity', 'categories'));
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

    // Menampilkan daftar data yang terhapus (Soft Deleted)
    public function trash()
    {
        $activities = \App\Models\Activity::onlyTrashed()->paginate(10);
        return view('activities.trash', compact('activities'));
    }

    // Mengembalikan data yang terhapus (Restore)
    public function restore($id)
    {
        $activity = \App\Models\Activity::onlyTrashed()->findOrFail($id);
        $activity->restore();
        
        return redirect()->route('activities.trash')->with('success', 'Kegiatan berhasil dipulihkan!');
    }
}
