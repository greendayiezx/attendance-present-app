@extends('layouts.layouts')
@section('title','Form')
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <h4>Form</h4>
                <p>Untuk membuat form silahkan menekan tombol tambah form</p>
            </div>
            <div class="col-lg-6">
                <div class="float-end">
                    <!-- Button trigger modal -->
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#addFormModal"
                    >
                      Tambah Form
                    </button>

                    <!-- Add Form Modal -->
                    <div
                        class="modal fade"
                        id="addFormModal"
                        tabindex="-1"
                        aria-labelledby="addFormModalLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5
                                        class="modal-title"
                                        id="addFormModalLabel"
                                    >
                                        Tambah Form
                                    </h5>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <form action="{{ route('admin.form.create') }}" method="POST">
                                    <div class="modal-body">
                                        @csrf
                                        <div class="form-group">
                                            <label for="title">Judul Rapat</label>
                                            <input type="text" name="title" class="form-control" id="formTitle" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="code">Kode Akses</label>
                                            <input type="text" name="code" class="form-control" id="accessCode" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <textarea name="description" id="description" class="form-control" cols="30" rows="10" required></textarea>
                                        </div>

                                        <!-- Jadwal Pengisian Section -->
                                        <div class="form-group">
                                            <label for="schedule">Atur Jadwal Pengisian</label>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input"
                                                    id="enableSchedule"
                                                    data-bs-toggle="popover"
                                                    data-bs-trigger="hover"
                                                    data-bs-content="Aktifkan ini untuk mengatur jadwal pengisian dosen">
                                                <label class="form-check-label" for="enableSchedule">Aktifkan jadwal pengisian</label>
                                            </div>

                                            <!-- Start Date -->
                                            <input
                                                type="datetime-local"
                                                name="start_date"
                                                class="form-control mt-2"
                                                id="startDateInput"
                                                placeholder="Masukkan tanggal mulai pengisian"
                                                disabled>

                                            <!-- End Date -->
                                            <input
                                                type="datetime-local"
                                                name="end_date"
                                                class="form-control mt-2"
                                                id="endDateInput"
                                                placeholder="Masukkan tanggal akhir pengisian"
                                                disabled>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button
                                            type="button"
                                            class="btn btn-secondary"
                                            data-bs-dismiss="modal"
                                        >
                                            Tutup
                                        </button>
                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >
                                            Tambah
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display form data -->
        @if($forms->count() > 0)
            <div class="list-group mt-3 mb-5">
                @foreach ($forms as $form)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-file-alt fa-2x me-3 text-primary"></i>
                            <div>
                                <h5 class="mb-1">{{ $form->title }}</h5>
                                <p class="mb-0 small text-muted">{{ Str::limit($form->description, 100) }}</p>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#viewModal{{ $form->id }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#editModal{{ $form->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $form->id }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- View Modal -->
                    <div class="modal fade" id="viewModal{{ $form->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $form->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewModalLabel{{ $form->id }}">Lihat Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h5>{{ $form->title }}</h5>
                                    <p>{{ $form->description }}</p>
                                    <p>kode: {{ $form->code }}</p>

                                    @if($form->start_date && $form->end_date)
                                        <p>Jadwal: {{ $form->start_date }} - {{ $form->end_date }}</p>
                                    @endif
                                    <a class="btn btn-primary me-2" href="{{ route('admin.form.show',$form->id) }}">
                                        <i class="fas fa-eye"></i>
                                        View Form
                                    </a>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Modal -->
                    <div class="modal fade" id="editModal{{ $form->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $form->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel{{ $form->id }}">Edit Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="{{ route('admin.form.update', $form->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="title">Judul Rapat</label>
                                            <input type="text" name="title" class="form-control" value="{{ $form->title }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Deskripsi</label>
                                            <textarea name="description" class="form-control" rows="5" required>{{ $form->description }}</textarea>
                                        </div>
                                        <!-- Jadwal Pengisian Section -->
                                        <div class="form-group">
                                            <label for="schedule">Atur Jadwal Pengisian</label>
                                            <div class="form-check">
                                                <input
                                                    type="checkbox"
                                                    class="form-check-input enable-schedule"
                                                    id="enableSchedule{{ $form->id }}"
                                                    {{ ($form->start_date && $form->end_date) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="enableSchedule{{ $form->id }}">Aktifkan jadwal pengisian</label>
                                            </div>
                                            <input
                                                type="datetime-local"
                                                name="start_date"
                                                class="form-control mt-2 start-date"
                                                value="{{ $form->start_date }}"
                                                {{ ($form->start_date && $form->end_date) ? '' : 'disabled' }}>
                                            <input
                                                type="datetime-local"
                                                name="end_date"
                                                class="form-control mt-2 end-date"
                                                value="{{ $form->end_date }}"
                                                {{ ($form->start_date && $form->end_date) ? '' : 'disabled' }}>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $form->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $form->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $form->id }}">Hapus Form</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus form ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('admin.form.destroy', $form->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p>Belum ada form yang tersedia.</p>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formTitle = document.getElementById('formTitle');
        const accessCode = document.getElementById('accessCode');

        formTitle.addEventListener('input', function() {
            // Generate the access code based on title input (lowercase and append number)
            const title = formTitle.value.toLowerCase().replace(/\s+/g, '');
            const uniqueId = Math.floor(1000 + Math.random() * 9000); // Random 4-digit number
            accessCode.value = title + uniqueId;
        });

        // Toggle schedule inputs
        const enableSchedule = document.getElementById('enableSchedule');
        const startDateInput = document.getElementById('startDateInput');
        const endDateInput = document.getElementById('endDateInput');

        enableSchedule.addEventListener('change', function() {
            const isEnabled = enableSchedule.checked;
            startDateInput.disabled = !isEnabled;
            endDateInput.disabled = !isEnabled;
        });

        $('[data-bs-toggle="popover"]').popover();
    });
</script>
@endsection
