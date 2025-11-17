<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'カテゴリー管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('ID'))->sortable();
        $grid->column('name', __('カテゴリー名'));
        $grid->column('description', __('説明'));
        $grid->column('created_at', __('作成日'))->sortable();
        $grid->column('updated_at', __('更新日'))->sortable();

        $grid->filter(function ($filter) {
            $filter->like('name', 'カテゴリー名');
            $filter->between('created_at', '作成日')->datetime();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('カテゴリー名'));
        $show->field('description', __('説明'));
        $show->field('created_at', __('作成日'));
        $show->field('updated_at', __('更新日'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('name', 'カテゴリー名')->required();
        $form->textarea('description', '説明');

        return $form;
    }
}
