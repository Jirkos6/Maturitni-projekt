@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')

@section('title', 'Odborky')

@section('content')
    @use('App\Models\Achievements')
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
                        <h4 class="mb-0"><i class="ri-award-line me-2 text-primary"></i>Odborky</h4>
                        <p class="text-muted mb-0">Správa odborek a jejich přiřazení členům</p>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAchievementModal">
                            <i class="ri-add-line me-1"></i> Přidat Odborku
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if (0 !== Achievements::count())
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0">
                        <div class="card-body d-flex align-items-center">
                            <div class="rounded-circle bg-warning p-3 bg-opacity-10 me-3">
                                <i class="ri-medal-line text-warning fs-4"></i>
                            </div>
                            <div>
                                <h6 class="card-subtitle mb-1 text-muted">Celkem odborek</h6>
                                <h4 class="card-title mb-0">{{ Achievements::count() }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0">
                        <div class="card-body">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent border-end-0">
                                    <i class="ri-search-line"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="achievement-search"
                                    placeholder="Hledat odborky...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 achievement-cards">
                @foreach ($data as $item)
                    <div class="col achievement-item" data-name="{{ $item->name }}">
                        <div class="card h-100 shadow-sm hover-shadow border-0 position-relative">
                            <div class="position-relative">
                                <img class="card-img-top rounded-top" style="height: 180px; object-fit: cover;"
                                    src="{{ asset('storage/achievements/' . $item->image) }}" alt="{{ $item->name }}" />
                                <div class="position-absolute top-0 end-0 p-2">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light rounded-circle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li>
                                                <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal"
                                                    data-bs-target="#editAchievementModal"
                                                    onclick="editAchievement({{ $item->id }}, '{{ $item->name }}', '{{ $item->description }}', '{{ asset('storage/achievements/' . $item->image) }}')">
                                                    <i class="ri-pencil-line me-2"></i>Upravit
                                                </a>
                                            </li>
                                            <li>
                                                <form action="/achievement/{{ $item->id }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="ri-delete-bin-6-line me-2"></i>Smazat
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text text-muted">
                                    @if (null !== $item->description)
                                        {{ Str::limit($item->description, 100) }}
                                    @else
                                        <span class="text-muted fst-italic">Bez popisku</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-4">
                    <i class="ri-award-line text-primary" style="font-size: 4rem;"></i>
                </div>
                <h3 class="text-primary mb-2">Ještě nebyly přidány žádné odborky!</h3>
                <p class="text-muted">Přidejte odborky pro zobrazení</p>
                <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal"
                    data-bs-target="#addAchievementModal">
                    <i class="ri-add-line me-1"></i> Přidat odborku
                </button>
            </div>
        @endif
    </div>
    </div>
    <div class="modal fade" id="addAchievementModal" tabindex="-1" aria-labelledby="addAchievementModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title" id="addAchievementModal">
                        Přidat odborku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Zavřít"></button>
                </div>
                <form action="{{ route('achievements.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Název odborky <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-award-line"></i></span>
                                <input type="text" class="form-control" id="name" name="name" required
                                    placeholder="Zadejte název odborky">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Popis odborky</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                <textarea class="form-control" id="description" name="description" rows="3"
                                    placeholder="Zadejte popis odborky"></textarea>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Obrázek <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-image-line"></i></span>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*" required>
                            </div>
                            <div class="form-text">Nahrajte obrázek odborky (JPG, PNG).</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1"></i>Zavřít
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-add-line me-1"></i>Přidat odborku
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editAchievementModal" tabindex="-1" aria-labelledby="editAchievementModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title text-primary" id="editAchievementModalLabel">
                        <i class="ri-award-line me-2"></i>Upravit odborku
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAchievementForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <img id="Lpimage" src="/placeholder.svg" class="img-fluid rounded mb-3"
                                style="max-height: 200px;" alt="Náhled odborky">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Název odborky <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-award-line"></i></span>
                                <input type="text" class="form-control" id="Lpname" name="name" value=""
                                    required placeholder="Zadejte název odborky">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Popis odborky</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                <textarea class="form-control" id="Lpdescription" name="description" value="" rows="3"
                                    placeholder="Zadejte popis odborky"></textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="form-label">Obrázek odborky</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="ri-image-line"></i></span>
                                <input type="file" class="form-control" id="image" name="image"
                                    accept="image/*">
                            </div>
                            <div class="form-text">Vyberte nový obrázek pouze pokud chcete změnit stávající.
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Zavřít
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>Upravit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
