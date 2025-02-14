@extends('layouts.parent')

@section('content')
    <div class="container mx-auto px-4 py-10 lg:pl-72">
        <h1 class="text-4xl font-bold text-gray-800 text-center mt-16 mb-10">
            {{ $members->name }} {{ $members->surname }}
        </h1>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if ($attendances->isNotEmpty())
            <div
                class="overflow-x-auto rounded-xl shadow-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                <table class="min-w-full text-sm text-gray-800 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                        <tr>
                            <th class="py-4 px-6 text-left font-medium">Akce</th>
                            <th class="py-4 px-6 text-left font-medium">Popis</th>
                            <th class="py-4 px-6 text-left font-medium">Začátek</th>
                            <th class="py-4 px-6 text-left font-medium">Konec</th>
                            <th class="py-4 px-6 text-center font-medium">Potvrzení</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 transition"
                                id="row-{{ $attendance->id }}">
                                <td class="py-4 px-6">
                                    <p class="font-semibold text-gray-800 dark:text-white">
                                        {{ $attendance->event->title }}
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="text-gray-600 dark:text-gray-400 truncate max-w-sm">
                                        {{ $attendance->event->description }}
                                    </p>
                                </td>
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($attendance->event->start_date)->format('d.m.Y H:i') }}
                                </td>
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($attendance->event->end_date)->format('d.m.Y H:i') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <form method="POST" class="ajax-confirm-form"
                                        action="{{ route('attendance.confirm', $attendance->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 text-sm font-medium text-white bg-green-500 rounded-lg shadow-md hover:bg-green-600 focus:ring-2 focus:ring-green-300 dark:focus:ring-green-700 focus:outline-none transition">
                                            Potvrdit účast
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center mt-16">
                <h2 class="text-2xl font-semibold text-purple-800">
                    Žádné akce nepotřebují potvrzení!
                </h2>
            </div>
        @endif
    </div>
    <script>
        $('.ajax-confirm-form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const actionUrl = form.attr('action');
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            submitButton.prop('disabled', true).text('Potvrzování...');

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        const rowId = `row-${response.attendance_id}`;
                        $(`#${rowId}`).fadeOut(300, function() {
                            $(this).remove();
                        });
                    }
                },
                error: function(xhr) {
                    alert('Nepodařilo se kontaktovat server. Zkuste to později.');
                    console.error('Error:', xhr.responseText);
                },
            });
            return false;
        });
    </script>

@endsection
