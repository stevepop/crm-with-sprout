<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sprout\Contracts\Tenant;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentTenant = auth()->user()->organisation;

        $contactCount = Contact::count();

        // Get counts of contacts by status
        $contactsByStatus = [
            'lead' => Contact::status('lead')->count(),
            'customer' => Contact::status('customer')->count(),
            'inactive' => Contact::status('inactive')->count(),
        ];

        return view('dashboard', [
            'organisation' => $currentTenant,
            'contactCount' => $contactCount,
            'contactsByStatus' => $contactsByStatus
        ]);
    }
}
