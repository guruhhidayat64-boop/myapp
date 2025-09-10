<x-app-layout>
    <x-slot name="header">
        Portofolio Nilai Saya
    </x-slot>

    <div class="space-y-6">
        @forelse ($gradesBySubject as $subjectName => $grades)
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-lg font-bold text-gray-800">{{ $subjectName }}</h3>

                <div class="mt-4 space-y-4">
                    @foreach ($grades as $grade)
                        <div class="border rounded-md p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-semibold">{{ $grade->assessment->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $grade->assessment->type }}</p>
                                </div>
                                <p class="text-2xl font-bold text-blue-600 ml-4">{{ $grade->score }}</p>
                            </div>
                            <div class="mt-2 text-xs text-gray-500 border-t pt-2">
                                <p><strong>TP yang Diukur:</strong></p>
                                <ul class="list-disc list-inside pl-2">
                                    @foreach ($grade->assessment->learningObjectives as $objective)
                                        <li>{{ $objective->description }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="p-6 bg-white rounded-lg shadow-md text-center text-gray-500">
                <p>Anda belum memiliki nilai untuk ditampilkan.</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
