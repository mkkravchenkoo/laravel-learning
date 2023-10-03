@extends('layouts.main')

@section('page.title', 'Overview')

@section('main.content')
    <x-title>
        {{ __('Post overview') }}

        <x-slot name="link">
            <a href="{{ route('user.posts') }}">
                {{ __('Back') }}
            </a>
        </x-slot>

        <x-slot name="right">
            <x-button-link href="{{ route('user.posts.edit', $post->id) }}">
                {{ __('Change') }}
            </x-button-link>
        </x-slot>
    </x-title>

    <h2 class="h4">
        {{ $post->title }}
    </h2>

    <div class="small text-muted">
        {{ now()->format('d.m.Y') }}
    </div>

    <div class="pt-3">
        {!! $post->content !!}
    </div>
@endsection
