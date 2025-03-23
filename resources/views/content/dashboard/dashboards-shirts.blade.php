@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Velikosti Trička')

@section('content')
    @use('App\Models\ShirtSizes')
    @if (\Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="ri-checkbox-circle-line me-2 fs-5 align-self-center"></i>
                <div>{!! \Session::get('success') !!}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex">
                <i class="ri-error-warning-line me-2 fs-5 align-self-center"></i>
                <div>{!! \Session::get('error') !!}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid py-4">
        <div class="card mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="mb-0"><i class="ri-t-shirt-line me-2 text-primary"></i>Velikosti Trička</h4>
                        <p class="text-muted mb-0">Správa velikostí triček</p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addShirtSizeModal">
                            <i class="ri-add-line me-1"></i> Přidat velikost
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (ShirtSizes::count() > 0)
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                                <i class="ri-t-shirt-line text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 text-muted">Celkem velikostí</h6>
                                <h4 class="card-title mb-0">{{ ShirtSizes::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Velikost</th>
                                <th scope="col" class="text-end">Akce</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->size }}</td>
                                    <td class="text-end">
                                        <form action="{{ route('shirt-sizes.delete', $item->id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="ri-delete-bin-6-line me-1"></i>Smazat
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="ri-t-shirt-line text-primary" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-primary mb-2">Ještě nebyly přidány žádné velikosti triček!</h3>
                <p class="text-muted">Přidejte velikosti pro zobrazení</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#addShirtSizeModal">
                    <i class="ri-add-line me-1"></i> Přidat velikost
                </button>
            </div>
        @endif
    </div>
    <div class="modal fade" id="addShirtSizeModal" tabindex="-1" aria-labelledby="addShirtSizeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="addShirtSizeModalLabel">Přidat velikost trička</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('shirt-sizes.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="size" class="form-label">Velikost trička <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-t-shirt-line"></i></span>
                                <input type="text" class="form-control" id="size" name="size" required
                                    placeholder="Zadejte velikost (např. S, M, L)">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Zavřít
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>Přidat velikost
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
