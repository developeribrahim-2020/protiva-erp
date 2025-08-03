<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Academic Transcript</title>
    <style>
        @page {
            margin: 0;
            font-family: 'Helvetica', sans-serif;
        }
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 25px;
            font-size: 12px;
            color: #333;
        }
        .container {
            border: 2px double #003366;
            padding: 20px;
            position: relative;
            height: 94%;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            opacity: 0.1;
            font-size: 70px;
            font-weight: bold;
            color: #999;
            z-index: -1;
            width: 100%;
            text-align: center;
            text-transform: uppercase;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
        }
        .header img {
            width: 70px;
            height: 70px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            color: #003366;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 14px;
        }
        .header h3 {
            background-color: #003366;
            color: white;
            padding: 5px;
            display: inline-block;
            border-radius: 5px;
            margin-top: 10px;
            font-size: 16px;
        }
        .info-table, .marks-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .info-table td {
            padding: 6px;
            border: 1px solid #ddd;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 15%;
        }
        .marks-table th, .marks-table td {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: center;
        }
        .marks-table th {
            background-color: #e9ecef;
            color: #333;
            font-weight: bold;
        }
        .summary-section {
            width: 100%;
            margin-top: 20px;
            float: left; /* এটি যোগ করা হয়েছে যাতে সিগনেচারের সাথে ওভারল্যাপ না হয় */
        }
        .summary-table {
            width: 45%;
            float: right;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 8px;
            border: 1px solid #aaa;
        }
        .summary-table td:first-child {
            font-weight: bold;
        }
        .footer-signatures {
            position: absolute;
            bottom: 40px;
            left: 20px;
            width: calc(100% - 40px);
        }
        .footer-signatures table {
            width: 100%;
            border: none;
            /* যে পরিবর্তনটি করা হয়েছে */
            border-spacing: 40px 0;
            border-collapse: separate;
        }
        .footer-signatures td {
            width: 33.33%;
            text-align: center;
            padding-top: 40px;
            border-top: 1px dotted #333;
        }
    </style>
</head>
<body>
    @php
        $optionalSubjectName = 'H.math'; // ঐচ্ছিক বিষয়ের নাম
        $totalMarks = 0;
        $mandatoryGradePoints = [];
        $optionalSubjectGradePoint = null;
        $mandatorySubjectCount = 0;

        foreach($student->marks as $mark) {
            $totalMarks += $mark->marks;
            $grade = \App\Helpers\ResultHelper::calculateGrade($mark->marks);
            
            if (strcasecmp($mark->subject->name, $optionalSubjectName) == 0) {
                $optionalSubjectGradePoint = (float)$grade->grade_point;
            } else {
                $mandatoryGradePoints[] = (float)$grade->grade_point;
                $mandatorySubjectCount++;
            }
        }
        $gpaResult = \App\Helpers\ResultHelper::calculateGpa($mandatoryGradePoints, $optionalSubjectGradePoint, $mandatorySubjectCount);
    @endphp

    <div class="container">
        <div class="watermark">{{ $school_info['name'] }}</div>
        
        <div class="header">
            @if(isset($school_info['logo']) && file_exists($school_info['logo']))
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents($school_info['logo'])) }}" alt="School Logo">
            @endif
            <h1>{{ $school_info['name'] }}</h1>
            <p>{{ $school_info['address'] }}</p>
            <h3>ACADEMIC TRANSCRIPT</h3>
        </div>
        
        <p style="text-align:center; font-weight:bold; font-size: 16px;">{{ $exam->name }}</p>

        <table class="info-table">
            <tr>
                <td>Student's Name</td>
                <td>{{ $student->name }}</td>
                <td>Roll No</td>
                <td>{{ $student->roll_number }}</td>
            </tr>
            <tr>
                <td>Class</td>
                <td>{{ $student->schoolClass->name }} {{ $student->schoolClass->section ? '- ' . $student->schoolClass->section : '' }} {{ $student->schoolClass->group ? '('.$student->schoolClass->group.')' : '' }}</td>
                <td>Session</td>
                <td>{{ date('Y', strtotime($exam->created_at)) }}</td>
            </tr>
        </table>

        <table class="marks-table">
            <thead>
                <tr>
                    <th style="width: 40%;">Subject</th>
                    <th>Full Marks</th>
                    <th>Obtained Marks</th>
                    <th>Letter Grade</th>
                    <th>Grade Point</th>
                </tr>
            </thead>
            <tbody>
                @forelse($student->marks as $mark)
                    @php
                        $grade = \App\Helpers\ResultHelper::calculateGrade($mark->marks);
                    @endphp
                    <tr>
                        <td style="text-align: left; padding-left: 10px;">{{ $mark->subject->name }}</td>
                        <td>100</td>
                        <td>{{ round($mark->marks) }}</td>
                        <td>{{ $grade->grade }}</td>
                        <td>{{ number_format($grade->grade_point, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No marks available for this student.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(count($student->marks) > 0)
            <div class="summary-section">
                <table class="summary-table">
                    <tr>
                        <td>Total Marks Obtained</td>
                        <td><strong>{{ $totalMarks }}</strong></td>
                    </tr>
                    <tr>
                        <td>Grade Point Average (GPA)</td>
                        <td><strong>{{ $gpaResult->gpa }}</strong></td>
                    </tr>
                    <tr>
                        <td>Final Grade</td>
                        <td><strong>{{ $gpaResult->grade }}</strong></td>
                    </tr>
                </table>
            </div>
        @endif
        
        <div class="footer-signatures">
             <table>
                <tr>
                    <td>Guardian's Signature</td>
                    <td>Class Teacher's Signature</td>
                    <td>Headmaster's Signature</td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>