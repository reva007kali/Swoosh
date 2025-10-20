<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Member Card</title>
    <style>
        body {
            margin: 0;
        }

        .card {
            width: 340px;
            height: 200px;
            background-color: #0f4c81;
            color: white;
            font-family: Arial, sans-serif;
            border-radius: 15px;
            padding: 20px;
            position: relative;
        }

        .logo {
            border-radius: 50%;
            position: absolute;
            top: 15px;
            left: 15px;
            width: 50px;
            height: 50px;
        }

        .qr-code {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 80px;
            height: 80px;
        }

        .member-id {
            position: absolute;
            bottom: 20px;
            left: 15px;
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
        }

        .center {
            text-align: center;
            margin-top: 50px;
        }

        .name {
            font-size: 18px;
            font-weight: bold;
        }

        .joined {
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="card">
        <!-- Logo -->
        <img src="{{ public_path('image/swoosh-logo.jpg') }}" class="logo" alt="Logo">

        <!-- Name & joined -->
        <div class="center">
            <div class="name">{{ $member->name }}</div>
            <div class="joined">Joined: {{ \Carbon\Carbon::parse($member->join_at)->format('d M Y') }}</div>
        </div>

        <!-- QR Code -->
        <div class="absolute bottom-4 right-4 w-20 h-20 bg-white p-2 rounded-lg flex items-center justify-center">
            {!! $qrCodeSvg !!}
        </div>

        <!-- Member ID -->
        <div class="member-id">
            Member ID: {{ $member->id }}
        </div>
    </div>
    <div class="card">
        <!-- Logo -->
        <img src="{{ public_path('image/swoosh-logo.jpg') }}" class="logo" alt="Logo">


        <!-- QR Code -->
        <div class="absolute bottom-4 right-4 w-20 h-20 bg-white p-2 rounded-lg flex items-center justify-center">
            {!! $qrCodeSvg !!}
        </div>

        <!-- Member ID -->
        <div class="member-id">
            Member ID: {{ $member->id }}
        </div>
    </div>
</body>

</html>
