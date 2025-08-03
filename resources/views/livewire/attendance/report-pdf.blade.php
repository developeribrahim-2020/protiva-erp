```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: center; padding: 4px; font-size: 10px; }
        th { background-color: #f2f2f2; }
        .present { color: green; }
        .absent { color: red; }
        .late { color: orange; }
    </style>
</head>
<body>
    <h2>Attendance Report for {{ $className }} - {{ \Carbon\Carbon::parse($selectedMonth)->format('F Y') }}</h2>
    <table>
        <thead>
            <tr>
                <th>Roll</th>
                <th style="text-align: left; padding-left: 5px;">Name</th>
                @foreach($daysInMonth as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->roll_number }}</td>
                    <td style="text-align: left; padding-left: 5px;">{{ $student->name }}</td>
                    @foreach($daysInMonth as $day)
                        <td>
                            @php
                                $status = $attendances[$student->id][$day] ?? null;
                                $class = '';
                                $char = '-';
                                if ($status === 'present') {
                                    $class = 'present';
                                    $char = 'P';
                                } elseif ($status === 'absent') {
                                    $class = 'absent';
                                    $char = 'A';
                                } elseif ($status === 'late') {
                                    $class = 'late';
                                    $char = 'L';
                                }
                            @endphp
                            <span class="{{ $class }}">{{ $char }}</span>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
```