@extends('layouts.layouts')
@section('title', 'Form')
@section('content')
    <div class="card">
        <div class="card-body">

            <a href="{{ route('admin.form') }}"> <i class="fa-regular fa-arrow-left"></i> Kembali </a>
            <h3 class="mt-3">Detail Form</h3>
            <table class="table table-responsive-sm mb-3">
                <thead class="text-center">
                    <tr>
                        <th>JUDUL</th>
                        <th>DESKRIPSI</th>
                        <th>STATUS AKTIF</th>
                        <th>WAKTU MULAI</th>
                        <TH>WAKTU SELESAI</TH>
                    </tr>
                    <tr>
                        <td>{{ $form->title }}</td>
                        <td>{{ $form->description }}</td>
                        <td>
                            @if($form->status == 'active')
                                <div class="text-success">{{ $form->status }}</div>
                            @else
                                <div class="text-danger">{{ $form->status }}</div>
                            @endif
                        </td>
                        <td>{{ $form->start_date }}</td>
                        <td>{{ $form->end_date }}</td>
                    </tr>
                </thead>
            </table>
            <h3 class="mt-3">Daftar Hadir</h3>
            <table class="table table-responsive-sm">
                <thead class="text-center">
                    <tr>
                        <th>NIP</th>
                        <th>NAMA</th>
                        <th>TANDA TANGAN</th>
                        <th>STATUS KEHADIRAN</th>
                        <th>WAKTU PENGISIAN</th>

                    </tr>

                </thead>
                <tbody class="text-center">
                    @foreach ($form->responses as $response)
                        <tr>
                            <td>{{ $response->nip }}</td>
                            <td>{{ $response->nama }}</td>
                            <td>
                                <img src="{{ Storage::url($response->tanda_tangan) }}" width="100%" height="80"alt="">
                            </td>
                            @if ($response->status == 'present')
                                <td>Hadir</td>
                            @else
                                <td>Tidak hadir</td>
                            @endif
                            <td>{{ $response->created_at }}</td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>
@endsection
