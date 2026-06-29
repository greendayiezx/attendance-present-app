@extends('layouts.layouts')

@section('title', 'Form')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Form</h4>
        <p>Untuk membuat form silahkan menekan tombol tambah form</p>

        <!-- Display error alert -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                        <button class="btn btn-dark me-2" data-bs-toggle="modal" data-bs-target="#accessModal{{ $form->id }}">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>

                    <!-- Access Code Modal -->
                    <div class="modal fade" id="accessModal{{ $form->id }}" tabindex="-1" aria-labelledby="accessModalLabel{{ $form->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="accessModalLabel{{ $form->id }}">Masukkan Kode Akses</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="accessForm{{ $form->id }}">
                                        <div class="mb-3">
                                            <label for="access_code{{ $form->id }}" class="form-label">Kode Akses</label>
                                            <input type="text" class="form-control" id="accessCodeInput{{ $form->id }}" required>
                                        </div>
                                        <button type="button" class="btn btn-primary check-access" data-form-id="{{ $form->id }}">Submit</button>
                                    </form>
                                </div>
                            </div>
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
                                    @if($form->start_date && $form->end_date)
                                        <p>Jadwal: {{ $form->start_date }} - {{ $form->end_date }}</p>
                                    @endif

                                    {{-- @php
                                        $response = $form->responses()->where('user_id', Auth::id())->first();
                                    @endphp --}}

                                    {{-- @if($response)
                                        @if($response->status == "present")
                                            <p>Status Kehadiran: Hadir</p>
                                        @else
                                            <p>Status Kehadiran: Tidak hadir</p>
                                        @endif
                                        <p>Tanda Tangan:</p>
                                        <div class="border" style="width:100%; height:200px;">
                                            <img src="{{ Storage::url($response->tanda_tangan) }}" alt="Signature" style="width:100%; height:100%; object-fit:contain;">
                                        </div>
                                    @else --}}
                                        <!-- Form untuk mengisi data -->
                                        <form action="{{ route('forms.fill', $form->id) }}" method="POST" id="form{{ $form->id }}">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="nip{{ $form->id }}" class="form-label">NIP</label>
                                                <input type="text" class="form-control" id="nip{{ $form->id }}" name="nip" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama{{ $form->id }}" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama{{ $form->id }}" name="nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status{{ $form->id }}" class="form-label">Status Kehadiran</label>
                                                <select name="status" id="status{{ $form->id }}" class="form-control" required>
                                                    <option value="present">Hadir</option>
                                                    <option value="absence">Tidak Hadir</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="signaturePad{{ $form->id }}" class="form-label">Tanda Tangan</label>
                                                <div class="border" style="width:100%; height:200px;">
                                                    <canvas id="signaturePad{{ $form->id }}" width="400" height="200"></canvas>
                                                </div>
                                                <button type="button" class="btn btn-secondary mt-2 clear-signature" data-target="#signaturePad{{ $form->id }}">Hapus Tanda Tangan</button>
                                                <input type="hidden" name="tanda_tangan" id="signatureData{{ $form->id }}">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Isi Form</button>
                                        </form>
                                    {{-- @endif --}}
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        @else
            <p class="mt-3">Belum ada form yang dibuat.</p>
        @endif

        <!-- Pagination links -->
        {{ $forms->links() }}
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.check-access').forEach(function (button) {
            button.addEventListener('click', function () {
                var formId = this.getAttribute('data-form-id');
                var accessCodeInput = document.getElementById('accessCodeInput' + formId).value;
                console.log(accessCodeInput)

                // Kirim request AJAX untuk cek kode akses
                fetch(`{{ url('/forms/${formId}/check-access-code') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ access_code: accessCodeInput })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Tutup modal kode akses dan buka modal form
                        var accessModal = new bootstrap.Modal(document.getElementById('accessModal' + formId));
                        accessModal.hide();
                        var viewModal = new bootstrap.Modal(document.getElementById('viewModal' + formId));
                        viewModal.show();
                    } else {
                        alert(data.message || 'Kode akses salah.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat memvalidasi kode akses.');
                });
            });
        });

        // Tanda tangan dan form handling
        document.querySelectorAll('canvas').forEach(function (canvas) {
            var signaturePad = new SignaturePad(canvas);
            var formId = canvas.id.replace('signaturePad', '');

            // Tombol untuk menghapus tanda tangan
            document.querySelector(`.clear-signature[data-target="#signaturePad${formId}"]`).addEventListener('click', function () {
                signaturePad.clear();
                document.getElementById(`signatureData${formId}`).value = ''; // Kosongkan input tanda tangan
            });

            // Tambahkan event submit untuk setiap form
            document.getElementById(`form${formId}`).addEventListener('submit', function (event) {
                if (signaturePad.isEmpty()) {
                    alert("Tanda tangan belum diisi.");
                    event.preventDefault(); // Mencegah submit jika tanda tangan kosong
                } else {
                    // Ambil data tanda tangan sebagai image base64
                    var signatureData = signaturePad.toDataURL('image/png');
                    document.getElementById(`signatureData${formId}`).value = signatureData;
                }
            });
        });
    });
</script>
@endsection
