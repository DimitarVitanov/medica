<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubscriberController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Subscribers/Index', [
            'subscribers' => Subscriber::latest()->paginate(20),
            'totalCount' => Subscriber::count(),
            'activeCount' => Subscriber::active()->count(),
        ]);
    }

    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->route('admin.subscribers.index')
            ->with('success', 'Претплатникот е избришан.');
    }
}
