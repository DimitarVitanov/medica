<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Contacts/Index', [
            'contacts' => Contact::latest()->paginate(20),
            'unreadCount' => Contact::unread()->count(),
        ]);
    }

    public function show(Contact $contact)
    {
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return Inertia::render('Admin/Contacts/Show', [
            'contact' => $contact,
        ]);
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Пораката е избришана.');
    }
}
