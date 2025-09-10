<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CalendarController;

// --- CONTROLLER UNTUK ADMIN ---
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\PhaseController;
use App\Http\Controllers\Admin\GradeLevelController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\ElementController;
use App\Http\Controllers\Admin\LearningOutcomeController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController; // Alias untuk Admin
use App\Http\Controllers\Admin\StudentClassController;
use App\Http\Controllers\Admin\MentorshipGroupController;

// --- CONTROLLER UNTUK GURU ---
use App\Http\Controllers\Teacher\LearningObjectiveController;
use App\Http\Controllers\Teacher\TeachingFlowController;
use App\Http\Controllers\Teacher\LessonPlanController;
use App\Http\Controllers\Teacher\KktpController;
use App\Http\Controllers\Teacher\HomeroomController;
use App\Http\Controllers\Teacher\MentorshipController;
use App\Http\Controllers\Teacher\GradebookController;
use App\Http\Controllers\Teacher\QuestionBankController;
use App\Http\Controllers\Teacher\PortfolioController;
use App\Http\Controllers\Teacher\ReportCardController;

// --- CONTROLLER UNTUK KEPALA SEKOLAH ---
use App\Http\Controllers\Headmaster\MonitoringController;

// --- CONTROLLER UNTUK SISWA ---
use App\Http\Controllers\Student\StudentController; // Ini tetap StudentController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // RUTE UMUM (KALENDER)
    Route::get('calendar', [CalendarController::class, 'index'])->name('calendar.index');
    Route::get('calendar/events', [CalendarController::class, 'getEvents'])->name('calendar.events');
    Route::post('calendar/events', [CalendarController::class, 'store'])->name('calendar.events.store');
    Route::put('calendar/events/{event}', [CalendarController::class, 'update'])->name('calendar.events.update');
    Route::delete('calendar/events/{event}', [CalendarController::class, 'destroy'])->name('calendar.events.destroy');

    // GRUP RUTE ADMIN
    Route::middleware('role:admin')->name('admin.')->prefix('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('profil-sekolah', [SchoolProfileController::class, 'index'])->name('school_profile.index');
        Route::post('profil-sekolah', [SchoolProfileController::class, 'update'])->name('school_profile.update');
        Route::resource('phases', PhaseController::class);
        Route::resource('grade-levels', GradeLevelController::class);
        Route::resource('subjects', SubjectController::class);
        Route::resource('elements', ElementController::class);
        Route::resource('learning-outcomes', LearningOutcomeController::class);
        Route::resource('classes', ClassController::class);
        Route::get('assignments', [AssignmentController::class, 'index'])->name('assignments.index');
        Route::post('assignments/homeroom', [AssignmentController::class, 'storeHomeroom'])->name('assignments.storeHomeroom');
        Route::post('assignments/teaching', [AssignmentController::class, 'storeTeaching'])->name('assignments.storeTeaching');
        Route::delete('assignments/teaching/{userId}/{subjectId}/{classId}', [AssignmentController::class, 'destroyTeaching'])->name('assignments.destroyTeaching');
        Route::resource('students', AdminStudentController::class); // Menggunakan alias
        Route::post('students/import', [AdminStudentController::class, 'import'])->name('students.import');
        Route::get('students/import-template', [AdminStudentController::class, 'downloadTemplate'])->name('students.downloadTemplate');
        Route::get('student-classes', [StudentClassController::class, 'index'])->name('student_classes.index');
        Route::post('student-classes/assign', [StudentClassController::class, 'assignStudent'])->name('student_classes.assign');
        Route::post('student-classes/unassign', [StudentClassController::class, 'unassignStudent'])->name('student_classes.unassign');
        Route::resource('mentorship-groups', MentorshipGroupController::class)->except(['create', 'edit', 'update']);
        Route::post('mentorship-groups/assign', [MentorshipGroupController::class, 'assignStudent'])->name('mentorship-groups.assign');
        Route::post('mentorship-groups/unassign', [MentorshipGroupController::class, 'unassignStudent'])->name('mentorship-groups.unassign');
    });

    // GRUP RUTE GURU & KEPALA SEKOLAH
    Route::middleware('role:guru,kepala_sekolah')->name('teacher.')->prefix('guru')->group(function () {
        Route::resource('learning-objectives', LearningObjectiveController::class);
        Route::post('learning-objectives/generate-ai', [LearningObjectiveController::class, 'generateAi'])->name('learning-objectives.generateAi');
        Route::resource('teaching-flows', TeachingFlowController::class);
        Route::post('teaching-flows/generate-atp-ai', [TeachingFlowController::class, 'generateAtpAi'])->name('teaching-flows.generateAtpAi');
        Route::get('lesson-plans/start', [LessonPlanController::class, 'start'])->name('lesson-plans.start');
        Route::resource('lesson-plans', LessonPlanController::class);
        Route::post('lesson-plans/generate-ai-section', [LessonPlanController::class, 'generateAiSection'])->name('lesson-plans.generateAiSection');
        Route::get('kktp/{learning_objective}', [KktpController::class, 'index'])->name('kktp.index');
        Route::post('kktp/{learning_objective}', [KktpController::class, 'store'])->name('kktp.store');
        Route::get('homeroom', [HomeroomController::class, 'index'])->name('homeroom.index');
        Route::get('homeroom/print-attendance', [HomeroomController::class, 'printAttendance'])->name('homeroom.printAttendance');
        Route::get('mentorship', [MentorshipController::class, 'index'])->name('mentorship.index');
        Route::get('mentorship/student/{student}', [MentorshipController::class, 'showStudentJournal'])->name('mentorship.student.show');
        Route::post('mentorship/student/{student}/log', [MentorshipController::class, 'storeDevelopmentLog'])->name('mentorship.student.log.store');
        Route::get('gradebook', [GradebookController::class, 'selectContext'])->name('gradebook.select');
        Route::get('gradebook/{class}/{subject}', [GradebookController::class, 'index'])->name('gradebook.index');
        Route::post('gradebook/assessment', [GradebookController::class, 'storeAssessment'])->name('gradebook.assessment.store');
        Route::post('gradebook/grade', [GradebookController::class, 'storeGrade'])->name('gradebook.grade.store');
        Route::resource('question-bank', QuestionBankController::class);
        Route::get('portfolio/student/{student}', [PortfolioController::class, 'show'])->name('portfolio.show');
        Route::get('report-cards', [ReportCardController::class, 'index'])->name('report-cards.index');
        Route::get('report-cards/student/{student}', [ReportCardController::class, 'show'])->name('report-cards.show');
        Route::post('report-cards/generate-narrative', [ReportCardController::class, 'generateNarrative'])->name('report-cards.generateNarrative');
    });

    // GRUP RUTE KEPALA SEKOLAH
    Route::middleware('role:kepala_sekolah')->name('headmaster.')->prefix('kepala-sekolah')->group(function () {
        Route::get('monitoring/atp', [MonitoringController::class, 'monitorAtp'])->name('monitoring.atp');
        Route::get('monitoring/modul-ajar', [MonitoringController::class, 'monitorLessonPlans'])->name('monitoring.lessonPlans');
        Route::post('monitoring/atp/{teaching_flow}/validate', [MonitoringController::class, 'validateAtp'])->name('monitoring.atp.validate');
        Route::post('monitoring/modul-ajar/{lesson_plan}/validate', [MonitoringController::class, 'validateLessonPlan'])->name('monitoring.lessonPlans.validate');
        Route::get('laporan/atp', [MonitoringController::class, 'reportAtp'])->name('report.atp');
        Route::get('laporan/atp/download', [MonitoringController::class, 'downloadReportAtp'])->name('report.atp.download');
    });

    // GRUP RUTE SISWA
    Route::middleware('role:siswa')->name('student.')->prefix('siswa')->group(function () {
        Route::get('dashboard', [StudentController::class, 'index'])->name('dashboard');
        Route::get('portfolio', [StudentController::class, 'portfolio'])->name('portfolio');
        Route::get('learning-map', [StudentController::class, 'learningMap'])->name('learning-map');
    });

    // API RUTE
    Route::get('/api/grade-levels/{phase_id}', [LearningObjectiveController::class, 'getGradeLevels']);
    Route::get('/api/subjects', [LearningObjectiveController::class, 'getSubjects']);
    Route::get('/api/elements-and-cp', [LearningObjectiveController::class, 'getElementsAndCp']);
});

require __DIR__.'/auth.php';
