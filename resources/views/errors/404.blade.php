@extends('layouts/blankLayout')

@section('title', 'Chybové - Stránky')

@section('page-style')
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection


@section('content')
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 6rem;line-height: 6rem;">Error 404</h1>
        <h4 class="mb-2">Stránka nebyla nalezena! 🙄</h4>
        <p class="mb-10 mx-2">nepodařilo se najít stránku, kterou jste hledali</p>

        <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="misc-tree"
            class="img-fluid misc-object d-none d-lg-inline-block">
        @if (Auth::check() && Auth::user()->role == 'admin')
            <a href="{{ url('/') }}" class="btn btn-primary text-center my-6">Domovská stránka</a>
        @elseif (Auth::check() && Auth::user()->role == 'parent')
            <a href="{{ url('/dashboard') }}" class="btn btn-primary text-center my-6">Domovská stránka</a>
        @else
            <a href="{{ url('/login') }}" class="btn btn-primary text-center my-6">Přihlašte se</a>
        @endif
    </div>
    </div>
    </div>
@endsection
