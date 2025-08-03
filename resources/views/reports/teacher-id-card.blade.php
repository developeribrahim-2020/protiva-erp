<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Teacher ID Card - {{ $teacher->name }}</title>
    <style>
        @page {
            margin: 0;
            font-family: 'Helvetica', sans-serif;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            text-align: center;
        }
        .card-container {
            width: 3.375in; /* 85.6mm */
            height: 2.125in; /* 53.98mm */
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-color: #ffffff;
        }
        .header {
            background-color: #003366; /* Deep Blue */
            color: white;
            padding: 8px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .photo {
            margin-top: 15px;
        }
        .photo img {
            width: 75px;
            height: 75px;
            border-radius: 50%;
            border: 3px solid #003366;
            object-fit: cover;
        }
        .teacher-name {
            font-size: 14px;
            font-weight: bold;
            margin-top: 8px;
            color: #003366;
        }
        .teacher-designation {
            font-size: 10px;
            color: #555;
            margin-top: 2px;
        }
        .info {
            font-size: 9px;
            margin-top: 10px;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #003366;
            color: white;
            font-size: 8px;
            padding: 4px 0;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="header">
            <h1>{{ $school_info['name'] }}</h1>
        </div>

        <div class="photo">
            @if($teacher->image && file_exists(public_path('storage/' . $teacher->image)))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $teacher->image))) }}" alt="Teacher Photo">
            @else
                {{-- Placeholder image or default avatar --}}
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('default-avatar.png'))) }}" alt="Default Avatar">
                {{-- দ্রষ্টব্য: public ফোল্ডারে default-avatar.png নামে একটি ছবি রাখুন --}}
            @endif
        </div>

        <div class="teacher-name">{{ $teacher->name }}</div>
        <div class="teacher-designation">{{ $teacher->designation }}</div>
        
        <div class="info">
            <strong>ID:</strong> TCH-{{ str_pad($teacher->id, 4, '0', STR_PAD_LEFT) }} <br>
            <strong>Phone:</strong> {{ $teacher->phone }} <br>
            <strong>Joining Date:</strong> {{ \Carbon\Carbon::parse($teacher->joining_date)->format('d M, Y') }}
        </div>

        <div class="footer">
            {{ $school_info['address'] }}
        </div>
    </div>
</body>
</html>