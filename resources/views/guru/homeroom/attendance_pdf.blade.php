<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Hadir - {{ $homeroomClass->name }}</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0.5in;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 9pt;
        }

        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 14pt;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10pt;
        }

        .info-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 10pt;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th,
        .attendance-table td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }

        .student-name {
            text-align: left;
        }

        .date-col {
            width: 2%;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>DAFTAR HADIR SISWA</h1>
        <p>{{ strtoupper($schoolProfile['school_name'] ?? 'Nama Sekolah') }}</p>
    </div>

    <table class="info-table">
        <tr>
            <td style="width: 15%;"><strong>Kelas</strong></td>
            <td style="width: 35%;">: {{ $homeroomClass->name }}</td>
            <td style="width: 15%;"><strong>Bulan</strong></td>
            <td style="width: 35%;">: {{ $month }}</td>
        </tr>
        <tr>
            <td><strong>Wali Kelas</strong></td>
            <td>: {{ $homeroomClass->homeroomTeacher->name ?? 'N/A' }}</td>
            <td><strong>Tahun Ajaran</strong></td>
            <td>: {{ $year }}</td>
        </tr>
    </table>

    <table class="attendance-table">
        <thead>
            <tr>
                <th rowspan="2" style="width: 3%;">No</th>
                <th rowspan="2" style="width: 25%;">Nama Siswa</th>
                <th colspan="{{ $daysInMonth }}">Pertemuan Tanggal</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <th class="date-col">{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($homeroomClass->students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="student-name">{{ $student->name }}</td>
                    @for ($i = 1; $i <= $daysInMonth; $i++)
                        <td></td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>

    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
