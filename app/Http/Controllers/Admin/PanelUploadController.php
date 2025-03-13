<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PanelUploadController extends Controller
{
    /**
     * Display a listing of panel files.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $downloads = Download::latest()->paginate(10);
        return view('admin.panel-upload.index', compact('downloads'));
    }

    /**
     * Show the form for creating a new panel file.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.panel-upload.create');
    }

    /**
     * Store a newly uploaded panel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:All,External,Streamer,Bypass,Reseller'],
            'version' => ['required', 'string'],
            'file' => ['required', 'file', 'max:102400'], // 100MB max
            'is_active' => ['boolean'],
        ]);

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store the file
            $path = $file->storeAs('panels', $filename, 'public');
            
            if (!$path) {
                return back()->with('error', 'Failed to upload file.');
            }
            
            $validated['file_path'] = $path;
        }

        // Create download record
        $download = Download::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'version' => $validated['version'],
            'file_path' => $validated['file_path'],
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.panel-upload.index')
            ->with('success', 'Panel file uploaded successfully.');
    }

    /**
     * Show the form for editing the specified panel file.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\View\View
     */
    public function edit(Download $download)
    {
        return view('admin.panel-upload.edit', compact('download'));
    }

    /**
     * Update the specified panel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Download $download)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'type' => ['required', 'string', 'in:All,External,Streamer,Bypass,Reseller'],
            'version' => ['required', 'string'],
            'file' => ['nullable', 'file', 'max:102400'], // 100MB max
            'is_active' => ['boolean'],
        ]);

        // Handle file upload if new file is provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($download->file_path) {
                Storage::disk('public')->delete($download->file_path);
            }

            $file = $request->file('file');
            $filename = Str::slug($validated['name']) . '-' . time() . '.' . $file->getClientOriginalExtension();
            
            // Store the new file
            $path = $file->storeAs('panels', $filename, 'public');
            
            if (!$path) {
                return back()->with('error', 'Failed to upload file.');
            }
            
            $validated['file_path'] = $path;
        }

        // Update download record
        $download->update($validated);

        return redirect()->route('admin.panel-upload.index')
            ->with('success', 'Panel file updated successfully.');
    }

    /**
     * Remove the specified panel file.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Download $download)
    {
        // Delete the file
        if ($download->file_path) {
            Storage::disk('public')->delete($download->file_path);
        }

        // Delete the record
        $download->delete();

        return redirect()->route('admin.panel-upload.index')
            ->with('success', 'Panel file deleted successfully.');
    }

    /**
     * Toggle panel file active status.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleActive(Download $download)
    {
        $download->update(['is_active' => !$download->is_active]);

        return back()->with('success', 'Panel file status updated successfully.');
    }

    /**
     * Download the panel file.
     *
     * @param  \App\Models\Download  $download
     * @return \Illuminate\Http\Response
     */
    public function download(Download $download)
    {
        if (!$download->is_active) {
            return back()->with('error', 'This panel file is not available for download.');
        }

        if (!Storage::disk('public')->exists($download->file_path)) {
            return back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($download->file_path);
    }

    /**
     * Display download statistics.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        $totalDownloads = Download::count();
        $activeDownloads = Download::where('is_active', true)->count();
        
        $downloadsByType = Download::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->get();
            
        $recentDownloads = Download::latest()->take(5)->get();
        
        return view('admin.panel-upload.statistics', compact(
            'totalDownloads',
            'activeDownloads',
            'downloadsByType',
            'recentDownloads'
        ));
    }
} 