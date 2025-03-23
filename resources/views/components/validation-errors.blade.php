@if ($errors->any())
    <div {{ $attributes }}>
        <div class="font-medium text-red-400">{{ __('Ups! Něco se pokazilo.') }}</div>

        <ul class="mt-3 list-disc list-inside text-sm text-red-400">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
