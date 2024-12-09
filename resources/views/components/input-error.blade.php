@props(['messages'])

@if ($messages)
    <div class="label">
        <span class="label-text-alt text-error">
            @foreach ((array) $messages as $message)
                {{ $message }}
            @endforeach
        </span>
    </div>
@endif
