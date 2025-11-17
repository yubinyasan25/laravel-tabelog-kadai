<?php

namespace App\Admin\Controllers;

use App\Models\Store;
use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class StoreController extends AdminController
{
    /**
     * 一覧画面（Grid）
     */
    public function index(Content $content)
    {
        return $content
            ->header('店舗一覧')
            ->description('')
            ->body($this->grid());
    }

    /**
     * Grid 定義
     */
    protected function grid()
    {
        $grid = new Grid(new Store());

        // カラム設定
        $grid->column('id', 'ID')->sortable();
        $grid->column('name', '店舗名');
        $grid->column('address', '住所');
        $grid->column('description', '紹介文');
        $grid->column('category.name', 'カテゴリー'); // ★ 追加
        $grid->column('image', '画像');

        // 詳細ボタン無効
        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        // 検索
        $grid->filter(function ($filter) {
            $filter->like('name', '店舗名');
            $filter->like('address', '住所');
            $filter->equal('category_id', 'カテゴリー')->select(
                Category::pluck('name', 'id')
            ); // ★ 追加
        });

        return $grid;
    }

    /**
     * 作成フォーム
     */
    public function create(Content $content)
    {
        return $content
            ->header('新規店舗作成')
            ->description('')
            ->body($this->form());
    }

    /**
     * 編集フォーム
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('店舗編集')
            ->description('')
            ->body($this->form()->edit($id));
    }

    /**
     * Form 定義
     */
    protected function form()
    {
        $form = new Form(new Store());

        $form->text('name', '店舗名')->rules('required|max:255');
        $form->text('address', '住所')->rules('required|max:255');
        $form->textarea('description', '紹介文');

        // ★ カテゴリー追加（必須）
        $form->select('category_id', 'カテゴリー')
            ->options(Category::pluck('name', 'id'))
            ->rules('required');

        $form->text('image', '画像ファイル名');

        return $form;
    }
}
