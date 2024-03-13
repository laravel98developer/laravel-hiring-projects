<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>وضعیت پرداخت</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>

</head>

<body>
    <div class="container">

        <div class="mt-4">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">بازگشت</a>
                </li>
            </ul>
        </div>


        <div class="row mt-5">
            <div class="alert @if ($data['status'] == 'success') alert-success @else alert-danger @endif" role="alert">
                {{ $data['message'] }}
            </div>
        </div>

    </div>
</body>

</html>
