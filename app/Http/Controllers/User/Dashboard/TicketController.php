<?php

namespace App\Http\Controllers\User\Dashboard;

use App\Http\Controllers\Controller;
use App\Mailers\AppMailer;
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
        $title = 'پشتیبانی و تیکت های من';
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
            'title' => $title,
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AppMailer $mailer)
    {
        $request->validate([
            'category_id' => 'required|numeric|exists:ticket_categories,id',
            'title' => 'required|string|min:5|max:100',
            'message' => 'required|string|min:5|max:6000',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif,zip|max:2048',
            'priority' => 'required|numeric|in:0,1,2',
        ], [
            'category_id' => [
                'required' => 'تعیین دسته بندی تیکت الزامیست',
                'numeric' => 'نوع داده ای دسته بندی عدد است',
                'exists' => 'این دسته بندی در سیستم ثبت نشده',
            ],
            'title' => [
                'required' => 'تعیین عنوان تیکت الزامیست',
                'string' => 'نوع داده ای عنوان تیکت کاراکتر است',
                'min' => 'حداقل ۵ کاراکتر برای عنوان باید تعیین شود',
                'max' => 'حداکثر ۱۰۰ کاراکتر برای عنوان تیکت در نظر گرفته شده',
            ],
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
            'priority' => [
                'required' => '',
                'numeric' => '',
                'in' => '',
            ],
        ]);

        $user_id = Auth::id();
        $uuid = generateUniqueString(app('App\\Ticket'), 'uuid', 12);
        $dir = app('App\\Ticket')->path . $uuid;
        $file = fileUploader($request, 'file', $dir);
        $ticket = new Ticket(array_merge(
            $request->except('file'),
            ['status' => 0],
            ['file' => $file],
            ['user_id' => $user_id],
            ['uuid' => $uuid]
        ));
        $ticket->save();
        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return response()->redirectToRoute('dashboard.tickets.show', $ticket->uuid)->with('success', 'تیکت شما با موفقیت ثبت شد.');
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
            'title' => $title,
            'ticket' => $ticket,
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
