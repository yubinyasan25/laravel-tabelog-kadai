@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h1 class="mb-3">パスワード変更</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('mypage.update_password') }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3 d-flex align-items-center">
                    <label style="width: 120px;">新しいパスワード</label>
                    <input type="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>パスワードを正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4 d-flex align-items-center">
                    <label style="width: 120px;">パスワード確認</label>
                    <input type="password" name="password_confirmation" 
                           class="form-control @error('password_confirmation') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>確認用パスワードを正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn samuraimart-submit-button w-100 text-white mb-4">
                    更新
                </button>
            </form>
            <div class="text-center">
                 <a class="fw-bold" href="{{ route('users.mypage') }}">
                マイページに戻る

        </div>
    </div>
</div>
@endsection
