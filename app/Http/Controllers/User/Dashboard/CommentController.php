<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\TicketComment;
use Illuminate\Http\RedirectResponse;
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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'message' => 'required|string|min:5|max:6000',
            'ticket_id' => 'required|string|exists:tickets,uuid',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif,zip|max:2048',
        ], [
            'message' => [
                'required' => 'تعیین پیام تیکت الزامیست',
                'string' => 'نوع داده ای پیام تیکت کاراکتر است',
                'min' => 'حداقل ۵ کاراکتر برای پیام تیکت باید تعیین شود',
                'max' => 'حداکثر ۶۰۰۰ کاراکتر برای پیام تیکت در نظر گرفته شده است',
            ],
            'file' => [
                'mimes' => 'فایل های png , jpeg, jpg, gif, zip مجاز به ثبت می‌باشند.',
                'max' => 'حداکثر اندازه فایل باید ۲ مگابایت باشد.',
            ],
            'ticket_id' => [
                'required' => 'تعیین آیدی تیکت الزامیست.',
                'string' => 'نوع داده ای آیدی تیکت کاراکتر است',
                'exists' => 'این تیکت در سیستم ثبت نشده.'
            ],
        ]);
        $ticket_uuid = $request->input('ticket_id');
        $ticket = Ticket::query()
            ->where('uuid', $ticket_uuid)
            ->firstOrFail();

        $dir = app('App\\Ticket')->path . $ticket_uuid;
        $file = fileUploader($request, 'file', $dir);

        $comment = new TicketComment(array_merge(
            $request->except('ticket_id', 'file'),
            ['ticket_id' => $ticket->id],
            ['file' => $file],
            ['user_id' => Auth::id()]
        ));

        $comment->save();
        $ticket->status = 0;
        $ticket->save();

        return response()
            ->redirectToRoute('dashboard.tickets.show', $ticket->uuid)
            ->with('success', 'پاسخ شما ثبت شد.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
