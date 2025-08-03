<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Staff ID Card - {{ $staff->name }}</title>
    <style>
        @page { margin: 0; font-family: 'Helvetica', sans-serif; }
        .card-container {
            width: 3.375in; height: 2.125in; border: 1px solid #ccc;
            border-radius: 10px; overflow: hidden; position: relative;
            background-color: #ffffff; text-align: center;
        }
        .header { background-color: #003366; color: white; padding: 8px 0; }
        .header h1 { margin: 0; font-size: 10px; font-weight: bold; text-transform: uppercase; }
        .photo { margin-top: 15px; }
        .photo img { width: 75px; height: 75px; border-radius: 50%; border: 3px solid #003366; object-fit: cover; }
        .staff-name { font-size: 14px; font-weight: bold; margin-top: 8px; color: #003366; }
        .staff-designation { font-size: 10px; color: #555; margin-top: 2px; }
        .info { font-size: 9px; margin-top: 10px; }
        .footer { position: absolute; bottom: 0; width: 100%; background-color: #003366; color: white; font-size: 8px; padding: 4px 0; }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="header"><h1>{{ config('app.name', 'Protiva ERP') }}</h1></div>
        <div class="photo">
            @if($staff->image && file_exists(public_path('storage/' . $staff->image)))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $staff->image))) }}" alt="Photo">
            @else
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('default-avatar.png'))) }}" alt="Avatar">
            @endif
        </div>
        <div class="staff-name">{{ $staff->name }}</div>
        <div class="staff-designation">{{ $staff->designation }}</div>
        <div class="info">
            <strong>ID:</strong> STAFF-{{ str_pad($staff->id, 4, '0', STR_PAD_LEFT) }} <br>
            <strong>Phone:</strong> {{ $staff->phone }} <br>
            <strong>Joining Date:</strong> {{ \Carbon\Carbon::parse($staff->joining_date)->format('d M, Y') }}
        </div>
        <div class="footer">School Address Here</div>
    </div>
</body>
</html>