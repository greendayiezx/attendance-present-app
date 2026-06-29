@extends('layouts.layouts')
@section('title','Dashboard')
@section('content')
<div class="card">
    <div class="card-body">
        <h4>
            @auth
                Hello {{ Auth::user()->name  }}
            @else
                Hello, Selamat Datang!
            @endauth
        </h4>
    </div>
</div>


@endsection
