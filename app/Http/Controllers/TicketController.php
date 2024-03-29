<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('dashboard.admin.tickets.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $ticket = Ticket::create($request->all());

        if ($ticket) {
            return response()->json(['message' => 'Ticket created successfully', 'ticket' => $ticket], 200);
        } else {
            return response()->json(['error' => 'Failed to create ticket'], 500);
        }
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        return response()->json(['ticket' => $ticket]);
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        try {
            // Update the ticket with the request data
            $ticket->update($request->all());

            // Check if the ticket was updated successfully
            if ($ticket->wasChanged()) {
                return response()->json(['ticket' => $ticket, 'message' => 'Ticket updated successfully'], 200);
            } else {
                return response()->json(['error' => 'No changes detected for the ticket'], 400);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the update process
            return response()->json(['error' => 'Failed to update ticket: ' . $e->getMessage()], 500);
        }
    }


    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return response()->json(['message' => 'Ticket deleted successfully'], 200);
    }
}
