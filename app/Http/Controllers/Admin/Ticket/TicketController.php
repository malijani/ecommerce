<?php

namespace App\Http\Controllers\Admin\Ticket;

use App\Http\Controllers\Controller;
use App\Mailers\AppMailer;
use App\Ticket;
use App\TicketCategory;
use App\User;
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
        $title = 'مدیریت تیکت های کاربران ';
        $tickets = Ticket::withoutTrashed()
            ->orderBy('status')
            ->orderByDesc('priority')
            ->orderByDesc('created_at')
            ->get();

        return response()->view('admin.ticket.index', [
            'title' => $title,
            'tickets' => $tickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'تعریف تیکت جدید برای نمایش به کاربر';
        $categories = TicketCategory::query()->where('status', 1)->get();
        $users = User::withoutTrashed()->where('status', 1)->whereNotNull('email_verified_at')->get();
        return response()->view('admin.ticket.create', [
            'title' => $title,
            'categories' => $categories,
            'users' => $users,
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
            'user_id' => 'required|numeric|exists:users,id',
            'category_id' => 'required|numeric|exists:ticket_categories,id',
            'title' => 'required|string|min:5|max:100',
            'message' => 'required|string|min:5|max:6000',
            'file' => 'nullable|mimetypes:video/*,audio/*,image/*,application/*,text/*|max:2048',
            'priority' => 'required|numeric|in:0,1,2',
            'status' => 'required|numeric|in:0,1,2'
        ]);
        $admin_id = Auth::id();

        $uuid = generateUniqueString(app('App\\Ticket'), 'uuid', 12);
        $dir = app('App\\Ticket')->path . $uuid;
        $file = fileUploader($request, 'file', $dir);

        $ticket = new Ticket(array_merge(
            $request->except('file'),
            ['file' => $file],
            ['admin_id' => $admin_id],
            ['uuid' => $uuid]
        ));

        $ticket->save();

        $mailer->sendTicketInformation(Auth::user(), $ticket);

        return response()->redirectToRoute('tickets.index')->with('success', 'یک تیکت با آیدی #' . $ticket->uuid . ' ایجاد شد');
    }

    public function download($file, $path)
    {
        $file = Storage::disk('private')->path('/') . $path . '/' . $file;
        if (file_exists($file)) {
            return response()->download($file);
        }
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
