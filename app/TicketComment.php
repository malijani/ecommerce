<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TicketComment extends Model
{
    protected $table  = 'ticket_comments';
    protected $fillable = [
      'user_id', 'ticket_id', 'message', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function getLimitedMessageAttribute()
    {
        return Str::words($this->message, 10);
    }

}
