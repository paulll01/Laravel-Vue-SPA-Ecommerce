@props([
    'label' => '',
    'name' => '',
    'wireModel' => '',
    'col' => 'col-12',
    'multiple' => null,
    'oldImage' => null,
    'oldGallery' => null,
    'folder' => '',
])

@php
    $boundValue = isset($$wireModel) ? $$wireModel : null;
@endphp


@php
    $boundValue = $wireModel ? $this->{$wireModel} ?? null : null;
@endphp

<div class="{{ $col }} mb-4">
    <label class="form-label">{{ $label }}</label>

    @if ($oldImage && $folder)
        <div class="mb-2">
            <img src="{{ asset('storage/' . $folder . '/' . $oldImage) }}" alt="Old Image" class="img-thumbnail h-150"
                width="150" height="150">
        </div>
    @endif

    @if ($oldGallery && $folder)
        <div class="d-flex flex-wrap gap-2 mb-2">
            @foreach (explode(' ', $oldGallery) as $img)
                <img src="{{ asset('storage/' . $folder . '/' . $img) }}" alt="Gallery" class="img-thumbnail h-150"
                    width="150" height="150">
            @endforeach
        </div>
    @endif


    {{-- Show new image preview --}}
    @if ($boundValue && !$multiple && is_object($boundValue) && method_exists($boundValue, 'temporaryUrl'))
        <div class="mb-2">
            <img src="{{ $boundValue->temporaryUrl() }}" class="img-thumbnail h-150" width="150">
        </div>
    @endif


    {{-- Show new gallery previews --}}
    @if ($boundValue && $multiple)
        <div class="d-flex flex-wrap gap-2 mb-2">
            @foreach ($boundValue as $photo)
                <img src="{{ $photo->temporaryUrl() }}" class="img-thumbnail h-150" width="100">
            @endforeach
        </div>
    @endif

    <input type="file" class="form-control" name="{{ $name }}" wire:model="{{ $wireModel }}"
        {{ $multiple ? 'multiple' : '' }}>

    @error($name)
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
