<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Mailers\AppMailer;
use App\Ticket;
use App\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
        /*ADD COMMENT TO A TICKET AND HANDLING ADMIN_ID*/

        $request->validate([
            'message' => 'required|string|min:5|max:6000',
            'ticket_id' => 'required|numeric|exists:tickets,id',
            'file' => 'nullable|mimetypes:video/*,audio/*,image/*,application/*,text/*|max:2048',
        ]);

        $ticket = Ticket::query()->findOrFail($request->input('ticket_id'));
        if (is_null($ticket->admin_id)) {
            $ticket->admin_id = Auth::id();
            $ticket->save();
        }
        $dir = app('App\\Ticket')->path . $ticket->uuid;
        $file = fileUploader($request, 'file', $dir);

        $comment = new TicketComment(array_merge(
            $request->except('file'),
            ['file' => $file],
            ['user_id'=>Auth::id()]
        ));

        $comment->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return response()->redirectToRoute('tickets.show', $ticket->id)->with('success', 'پاسخ شما ثبت شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*GET TICKET ID AND SHOW RELATED COMMENTS*/
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
        /*EDIT COMMENT BY ID*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*DELETE A COMMENT*/
    }
}
