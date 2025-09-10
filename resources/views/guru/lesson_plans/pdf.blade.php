<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Modul Ajar: {{ $lessonPlan->title }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 1.5rem; }
        .header h1 { margin: 0; font-size: 14pt; font-weight: bold; text-transform: uppercase; }
        section { margin-bottom: 1.5rem; }
        .section-title { font-size: 12pt; font-weight: bold; border-bottom: 1px solid #000; padding-bottom: 3px; margin-bottom: 1rem; }
        h3 { font-size: 12pt; font-weight: bold; margin-bottom: 0.5rem; margin-top: 1rem; }
        ul { padding-left: 20px; margin-top: 0.5rem; list-style-position: outside; }
        li { margin-bottom: 0.5rem; }
        p { margin-top: 0.5rem; margin-bottom: 0.5rem; text-align: justify; }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        .info-table td { vertical-align: top; padding-bottom: 5px; }
        
        .validation-box { border: 1px solid #000; padding: 10px; font-size: 9pt; }
        .validation-box table { border: none; width: 100%; }
        .validation-box td { border: none; padding: 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>MODUL AJAR</h1>
        <h1>{{ strtoupper($lessonPlan->title) }}</h1>
    </div>

    <section>
        <div class="section-title">A. Informasi Umum</div>
        @php
            $schoolName = \App\Models\Setting::where('key', 'school_name')->first()->value ?? 'Nama Sekolah Belum Diatur';
        @endphp
        <table class="info-table">
            <tr>
                <td style="width: 33%;"><strong>Penyusun:</strong><br>{{ $lessonPlan->user->name }}</td>
                <td style="width: 33%;"><strong>Mata Pelajaran:</strong><br>{{ $lessonPlan->subject->name }}</td>
                <td style="width: 33%;"><strong>Kelas / Fase:</strong><br>{{ $lessonPlan->gradeLevel->name }} / {{ $lessonPlan->gradeLevel->phase->name }}</td>
            </tr>
            <tr>
                <td><strong>Alokasi Waktu:</strong><br>{{ $lessonPlan->duration_in_minutes ?? 'N/A' }} menit</td>
                <td><strong>Tahun Ajaran:</strong><br>{{ $lessonPlan->academic_year }}</td>
                <td><strong>Semester:</strong><br>{{ $lessonPlan->semester }}</td>
            </tr>
             <tr>
                <td colspan="3"><strong>Sekolah:</strong><br>{{ $schoolName }}</td>
            </tr>
        </table>
    </section>
    
    <section>
        <div class="section-title">B. Komponen Inti</div>
        <h3>1. Tujuan Pembelajaran</h3>
        <ul>
            @foreach ($lessonPlan->learningObjectives as $objective)
                <li>{{ $objective->description }}</li>
            @endforeach
        </ul>
        
        <h3>2. Dimensi Profil Lulusan</h3>
        <p>{{ implode(', ', $lessonPlan->graduate_profile_dimensions ?? []) ?: 'Tidak ada.' }}</p>

        <h3>3. Praktik Pedagogis</h3>
        <p>{{ $lessonPlan->pedagogical_practices ?? 'Tidak ada.' }}</p>
    </section>

    <section>
        <div class="section-title">C. Pengalaman Belajar</div>
        <h3>Memahami</h3>
        <p>{!! nl2br(e($lessonPlan->learning_activities['memahami']['description'] ?? 'Tidak ada.')) !!}</p>
        
        <h3>Mengaplikasi</h3>
        <p>{!! nl2br(e($lessonPlan->learning_activities['mengaplikasi']['description'] ?? 'Tidak ada.')) !!}</p>

        <h3>Merefleksi</h3>
        <p>{!! nl2br(e($lessonPlan->learning_activities['merefleksi']['description'] ?? 'Tidak ada.')) !!}</p>
    </section>

    <section>
        <div class="section-title">D. Asesmen Pembelajaran</div>
        <h3>Asesmen pada Awal Pembelajaran</h3>
        <p>{{ $lessonPlan->initial_assessment ?? 'Tidak ada.' }}</p>
        <h3>Asesmen Formatif</h3>
        <p>{!! nl2br(e($lessonPlan->assessment['formatif'] ?? 'Tidak ada.')) !!}</p>
        <h3>Asesmen Sumatif</h3>
        <p>{!! nl2br(e($lessonPlan->assessment['sumatif'] ?? 'Tidak ada.')) !!}</p>
    </section>

    <!-- ==================== BAGIAN VALIDASI BARU ==================== -->
@if(isset($qrCode) && $qrCode)
<div class="validation-box" style="margin-top: 2rem;">
    <table>
        <tr>
            <td style="width: 75%;">
                <strong>Dokumen ini telah divalidasi dan disetujui secara digital oleh sistem.</strong><br>
                Status: {{ $lessonPlan->status }}<br>
                Tanggal Validasi: {{ \Carbon\Carbon::parse($lessonPlan->validated_at)->isoFormat('D MMMM YYYY') }}<br>
                Validator: {{ \App\Models\User::find($lessonPlan->validated_by)->name ?? 'N/A' }}
            </td>
            <td style="width: 25%; text-align: right;">
                {!! $qrCode !!}
            </td>
        </tr>
    </table>
</div>
@endif
<!-- =============================================================== -->

    <script type="text/javascript">
        if (window.location.href.includes('/print')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>
