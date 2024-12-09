@props(['value' => '', 'required' => false])

<label {{ $attributes->merge(['class' => 'label']) }}>
    <span class="label-text">{{ $value ?: $slot }}</span>
    @if($required)
        <span class="label-text-alt text-error">*</span>
    @endif
</label>
