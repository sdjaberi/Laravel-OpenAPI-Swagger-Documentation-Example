<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use App\Http\Exceptions\ApiNotFoundException;
use App\Http\Exceptions\ApiPermissionException;
use Barryvdh\Debugbar\Facades\Debugbar;
use Barryvdh\Debugbar\Middleware\DebugbarEnabled;

interface ICategoryRepository
{
    public function getAllData();
    public function store($data);
    public function update($name = null,$data);
    public function upsert($data);
    public function view($name);
    public function delete($name);
}

class CategoryRepository implements ICategoryRepository
{
    public function getAllData()
    {
        return Category::with('project')->get();
    }

    public function store($data)
    {
        $category = new Category();
        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->icon = $data['icon'];
        $category->project_id = $data['project_id'];
        $category->save();

        //$category->users()->sync($data['users']);

        return $category;
    }

    public function update($name = null, $data)
    {
        $category = Category::find($name);

        if(!$category)
            throw new ApiNotFoundException();

        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->icon = $data['icon'];
        $category->project_id = $data['project_id'];
        $category->save();

        //$category->users()->sync($data->input('users', []));

        return $category;
    }

    public function upsert($data)
    {
        $category = new Category();

        $category->name = $data['name'];
        $category->description = $data['description'];
        $category->icon = $data['icon'];
        $category->project_id = $data['project_id'];
        $category->updateOrCreate();

        return $category;
    }

    public function view($name)
    {
        return Category::find($name)->load('project');
    }

    public function delete($name)
    {
        return Category::find($name)->delete();
    }

    public function deleteAll($names)
    {
        return Category::whereIn('name', $names)->delete();
    }

}
