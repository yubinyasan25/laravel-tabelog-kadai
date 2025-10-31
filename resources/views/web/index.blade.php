@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <h1 class="mb-4">NAGOYAMESHI B級グルメガイド</h1>
    
    



    <!-- カテゴリ一覧ボタン -->
    <div class="mb-4">
        @foreach($categories as $category)
            <a href="#" class="btn btn-outline-primary btn-sm me-1 mb-1">{{ $category->name }}</a>
        @endforeach
    </div>
</div>
@endsection
