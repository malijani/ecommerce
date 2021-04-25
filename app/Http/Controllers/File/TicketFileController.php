<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Ticket;
use App\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketFileController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type = 'ticket')
    {
        if ($type === 'comment') {
            $object = TicketComment::query()->findOrFail($id);
            $user_id = Ticket::query()->where('id', $object->ticket_id)->firstOrFail()->user_id;
        } else {
            $object = Ticket::query()->where('uuid', $id)->firstOrFail();
            $user_id = $object->user_id;
        }

        $file = Storage::disk('private')->path('/') . $object->file;
        if (file_exists($file) && ((Auth::id() == $user_id) || Auth::user()->isAdmin()) ) {

            $headers = [
                'Content_Type' => mime_content_type($file)
            ];
            $path_info = pathinfo($file);
            $name = $path_info['filename'] . '.' . $path_info['extension'];

            return response()->download($file, $name, $headers);
        } else {
            return back()->with('error', 'فایل درخواستی شما وجود ندارد!');
        }
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
