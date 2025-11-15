@extends('layouts.app')

@section('content')
<div class="container pt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <h1 class="mb-3">会員情報編集</h1>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('users.mypage.update') }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-3 d-flex align-items-center">
                    <label style="width: 100px;">氏名</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="form-control @error('name') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <label style="width: 100px;">メール</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="form-control @error('email') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールを正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <label style="width: 100px;">郵便番号</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" 
                           class="form-control @error('postal_code') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('postal_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>郵便番号を正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-3 d-flex align-items-center">
                    <label style="width: 100px;">住所</label>
                    <input type="text" name="address" value="{{ old('address', $user->address) }}" 
                           class="form-control @error('address') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>住所を正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-4 d-flex align-items-center">
                    <label style="width: 100px;">電話番号</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="form-control @error('phone') is-invalid @enderror samuraimart-login-input" 
                           required>
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>電話番号を正しく入力してください。</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn samuraimart-submit-button w-100 text-white mb-4">
                    保存
                </button>
            </form>

            <div class="text-center">
                 <a class="fw-bold" href="{{ route('users.mypage') }}">
                マイページに戻る
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
