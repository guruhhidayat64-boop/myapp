<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view('calendar.index');
    }

    public function getEvents(Request $request)
    {
        // Ambil agenda sekolah (user_id is null) DAN agenda pribadi guru yang login
        $events = CalendarEvent::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->get();

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'color' => 'required|string',
        ]);

        $event = CalendarEvent::create([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'color' => $request->color,
            // Jika Admin, user_id null (agenda sekolah). Jika Guru, isi dengan ID-nya.
            'user_id' => Auth::user()->role == 'admin' ? null : Auth::id(),
        ]);

        return response()->json($event);
    }

    public function update(Request $request, CalendarEvent $event)
    {
        // Otorisasi: Hanya Admin atau pemilik event yang bisa update
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start',
            'color' => 'required|string',
        ]);

        $event->update($request->all());

        return response()->json($event);
    }

    public function destroy(CalendarEvent $event)
    {
        // Otorisasi: Hanya Admin atau pemilik event yang bisa hapus
        if (Auth::user()->role !== 'admin' && $event->user_id !== Auth::id()) {
            abort(403);
        }

        $event->delete();

        return response()->json(['status' => 'success']);
    }
}