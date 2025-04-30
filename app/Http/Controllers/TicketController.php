<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     //list tickets
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            $tickets = Ticket::with('user')->latest()->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)->latest()->get();
        }

        return Inertia::render('Tickets/Index', [
            'tickets' => $tickets,
            'user' => [
            'name' => $user->name,
            'roles' => $user->roles->pluck('name')->toArray(), 
        ]
        ]);
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

    //create ticket 
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
        ]);

        $ticket = Ticket::create([
            'user_id' => Auth::id(),
            'subject' => $request->subject,
            'description' => $request->description,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'Open',
        ]);

        return redirect()->route('tickets.index')->with('success', 'Ticket created successfully.');
    }

    /**
     * Display the specified resource.
     */
    //show single tickert and comments
    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'comments.user']); // load ticket creator + comments with commenter

        // Only ticket owner or admin can view
        if (Auth::user()->hasRole('admin') || $ticket->user_id == Auth::id()) {
            return Inertia::render('Tickets/Show', [
                'ticket' => $ticket,
            ]);
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //update ticket status
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved',
        ]);
    
        $ticket->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
    //add comment to ticket
    public function addComment(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        if (Auth::user()->hasRole('admin') || $ticket->user_id == Auth::id()) {
            Comment::create([
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'message' => $request->message,
            ]);
            return redirect()->back()->with('success', 'Comment added.');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }
}


