<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ResellerController extends Controller
{
    /**
     * Update the maximum number of clients a reseller can have
     */
    public function updateClientLimit(Request $request, User $reseller)
    {
        // Validate request
        $validated = $request->validate([
            'max_clients' => 'nullable|integer|min:0|max:100',
        ]);

        // Check if the user is a reseller
        if ($reseller->premium_type !== 'Reseller') {
            return redirect()->back()->with('error', 'This user is not a reseller.');
        }

        // Update the max_clients field
        $reseller->max_clients = $request->filled('max_clients') ? $validated['max_clients'] : null;
        $reseller->save();

        // Log the action
        activity()
            ->performedOn($reseller)
            ->causedBy(auth()->user())
            ->withProperties(['max_clients' => $reseller->max_clients])
            ->log('Updated reseller client limit');

        return redirect()->back()->with('success', 'Reseller client limit updated successfully.');
    }

    /**
     * View a specific reseller's details and client list
     */
    public function show(User $reseller)
    {
        // Check if the user is a reseller
        if ($reseller->premium_type !== 'Reseller') {
            return redirect()->route('admin.resellers.management')->with('error', 'This user is not a reseller.');
        }

        // Eager load the reseller's clients
        $reseller->load('clients');

        return view('admin.reseller-details', [
            'reseller' => $reseller,
        ]);
    }

    /**
     * Remove a client from a reseller
     */
    public function removeClient(Request $request, User $reseller, $clientId)
    {
        // Check if the user is a reseller
        if ($reseller->premium_type !== 'Reseller') {
            return redirect()->route('admin.resellers.management')->with('error', 'This user is not a reseller.');
        }

        // Find the client and check if it belongs to this reseller
        $client = $reseller->clients()->where('id', $clientId)->first();

        if (!$client) {
            return redirect()->route('admin.resellers.show', $reseller)->with('error', 'Client not found or does not belong to this reseller.');
        }

        // Remove the relationship
        $reseller->clients()->detach($clientId);

        // Log the action
        activity()
            ->performedOn($reseller)
            ->causedBy(auth()->user())
            ->withProperties(['client_id' => $clientId])
            ->log('Removed client from reseller');

        return redirect()->route('admin.resellers.show', $reseller)->with('success', 'Client removed from reseller successfully.');
    }
} 