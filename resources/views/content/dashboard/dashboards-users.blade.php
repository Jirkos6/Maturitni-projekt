@php
    $container = 'container-xxl';
    $containerNav = 'container-xxl';
@endphp

@extends('layouts/contentNavbarLayout')
@section('title', 'Uživatel - ' . $user->parent_name . ' ' . $user->parent_surname)

@section('content')
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
        <div class="row">
            <div class="col-12 mb-4">
                <button class="btn btn-outline-primary" onclick="history.back()">
                    <i class="ri-arrow-left-line me-1"></i> Zpět na seznam
                </button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-primary text-white p-4 position-relative">
                        <div class="text-center">
                            <div class="avatar avatar-xl bg-white text-primary mx-auto mb-3">
                                {{ substr($user->parent_name, 0, 1) }}{{ substr($user->parent_surname, 0, 1) }}
                            </div>
                            <h4 class="mb-1">{{ $user->parent_name }} {{ $user->parent_surname }}</h4>
                            <span class="badge bg-info text-white">
                                {{ $user->role === 'parent' ? 'Rodič' : ($user->role === 'admin' ? 'Administrátor' : 'Neznámá role') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="list-group list-group-flush mb-4">
                            <div class="list-group-item px-0 py-3 d-flex border-top-0">
                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-3">
                                    <i class="ri-mail-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <span>{{ $user->email ?? 'Není zadáno' }}</span>
                                </div>
                            </div>

                            <div class="list-group-item px-0 py-3 d-flex">
                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-3">
                                    <i class="ri-shield-user-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Role</small>
                                    <span>{{ $user->role === 'parent' ? 'Rodič' : ($user->role === 'admin' ? 'Administrátor' : 'Neznámá role') }}</span>
                                </div>
                            </div>

                            <div class="list-group-item px-0 py-3 d-flex">
                                <div class="avatar avatar-sm bg-primary-subtle text-primary me-3">
                                    <i class="ri-calendar-event-line"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Registrován od</small>
                                    <span>{{ isset($user->created_at) ? \Carbon\Carbon::parse($user->created_at)->format('d.m.Y') : 'Neznámé datum' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2">

                            <form action="/users-role/{{ $user->id }}" method="POST"
                                onsubmit="return confirm('Opravdu chcete změnit roli uživatele {{ $user->parent_name }} {{ $user->parent_surname }}?');">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-outline-info w-100">
                                    <i class="ri-user-settings-line me-1"></i>
                                    @if ($user->role === 'parent')
                                        Nastavit roli Administrátor
                                    @elseif ($user->role === 'admin')
                                        Nastavit roli Rodič
                                    @endif
                                </button>
                            </form>

                            <form action="/user/{{ $user->id }}" method="POST"
                                onsubmit="return confirm('Opravdu chcete smazat tohoto uživatele? Tato akce je nevratná.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="ri-delete-bin-6-line me-1"></i> Smazat uživatele
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark">
                            <i class="ri-user-follow-line me-2 text-primary"></i>Přiřazené děti
                        </h5>
                    </div>

                    <div class="card-body">
                        @if ($user->member_names)
                            @php
                                $memberArray = explode(', ', $user->member_names);
                            @endphp

                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-3">
                                @foreach ($memberArray as $member)
                                    <div class="col">
                                        <div class="card h-100 bg-light border-0">
                                            <div class="card-body d-flex align-items-center">
                                                <div class="avatar avatar-md bg-primary-subtle text-primary me-3">
                                                    <i class="ri-user-line"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 text-dark">{{ $member }}</h6>
                                                    <span class="text-muted small">Dítě</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-4">
                                    <div class="rounded-circle bg-primary-subtle p-4 mx-auto" style="width: fit-content;">
                                        <i class="ri-user-add-line text-primary" style="font-size: 3rem;"></i>
                                    </div>
                                </div>
                                <h5 class="text-dark mb-2">Žádné přiřazené děti</h5>
                                <p class="text-muted mb-4">Tomuto uživateli zatím nebyly přiřazeny žádné děti.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignMemberModal" tabindex="-1" aria-labelledby="assignMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="assignMemberModalLabel">
                        <i class="ri-user-add-line me-2"></i>Přidělit děti
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="assignMemberForm" action="/assign-members" method="POST">
                        @csrf
                        <input type="hidden" id="userId" name="user_id" value="{{ $user->id }}">

                        <div class="mb-3">
                            <label for="memberSelect" class="form-label">Vyberte děti</label>
                            <select class="select2 form-select" id="memberSelect" name="member_id[]" multiple>
                                @foreach ($children as $child)
                                    <option value="{{ $child->id }}">{{ $child->name }} {{ $child->surname }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Můžete vybrat více dětí.</div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                <i class="ri-close-line me-1"></i>Zavřít
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="ri-save-line me-1"></i>Uložit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-weight: 500;
        }

        .avatar-xl {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .avatar-md {
            width: 42px;
            height: 42px;
            font-size: 1.25rem;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            font-size: 0.875rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('#assignMemberModal').on('show.bs.modal', function(e) {
                let button = $(e.relatedTarget);
                let userId = button.data('user-id');
                $('#userId').val(userId);
            });
        });
    </script>
@endsection
