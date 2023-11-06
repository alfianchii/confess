@extends('pages.dashboard.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- --------------------------------- Rules --}}
    @if ($confession->status === 'unprocess' || $confession->status === 'process')
        {{-- Quill --}}
        <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
    @endif
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <div class="page-heading mb-0">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h2>Kronologi Kejadian</h2>
                    <p class="text-subtitle text-muted">
                        Rincian dari pengakuan yang telah kamu buat.
                    </p>
                    <hr>
                    <div class="mb-4">
                        <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                            data-bs-original-title="Kembali ke halaman sebelumnya."
                            class="btn btn-secondary px-2 pt-2 me-1">
                            <span class="fa-fw fa-lg select-all fas text-white"></span>
                            Kembali
                        </a>
                        {{-- --------------------------------- Rules --}}
                        @if ($confession->status === 'unprocess' || $confession->status === 'release')
                            <a data-bs-toggle="tooltip" data-bs-original-title="Pick pengakuan ini." href="#"
                                class="btn btn-success px-2 pt-2" data-confirm-confession-pick="true"
                                data-unique="{{ base64_encode($confession->slug) }}">
                                <span data-confirm-confession-pick="true"
                                    data-unique="{{ base64_encode($confession->slug) }}"
                                    class="fa-fw fa-lg select-all fas"></span>
                            </a>
                        @endif
                        @if ($confession->status === 'process' && $confession->assigned_to === $userData->id_user)
                            <a data-bs-toggle="tooltip" data-bs-original-title="Release pengakuan yang lagi kamu handle."
                                href="#" class="btn btn-secondary px-2 pt-2" data-confirm-confession-release="true"
                                data-unique="{{ base64_encode($confession->slug) }}">
                                <span data-confirm-confession-release="true"
                                    data-unique="{{ base64_encode($confession->slug) }}"
                                    class="fa-fw fa-lg select-all fas"></span>
                            </a>
                            <a data-bs-toggle="tooltip" data-bs-original-title="Close pengakuan yang lagi kamu handle."
                                href="#" class="btn btn-danger px-2 pt-2" data-confirm-confession-close="true"
                                data-unique="{{ base64_encode($confession->slug) }}">
                                <span data-confirm-confession-close="true"
                                    data-unique="{{ base64_encode($confession->slug) }}"
                                    class="fa-fw fa-lg select-all fas"></span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="/dashboard">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="/dashboard/confessions">Pengakuan</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Tanggapan
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            {{-- Confession --}}
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title d-inline-block">Pengakuan</h3> <small
                        class="text-muted">({{ $confession->privacy }})</small>
                </div>
                <div class="card-body">
                    <div class="avatar avatar-lg d-flex justify-content-center mb-3">
                        @if ($isUserImageExist($confession->student->user->profile_picture))
                            @if (File::exists(public_path('images/' . $confession->student->user->profile_picture)))
                                <img src="{{ asset('images/' . $confession->student->user->profile_picture) }}"
                                    alt="User Avatar" />
                            @else
                                <img src="{{ asset('storage/' . $confession->student->user->profile_picture) }}"
                                    alt="User Avatar" />
                            @endif
                        @else
                            @if ($confession->student->user->gender === 'L')
                                <img src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                            @else
                                <img src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                            @endif
                        @endif
                    </div>

                    <div class="text-center mb-3">
                        <h4>{{ $confession->title }}</h4>
                    </div>
                    <div class="d-md-flex justify-content-center">
                        <div class="me-4">
                            <p>
                                <span class="fw-bold">Tanggal:</span> {{ $confession->date }}
                            </p>
                            <p>
                                <span class="fw-bold">Tempat kejadian:</span>
                                @if ($confession->place == 'in')
                                    Dalam Sekolah
                                @elseif ($confession->place == 'out')
                                    Luar Sekolah
                                @endif
                            </p>
                            <p><span class="fw-bold">Assigned to:
                                </span>{{ $confession->officer?->user->full_name ?? '-' }}</p>
                        </div>
                        <div class="me-4">
                            <p>
                                <span class="fw-bold">Kategori:</span> {{ $confession->category->category_name }}
                            </p>
                            <p>
                                <span class="fw-bold me-1">Status:</span>
                                @if ($confession->status == 'unprocess')
                                    <span class="badge bg-light-danger">
                                        Belum diproses
                                    </span>
                                @elseif ($confession->status == 'process')
                                    <span class="badge bg-light-info">
                                        Sedang diproses
                                    </span>
                                @elseif ($confession->status == 'release')
                                    <span class="badge bg-light">
                                        Release
                                    </span>
                                @elseif ($confession->status == 'close')
                                    <span class="badge bg-light-success">
                                        Selesai
                                    </span>
                                @endif
                            </p>
                            <p>
                                <span class="fw-bold me-1">Sunting:</span>
                                @if ($confession->updated_by)
                                    <span class="badge bg-light-warning">Ya</span>
                                @else
                                    <span class="badge bg-light-dark">Tidak</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <hr>

                    <div class="py-3 d-flex justify-content-center">
                        <a href="#">
                            @if ($confession->image)
                                <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                    src="{{ asset("storage/$confession->image") }}"
                                    alt="{{ $confession->category->category_name }}">
                            @else
                                <img class="img-fluid rounded" data-bs-toggle="modal" data-bs-target="#imageDetail"
                                    src="{{ asset('images/no-image-2.jpg') }}"
                                    alt="{{ $confession->category->category_name }}">
                            @endif
                        </a>

                        {{-- Modal --}}
                        <div class="modal fade text-left" id="imageDetail" tabindex="-1" aria-labelledby="myModalLabel17"
                            style="display: none;" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel17">
                                            Foto
                                        </h4>
                                        <button type="button" class="close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-x">
                                                <line x1="18" y1="6" x2="6" y2="18">
                                                </line>
                                                <line x1="6" y1="6" x2="18" y2="18">
                                                </line>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-flex justify-content-center">
                                            @if ($confession->image)
                                                <img class="img-fluid rounded" data-bs-toggle="modal"
                                                    data-bs-target="#imageDetail"
                                                    src="{{ asset("storage/$confession->image") }}"
                                                    alt="{{ $confession->category->category_name }}">
                                            @else
                                                <img class="img-fluid rounded" data-bs-toggle="modal"
                                                    data-bs-target="#imageDetail"
                                                    src="{{ asset('images/no-image-2.jpg') }}"
                                                    alt="{{ $confession->category->category_name }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                            <i class="bx bx-x d-none"></i>
                                            <span class="d-block">Close</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p>
                        {!! $confession->body !!}
                    </p>
                </div>
            </div>

            {{-- Made a response --}}
            {{-- --------------------------------- Rules --}}
            @if (
                $confession->assigned_to === $userData->id_user &&
                    ($confession->status === 'unprocess' || $confession->status === 'process'))
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Berikan Tanggapan</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="/dashboard/confessions/{{ $confession->slug }}/responses"
                                method="POST" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mb-1">
                                        <fieldset class="form-group">
                                            <label for="status" class="form-label">Status</label>
                                            <select class="form-select" id="status" name="status">
                                                <option value="process"
                                                    @if (old('status') === 'process') {{ 'selected' }} @endif>Process
                                                </option>
                                                <option value="release"
                                                    @if (old('status') === 'release') {{ 'selected' }} @endif>Release
                                                </option>
                                                <option value="close"
                                                    @if (old('status') === 'close') {{ 'selected' }} @endif>Close
                                                </option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <div class="form-group mandatory @error('response'){{ 'is-invalid' }}@enderror">
                                            <div class="position-relative">
                                                <label for="response" class="form-label">Isi Tanggapan</label>

                                                <input id="response" name="response" value="{{ old('response') }}"
                                                    type="hidden">
                                                <div id="editor">
                                                    {!! old('response') !!}
                                                </div>

                                                @error('response')
                                                    <div class="invalid-feedback d-block">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <div class="form-group @error('attachment_file'){{ 'is-invalid' }}@enderror">
                                            <label for="attachment_file" class="form-label">File Pendukung</label>
                                            <input class="form-control" name="attachment_file" type="file"
                                                id="attachment_file">

                                            @error('attachment_file')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mt-3 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Response --}}
            <div class="card" id="responses">
                <div class="card-header">
                    <h3 class="card-title">Tanggapan</h3>
                </div>
                <div class="card-body">
                    @forelse ($responses as $response)
                        <div class="px-4 mb-1" id="{{ base64_encode($response->id_confession_response) }}">
                            <div class="p-4 pb-0 px-0">
                                <div class="d-flex">
                                    {{-- Profile picture --}}
                                    <div class="col-3 col-md-1">
                                        <div class="avatar avatar-lg mb-3 w-100">
                                            @if ($isUserImageExist($response->user->profile_picture))
                                                @if (File::exists(public_path('images/' . $response->user->profile_picture)))
                                                    <img src="{{ asset('images/' . $response->user->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('storage/' . $response->user->profile_picture) }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @else
                                                @if ($response->user->gender === 'L')
                                                    <img src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                        alt="User Avatar" />
                                                @else
                                                    <img src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                        alt="User Avatar" />
                                                @endif
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Details --}}
                                    <div class="col-11">
                                        <div class="text-start pe-4">
                                            <span class="mb-0 d-flex">
                                                <small class="card-subtitle text-muted">
                                                    {{ $response->created_at->format('d F Y, \a\t H:i') }}
                                                    @if ($response->updated_by)
                                                        <span class="fst-italic">(disunting)</span>
                                                    @endif
                                                </small>

                                                {{-- System's response --}}
                                                @if ($response->system_response === 'Y')
                                                    <small
                                                        class="card-subtitle text-muted ms-1 fst-italic">(system)</small>
                                                @endif
                                            </span>

                                            {{-- Highlighted name --}}
                                            @if ($response->id_user === $userData->id_user)
                                                <a
                                                    class="font-bold mb-3 d-inline-block">{{ $response->user->full_name }}</a>
                                            @else
                                                <p class="font-bold">{{ $response->user->full_name }}</p>
                                            @endif

                                            {{-- --------------------------------- Rules --}}
                                            @if (
                                                ($confession->status === 'unprocess' || $confession->status === 'process') &&
                                                    $response->id_user === $userData->id_user &&
                                                    $response->system_response !== 'Y')
                                                <div
                                                    class="mb-3 d-flex justify-content-between justify-content-center align-items-center">
                                                    <div class="btn-group">
                                                        <div class="me-2">
                                                            <a data-bs-original-title="Sunting tanggapan milik kamu."
                                                                data-bs-toggle="tooltip"
                                                                href="/dashboard/responses/{{ base64_encode($response->id_confession_response) }}/edit"
                                                                class="btn btn-warning px-2 pt-2">
                                                                <span class="fa-fw fa-lg select-all fas"></span>
                                                            </a>
                                                        </div>

                                                        <div class="me-2">
                                                            <a data-bs-toggle="tooltip"
                                                                data-bs-original-title="Unsend tanggapan yang sudah kamu berikan."
                                                                class="btn btn-danger px-2 pt-2"
                                                                data-confirm-confession-response-destroy="true"
                                                                data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                                data-redirect="{{ base64_encode($confession->slug) }}">
                                                                <span data-confirm-confession-response-destroy="true"
                                                                    data-redirect="{{ base64_encode($confession->slug) }}"
                                                                    data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                                    class="fa-fw fa-lg select-all fas"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="mb-4">{!! $response->response !!}</div>
                                        </div>
                                    </div>
                                </div>

                                @if ($response->attachment_file)
                                    <div class="mb-4">
                                        <a href="{{ asset("storage/$response->attachment_file") }}" target="_blank">
                                            <div class="attachment-file position-relative">
                                                {{-- --------------------------------- Rules --}}
                                                @if (
                                                    ($confession->status === 'unprocess' || $confession->status === 'process') &&
                                                        $response->id_user === $userData->id_user)
                                                    <a class="btn btn-danger px-2 pt-2 position-absolute"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-original-title="Unsend file pendukung yang sudah kamu berikan."
                                                        data-confirm-confession-response-attachment-destroy="true"
                                                        data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                        data-redirect="{{ base64_encode($confession->slug) }}">
                                                        <span data-confirm-confession-response-attachment-destroy="true"
                                                            data-unique="{{ base64_encode($response->id_confession_response) }}"
                                                            data-redirect="{{ base64_encode($confession->slug) }}"
                                                            class="fa-fw fa-lg select-all fas"></span>
                                                    </a>
                                                @endif
                                                <div class="attachment-file-body text-center">
                                                    <i class="far fa-file-alt icon-9x"></i>
                                                </div>
                                                <div class="attachment-file-footer">
                                                    <a href="{{ asset("storage/$response->attachment_file") }}"
                                                        target="_blank" class="btn btn-primary">
                                                        <i class="far fas fa-box-open me-2"></i> Open it
                                                        up!
                                                    </a>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <hr class="m-0">
                    @empty
                        <div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Tidak ada tanggapan :(</h4>
                            <p>Belum ada tanggapan dari pihak terkait.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-center" id="pagin-links">
                    {{ $responses->appends(['scroll-to' => 'responses'])->links('vendor.pagination.bootstrap') }}
                </div>
            </div>
        </section>
    </div>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/confession/confession.js'])
    @vite(['resources/js/sweetalert/confession/response/response.js'])
    {{-- --------------------------------- Rules --}}
    @if ($confession->status === 'unprocess' || $confession->status === 'process')
        {{-- Quill --}}
        @vite(['resources/js/quill/confession/response/response.js'])
        <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    @endif
    {{-- To scrollable --}}
    @vite(['resources/js/scrollable/scroll-to-a-response.js'])
    @vite(['resources/js/scrollable/scroll-to-responses.js'])
@endsection
