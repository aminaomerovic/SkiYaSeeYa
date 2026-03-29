<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Uzimamo sve korisnike koji su pending ili approved
        $users = User::whereIn('status', ['pending', 'approved'])
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.dashboard', compact('users'));
    }

    public function approveUser($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'approved']);

        return redirect()->back()->with('success', 'Korisnik uspešno odobren.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Korisnik uspešno obrisan.');
    }
    public function announcements()
{
    $announcements = Announcement::orderBy('created_at', 'desc')->get();
    return view('admin.announcements', compact('announcements'));
}

public function createAnnouncement()
{
    return view('admin.create-announcement');
}

public function storeAnnouncement(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
    ]);

    Announcement::create([
        'title' => $request->title,
        'content' => $request->content,
        'active' => true,
    ]);

    return redirect()->route('admin.announcements')->with('success', 'Obaveštenje uspešno dodato.');
}

public function deleteAnnouncement($id)
{
    Announcement::findOrFail($id)->delete();
    return redirect()->route('admin.announcements')->with('success', 'Obaveštenje obrisano.');
}
public function editContact()
{
    $content = file_get_contents(resource_path('views/contact.blade.php'));
    return view('admin.edit-contact', compact('content'));
}

public function updateContact(Request $request)
{
    $request->validate([
        'content' => 'required|string',
    ]);

    file_put_contents(resource_path('views/contact.blade.php'), $request->content);

    return redirect()->route('admin.edit-contact')->with('success', 'Kontakt stranica uspješno ažurirana.');
}
}
