<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student ID Card - {{ $student->name }}</title>
    <style>
        @page { 
            margin: 0; 
            font-family: 'Helvetica', sans-serif;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
        }
        .card-container {
            width: 2.125in; /* 53.98mm */
            height: 3.375in; /* 85.6mm */
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            background-color: #ffffff;
        }
        .header {
            background-color: #003366; /* Deep Blue */
            color: white;
            padding: 10px 5px;
            text-align: center;
        }
        .header img {
            width: 40px;
            height: 40px;
            margin-bottom: 5px;
        }
        .header h1 {
            margin: 0;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .photo {
            text-align: center;
            margin-top: 15px;
        }
        .photo img {
            width: 90px;
            height: 90px;
            border-radius: 8px;
            border: 3px solid #003366;
            object-fit: cover;
        }
        .student-name {
            font-size: 14px;
            font-weight: bold;
            margin-top: 10px;
            color: #003366;
            text-align: center;
        }
        .info-section {
            padding: 0 15px;
            margin-top: 15px;
            font-size: 10px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 2px 0;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 40%;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            background-color: #003366;
            color: white;
            font-size: 8px;
            padding: 5px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="header">
            @if(isset($school_info['logo']) && file_exists($school_info['logo']))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($school_info['logo'])) }}" alt="School Logo">
            @endif
            <h1>{{ $school_info['name'] }}</h1>
        </div>

        <div class="photo">
            @if($student->image && file_exists(public_path('storage/' . $student->image)))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('storage/' . $student->image))) }}" alt="Student Photo">
            @else
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('default-avatar.png'))) }}" alt="Default Avatar">
            @endif
        </div>

        <div class="student-name">{{ $student->name }}</div>
        
        <div class="info-section">
            <table class="info-table">
                <tr>
                    <td>ID</td>
                    <td>: STD-{{ str_pad($student->id, 5, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td>Class</td>
                    <td>: {{ $student->schoolClass->name }}</td>
                </tr>
                <tr>
                    <td>Section</td>
                    <td>: {{ $student->schoolClass->section ?? 'N/A' }}</td>
                </tr>
                 <tr>
                    <td>Roll</td>
                    <td>: {{ $student->roll_number }}</td>
                </tr>
                <tr>
                    <td>Blood Group</td>
                    <td>: {{-- Add blood_group to students table if needed --}}</td>
                </tr>
            </table>
        </div>

        <div class="footer">
            {{-- Add validity date or address if needed --}}
            www.yourschoolwebsite.com
        </div>
    </div>
</body>
</html>