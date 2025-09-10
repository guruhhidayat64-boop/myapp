<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>ATP: {{ $flow->name }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        h1 { margin: 0; font-size: 14pt; }
        p { margin: 2px 0; }
        h2 { font-size: 12pt; margin-top: 20px; margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; font-size: 9pt;}
        .footer { position: fixed; bottom: 0px; left: 0px; right: 0px; height: 100px; }
        .validation-box { border: 1px solid #000; padding: 10px; font-size: 9pt; }
        .validation-box table { border: none; width: 100%; }
        .validation-box td { border: none; padding: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>ALUR TUJUAN PEMBELAJARAN (ATP)</h1>
        <p><strong>{{ strtoupper($flow->name) }}</strong></p>
        <p>Mata Pelajaran: {{ $flow->subject->name }} | Tingkat Kelas: {{ $flow->gradeLevel->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">Urutan</th>
                <th>Tujuan Pembelajaran (TP)</th>
                <th style="width: 15%;">Elemen</th>
                <th style="width: 10%;">Perkiraan JP</th>
                <th style="width: 25%;">Materi / Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($flow->learningObjectives as $objective)
                <tr>
                    <td style="text-align: center;">{{ $objective->pivot->order + 1 }}</td>
                    <td>{{ $objective->description }}</td>
                    <td>{{ $objective->element->name ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ $objective->pivot->estimated_hours }}</td>
                    <td>{{ $objective->pivot->notes }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Belum ada Tujuan Pembelajaran yang disusun dalam alur ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- ==================== BAGIAN VALIDASI BARU ==================== -->
    @if($flow->status == 'Disetujui' && $qrCode)
    <div class="footer">
        <div class="validation-box">
            <table>
                <tr>
                    <td style="width: 75%;">
                        <strong>Dokumen ini telah divalidasi dan disetujui secara digital oleh sistem.</strong><br>
                        Status: {{ $flow->status }}<br>
                        Tanggal Validasi: {{ \Carbon\Carbon::parse($flow->validated_at)->isoFormat('D MMMM YYYY') }}<br>
                        Validator: {{ \App\Models\User::find($flow->validated_by)->name ?? 'N/A' }}
                    </td>
                    <td style="width: 25%; text-align: right;">
                        {!! $qrCode !!}
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @endif
    <!-- =============================================================== -->
</body>
</html>
