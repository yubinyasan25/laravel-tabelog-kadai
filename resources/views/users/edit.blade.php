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
                {{-- マイページに戻るリンク --}}
                <a class="fw-bold" href="{{ route('users.mypage') }}">
                    マイページに戻る
                </a>

                <hr>

                {{-- 退会リンク（マイページと同じ見た目） --}}
                <form method="POST" action="{{ route('mypage.destroy') }}" class="d-inline">
                    @csrf
                    @method('DELETE')

                    <a href="#" class="fw-bold" data-bs-toggle="modal" data-bs-target="#delete-user-confirm-modal">
                        退会する
                    </a>

                    {{-- 確認モーダル --}}
                    <div class="modal fade" id="delete-user-confirm-modal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteUserModalLabel">本当に退会しますか？</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="閉じる"></button>
                                </div>
                                <div class="modal-body">
                                    <p class="text-center">一度退会するとデータはすべて削除され復旧はできません。</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">キャンセル</button>
                                    <button type="submit" class="btn btn-danger">退会する</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection
