@extends('pages.landing-page.layouts.main')

{{-- --------------------------------- Title --}}
@section('title', $title)

{{-- --------------------------------- Links --}}
@section('additional_links')
    {{-- SweetAlert --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}" />
    {{-- Quill --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/quill/quill.snow.css') }}" />
    {{-- File preview --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/filepond/filepond.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/toastify-js/src/toastify.css') }}">
@endsection

{{-- --------------------------------- Content --}}
@section('content')
    <section class="container px-4">
        <div class="page-heading mb-0">
            <div class="page-title">
                <div class="row justify-content-center">
                    <div class="col-12 mb-3 header-about mt-3">
                        <h2>Pengakuan dari
                            @if ($confession->privacy == 'anonymous')
                                <i>"rahasia"</i>
                            @else
                                <a href="/users/{{ $confession->student->user->username }}">
                                    {{ $confession->student->user->full_name }}
                                </a>
                            @endif
                        </h2>
                        <p class="text-subtitle text-muted">
                            Rincian dari suatu pengakuan.
                        </p>
                        <hr>
                        <div class="mb-3">
                            <a href="{{ back()->getTargetUrl() }}" data-bs-toggle="tooltip"
                                data-bs-original-title="Kembali ke halaman sebelumnya."
                                class="btn btn-secondary px-2 pt-2 me-1">
                                <span class="fa-fw fa-lg select-all fas text-white"></span>
                                Kembali
                            </a>
                        </div>
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
                            @if ($confession->privacy === 'anonymous')
                                <img src="{{ asset('images/user-images/default-avatar.png') }}" alt="User Avatar" />
                            @else
                                @if ($isUserImageExist($confession->student->user->profile_picture))
                                    @if (File::exists(public_path('images/' . $confession->student->user->profile_picture)))
                                        <img style="cursor: pointer;"
                                            onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                            src="{{ asset('images/' . $confession->student->user->profile_picture) }}"
                                            alt="User Avatar" />
                                    @else
                                        <img style="cursor: pointer;"
                                            onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                            src="{{ asset('storage/' . $confession->student->user->profile_picture) }}"
                                            alt="User Avatar" />
                                    @endif
                                @else
                                    @if ($confession->student->user->gender === 'L')
                                        <img style="cursor: pointer;"
                                            onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                            src="{{ asset('assets/static/images/faces/2.jpg') }}" alt="User Avatar" />
                                    @else
                                        <img style="cursor: pointer;"
                                            onclick="window.location.href='/users/{{ $confession->student->user->username }}'"
                                            src="{{ asset('assets/static/images/faces/5.jpg') }}" alt="User Avatar" />
                                    @endif
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
                            <div class="modal fade text-left" id="imageDetail" tabindex="-1"
                                aria-labelledby="modal-image-detail" style="display: none;" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"
                                    role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="modal-image-detail">
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
                                                    <img class="img-fluid rounded"
                                                        src="{{ asset("storage/$confession->image") }}"
                                                        alt="{{ $confession->category->category_name }}">
                                                @else
                                                    <img class="img-fluid rounded"
                                                        src="{{ asset('images/no-image-2.jpg') }}"
                                                        alt="{{ $confession->category->category_name }}">
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary"
                                                data-bs-dismiss="modal">
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

                {{-- Made a comment --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Berikan Komentar</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form" action="/confessions/{{ $confession->slug }}/comments" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-12 mb-1">
                                        <fieldset class="form-group mandatory">
                                            <label for="privacy" class="form-label">Privasi Komentar</label>
                                            <select class="form-select" id="privacy" name="privacy">
                                                <option value="public"
                                                    @if (old('privacy') === 'public') {{ 'selected' }} @endif>
                                                    Public
                                                </option>
                                                <option value="anonymous"
                                                    @if (old('privacy') === 'anonymous') {{ 'selected' }} @endif>
                                                    Anonymous
                                                </option>
                                            </select>
                                        </fieldset>
                                    </div>
                                    <div class="col-12 mb-1">
                                        <div class="form-group mandatory @error('comment'){{ 'is-invalid' }}@enderror">
                                            <div class="position-relative">
                                                <label for="comment" class="form-label">Komentar</label>

                                                <input id="comment" name="comment" value="{{ old('comment') }}"
                                                    type="hidden">
                                                <div id="editor">
                                                    {!! old('comment') !!}
                                                </div>

                                                @error('comment')
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

                                            <!-- File preview -->
                                            <input type="file" id="attachment_file" class="basic-file-filepond"
                                                name="attachment_file" />

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

                {{-- Comments --}}
                <div class="card" id="comments">
                    <div class="card-header">
                        <h3 class="card-title">Komentar</h3>
                    </div>
                    <div class="card-body">
                        @forelse ($comments as $comment)
                            <div class="px-4 mb-1" id="{{ base64_encode($comment->id_confession_comment) }}">
                                <div class="p-4 pb-0 px-0">
                                    <div class="d-flex">
                                        {{-- Profile picture --}}
                                        <div class="col-3 col-md-1">
                                            <div class="avatar avatar-lg mb-3 w-100">
                                                @if ($comment->privacy === 'anonymous')
                                                    <img src="{{ asset('images/user-images/default-avatar.png') }}"
                                                        alt="User Avatar" />
                                                @else
                                                    @if ($isUserImageExist($comment->user->profile_picture))
                                                        @if (File::exists(public_path('images/' . $comment->user->profile_picture)))
                                                            <img style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $comment->user->username }}'"
                                                                src="{{ asset('images/' . $comment->user->profile_picture) }}"
                                                                alt="User Avatar" />
                                                        @else
                                                            <img style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $comment->user->username }}'"
                                                                src="{{ asset('storage/' . $comment->user->profile_picture) }}"
                                                                alt="User Avatar" />
                                                        @endif
                                                    @else
                                                        @if ($comment->user->gender === 'L')
                                                            <img style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $comment->user->username }}'"
                                                                src="{{ asset('assets/static/images/faces/2.jpg') }}"
                                                                alt="User Avatar" />
                                                        @else
                                                            <img style="cursor: pointer;"
                                                                onclick="window.location.href='/users/{{ $comment->user->username }}'"
                                                                src="{{ asset('assets/static/images/faces/5.jpg') }}"
                                                                alt="User Avatar" />
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Details --}}
                                        <div class="col-11">
                                            <div class="text-start pe-4">
                                                <span class="mb-0 d-flex">
                                                    <small class="card-subtitle text-muted">
                                                        {{ $comment->created_at->format('d F Y, \a\t H:i') }}
                                                        @if ($comment->updated_by)
                                                            <span class="fst-italic">(disunting)</span>
                                                        @endif
                                                    </small>
                                                </span>

                                                {{-- Highlighted name --}}
                                                @if ($comment->privacy === 'anonymous')
                                                    @if ($comment->id_user === $userData->id_user)
                                                        <a class="font-bold mb-3 d-inline-block">Anonymous</a>
                                                    @else
                                                        <p class="font-bold">Anonymous</p>
                                                    @endif
                                                @else
                                                    @if ($comment->id_user === $userData->id_user)
                                                        <a href="/users/{{ $comment->user->username }}"
                                                            class="font-bold mb-3 d-inline-block">{{ $comment->user->full_name }}</a>
                                                    @else
                                                        <p onclick="window.location.href='/users/{{ $comment->user->username }}'"
                                                            class="font-bold mb-0" style="cursor: pointer;">
                                                            {{ $comment->user->full_name }}
                                                        </p>
                                                    @endif
                                                @endif

                                                {{-- --------------------------------- Rules --}}
                                                @if ($comment->id_user === $userData->id_user)
                                                    <div
                                                        class="mb-3 d-flex justify-content-between justify-content-center align-items-center">
                                                        <div class="btn-group">
                                                            <div class="me-2">
                                                                <a data-bs-original-title="Sunting komentar milik kamu."
                                                                    data-bs-toggle="tooltip"
                                                                    href="/comments/{{ base64_encode($comment->id_confession_comment) }}/edit"
                                                                    class="btn btn-warning px-2 pt-2">
                                                                    <span class="fa-fw fa-lg select-all fas"></span>
                                                                </a>
                                                            </div>

                                                            <div class="me-2">
                                                                <a data-bs-toggle="tooltip"
                                                                    data-bs-original-title="Unsend komentar yang sudah kamu berikan."
                                                                    class="btn btn-danger px-2 pt-2"
                                                                    data-confirm-confession-comment-destroy="true"
                                                                    data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                                    data-redirect="{{ base64_encode($confession->slug) }}">
                                                                    <span data-confirm-confession-comment-destroy="true"
                                                                        data-redirect="{{ base64_encode($confession->slug) }}"
                                                                        data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                                        class="fa-fw fa-lg select-all fas"></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="mb-4">{!! $comment->comment !!}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @if ($comment->attachment_file)
                                        <div class="mb-4">
                                            <a href="{{ asset("storage/$comment->attachment_file") }}" target="_blank">
                                                <div class="attachment-file position-relative">
                                                    {{-- --------------------------------- Rules --}}
                                                    @if ($comment->id_user === $userData->id_user)
                                                        <a class="btn btn-danger px-2 pt-2 position-absolute"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="Unsend file pendukung yang sudah kamu berikan."
                                                            data-confirm-confession-comment-attachment-destroy="true"
                                                            data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                            data-redirect="{{ base64_encode($confession->slug) }}">
                                                            <span data-confirm-confession-comment-attachment-destroy="true"
                                                                data-unique="{{ base64_encode($comment->id_confession_comment) }}"
                                                                data-redirect="{{ base64_encode($confession->slug) }}"
                                                                class="fa-fw fa-lg select-all fas"></span>
                                                        </a>
                                                    @endif
                                                    <div class="attachment-file-body text-center">
                                                        <i class="far fa-file-alt icon-9x"></i>
                                                    </div>
                                                    <div class="attachment-file-footer">
                                                        <a href="{{ asset("storage/$comment->attachment_file") }}"
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
                                <h4 class="alert-heading">Tidak ada komentar :(</h4>
                                <p>Belum ada komentar dari siapapun.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="row">
                    <div class="col d-flex justify-content-center" id="pagin-links">
                        {{ $comments->appends(['scroll-to' => 'comments'])->links('vendor.pagination.bootstrap') }}
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection

{{-- --------------------------------- Scripts --}}
@section('additional_scripts')
    {{-- Filepond: file preview --}}
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}">
    </script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
    <script
        src="{{ asset('assets/extensions/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-filter/filepond-plugin-image-filter.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}">
    </script>
    <script src="{{ asset('assets/extensions/filepond/filepond.js') }}"></script>
    @vite(['resources/js/filepond/basic-file.js'])
    {{-- realrashid/sweetalert --}}
    @include('sweetalert::alert')
    {{-- SweetAlert --}}
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    @vite(['resources/js/sweetalert/confession/comment/comment.js'])
    {{-- Quill --}}
    @vite(['resources/js/quill/confession/comment/comment.js'])
    <script src="{{ asset('assets/extensions/quill/quill.min.js') }}"></script>
    {{-- To scrollable --}}
    @vite(['resources/js/scrollable/scroll-to-a-comment.js'])
    @vite(['resources/js/scrollable/scroll-to-comments.js'])
@endsection
