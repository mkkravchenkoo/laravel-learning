@props(['post' => null])

<x-form {{ $attributes }}>
    <x-form-item>
        <x-label required>{{ __('Name') }}</x-label>
        <x-input name="title" value="{{ $post->title ?? '' }}" autofocus />
        <x-error name="title" />
    </x-form-item>

    <x-form-item>
        <x-label required>{{ __('Content') }}</x-label>
        <x-trix name="content" value="{{ $post->content ?? '' }}" />
{{--        <x-textarea name="content" rows="10" value="{{ $post->content ?? '' }}"/>--}}
        <x-error name="content" />
    </x-form-item>

    <x-form-item>
        <x-label required>{{ __('Date') }}</x-label>
{{--        <x-input name="published_at" value="{{ $post?->published_at?->format('d.m.Y') ?? '' }}" placeholder="dd.mm.yyyy" />--}}
        <x-error name="published_at" />
    </x-form-item>

    <x-form-item>
        <x-checkbox name="published" :checked="$post?->published">
            Published
        </x-checkbox>
    </x-form-item>

    {{ $slot }}
</x-form>
