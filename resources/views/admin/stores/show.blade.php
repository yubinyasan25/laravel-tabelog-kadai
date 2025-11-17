{{-- resources/views/admin/stores/show.blade.php --}}

<div class="box">
    <div class="box-header">
        <h3>店舗詳細</h3>
    </div>

    <div class="box-body">

        <table class="table table-bordered">
            <tr>
                <th>ID</th>
                <td>{{ $store->id }}</td>
            </tr>
            <tr>
                <th>店舗名</th>
                <td>{{ $store->name }}</td>
            </tr>
            <tr>
                <th>住所</th>
                <td>{{ $store->address }}</td>
            </tr>
        </table>

        <a href="{{ route('admin.stores.edit', $store->id) }}" class="btn btn-primary">
            編集する
        </a>

        <a href="{{ route('admin.stores.index') }}" class="btn btn-default">
            戻る
        </a>

        <form action="{{ route('admin.stores.destroy', $store->id) }}"
              method="POST"
              style="display:inline-block;">
            @csrf
            @method('DELETE')

            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('本当に削除しますか？');">
                削除
            </button>
        </form>
    </div>
</div>
