    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Laporan Kelengkapan ATP</title>
        <style>
            body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10pt; }
            .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
            .header h1 { margin: 0; font-size: 14pt; }
            .header p { margin: 2px 0; }
            h2 { font-size: 12pt; margin-top: 20px; margin-bottom: 5px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid #ccc; padding: 6px; text-align: left; }
            th { background-color: #f2f2f2; font-size: 9pt;}
            .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 8pt; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>LAPORAN REKAPITULASI KELENGKAPAN</h1>
            <h1>ALUR TUJUAN PEMBELAJARAN (ATP)</h1>
            <p>{{ strtoupper($schoolProfile['school_name'] ?? 'Nama Sekolah') }}</p>
        </div>

        @foreach($teachers as $teacher)
            <h2>Guru: {{ $teacher->name }}</h2>
            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Nama ATP</th>
                        <th style="width: 30%;">Konteks</th>
                        <th style="width: 20%;">Status Validasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teacher->teachingFlows as $flow)
                    <tr>
                        <td>{{ $flow->name }}</td>
                        <td>{{ $flow->subject->name }} / {{ $flow->gradeLevel->name }}</td>
                        <td>{{ $flow->status }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; font-style: italic;">Belum ada ATP yang dibuat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endforeach

        <div class="footer">
            Laporan ini digenerate oleh sistem pada tanggal {{ date('d F Y') }}
        </div>
    </body>
    </html>
    