@extends('layouts/blankLayout')

@section('title', 'Error - Pages')

@section('page-style')
    <!-- Page -->
    @vite(['resources/assets/vendor/scss/pages/page-misc.scss'])
@endsection


@section('content')
    <!-- Error -->
    <div class="misc-wrapper">
        <h1 class="mb-2 mx-2" style="font-size: 6rem;line-height: 6rem;">Error 404</h1>
        <h4 class="mb-2">Stránka nebyla nalezena! 🙄</h4>
        <p class="mb-10 mx-2">nepodařilo se najít stránku, kterou jste hledali</p>

        <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="misc-tree"
            class="img-fluid misc-object d-none d-lg-inline-block">

        <a href="{{ url('/') }}" class="btn btn-primary text-center my-6">Domovská stránka</a>

    </div>
    </div>
    </div>
    <!-- /Error -->
@endsection
