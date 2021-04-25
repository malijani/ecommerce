<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>تیکت پشتیبانی {{ env('app.name') }}</title>
    <style>
        .container {
            text-align: center;
            margin-top: 2rem;
        }

        .header {
            background: #ECEFF1;
            padding: 2rem
        }

        .content {
            background: #FAFAFA;
            font-size: 20px;
            padding: 10px;
        }

        .description {
            font-size: 16px;
        }

        .footer {
            font-size: 20px;
        }
    </style>
</head>
<body>

<div dir="rtl" class="container">
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="content">
        <div class="text">
            <p>
                کاربر گرامی {{ ucfirst($user->full_name) }}
                از شما بابت ارتباط با تیم پشتیبانی متشکریم. لطفاً به تیکت زیر سر بزنید :
            </p>
        </div>
        <div class="description">
            <p>عنوان: {{ $ticket->title }}</p>
            <p>اولویت: {{ $ticket->priority_text }}</p>
            <p>وضعیت: {{ $ticket->status_text }}</p>
        </div>
    </div>
    <div class="footer">
        <a href="{{ route('dashboard.tickets.show', $ticket->uuid) }}">
            برای مشاهده تیکت کلیک کنید :
            <span dir="ltr">{{'#'.$ticket->uuid}}</span>
        </a>
    </div>

</div>
</body>
</html>
