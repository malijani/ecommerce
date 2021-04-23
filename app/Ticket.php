<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Ticket extends Model
{
    use SoftDeletes;

    protected $table = 'tickets';

    protected $fillable = [
        'user_id', 'admin_id', 'category_id', 'title', 'uuid',
        'file', 'priority', 'message', 'status'
    ];

    public $path = 'tickets/';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 0 :
                $status = "باز";
                break;
            case 1:
                $status = "پاسخ داده شده";
                break;
            case 2 :
                $status = "بسته شده";
                break;
            default :
                $status = "در حال پیشرفت";
        }
        return $status;
    }

    public function getPriorityTextAttribute()
    {
        switch ($this->priority) {
            case 0 :
                $priority = "بدون اهمیت";
                break;
            case 1:
                $priority = "مهم";
                break;
            case 2 :
                $priority = "بسیار مهم";
                break;
            default :
                $priority = "حیاتی";
        }
        return $priority;

    }

    public function getLimitedMessageAttribute()
    {
        return Str::words($this->message, 10);
    }

    public function getLimitedTitleAttribute()
    {
        return Str::words($this->title, 10);
    }
}
