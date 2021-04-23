<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\TicketCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'پشتیبانی و تیکت های من' ;
        $tickets = Ticket::query()
            ->where('user_id', Auth::id())
            ->orderBy('status')
            ->orderByDesc('priority')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->paginate(10);

        return response()->view('front-v1.user.dashboard.ticket.index', [
            'title' => $title,
            'tickets' => $tickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'ثبت تیکت جدید';
        $categories = TicketCategory::query()
            ->where('status', 1)
            ->get();

        return response()->view('front-v1.user.dashboard.ticket.create', [
           'title'=> $title,
           'categories'=>$categories,        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $ticket = Ticket::query()->where('uuid', $uuid)->firstOrFail();
        $title = 'تیکت ' . $ticket->title;
        return response()->view('front-v1.user.dashboard.ticket.show', [
            'title'=>$title,
            'ticket'=>$ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
