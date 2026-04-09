<?php
namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // Show upload form
    public function create(Tenant $tenant)
    {
        return view('documents.create', compact('tenant'));
    }

    // Store uploaded document
    public function store(Request $request, Tenant $tenant)
    {
        $request->validate([
            'id_card_type' => 'required|in:national_id,passport,other',
            'document'     => [
                'required',
                'file',
                'max:5120',  // 5MB max
                'mimes:jpg,jpeg,png,webp,pdf',
            ],
        ]);

        // Delete old document if exists
        if ($tenant->id_card_path) {
            Storage::disk('public')->delete($tenant->id_card_path);
        }

        // Store new document
        $file     = $request->file('document');
        $filename = 'tenant_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('documents', $filename, 'public');

        $tenant->update([
            'id_card_type'          => $request->id_card_type,
            'id_card_path'          => $path,
            'id_card_original_name' => $file->getClientOriginalName(),
            'id_card_uploaded_at'   => now(),
        ]);

        return redirect()->route('tenants.show', $tenant)
                         ->with('success', 'Document uploaded successfully!');
    }

    // View/Download document
    public function show(Tenant $tenant)
    {
        if (!$tenant->hasDocument()) {
            return redirect()->route('tenants.show', $tenant)
                             ->with('error', 'No document found.');
        }

        $path = storage_path('app/public/' . $tenant->id_card_path);

        if (!file_exists($path)) {
            return redirect()->route('tenants.show', $tenant)
                             ->with('error', 'Document file not found.');
        }

        return response()->file($path, [
            'Content-Disposition' => 'inline; filename="' . $tenant->id_card_original_name . '"',
        ]);
    }

    // Delete document
    public function destroy(Tenant $tenant)
    {
        if ($tenant->id_card_path) {
            Storage::disk('public')->delete($tenant->id_card_path);
        }

        $tenant->update([
            'id_card_path'          => null,
            'id_card_type'          => null,
            'id_card_original_name' => null,
            'id_card_uploaded_at'   => null,
        ]);

        return redirect()->route('tenants.show', $tenant)
                         ->with('success', 'Document deleted.');
    }
    // Show photo upload form
    public function photoCreate(Tenant $tenant)
    {
        return view('documents.photo', compact('tenant'));
    }

    // Store photo
    public function photoStore(Request $request, Tenant $tenant)
    {
        $request->validate([
            'photo' => [
                'required',
                'file',
                'image',
                'max:3072',   // 3MB max
                'mimes:jpg,jpeg,png,webp',
            ],
        ]);

        // Delete old photo if exists
        if ($tenant->photo_path) {
            Storage::disk('public')->delete($tenant->photo_path);
        }

        $file     = $request->file('photo');
        $filename = 'photo_' . $tenant->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('photos', $filename, 'public');

        $tenant->update(['photo_path' => $path]);

        return redirect()->route('tenants.show', $tenant)
                        ->with('success', 'Photo updated successfully!');
    }

    // Delete photo
    public function photoDestroy(Tenant $tenant)
    {
        if ($tenant->photo_path) {
            Storage::disk('public')->delete($tenant->photo_path);
            $tenant->update(['photo_path' => null]);
        }

        return redirect()->route('tenants.show', $tenant)
                        ->with('success', 'Photo removed.');
    }
}