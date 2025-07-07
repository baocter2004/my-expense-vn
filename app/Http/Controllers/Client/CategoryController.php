<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\GetCategoryRequest;
use App\Services\Client\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $categoryService
    ) {}
    public function index(GetCategoryRequest $request)
    {
        $id = Auth::id();

        $items = $this->categoryService->getList($id,$request->validated());

        return view('client.pages.categories.index',compact('items'));
    }

    public function create() {}

    public function update(Request $request)
    {
        $id   = $request->input('id');
        $name = $request->input('name');

        $result = $this->categoryService->update($id, ['name' => $name]);

        if ($result) {
            return redirect()
                ->route('client.profile')
                ->with('success', 'Thay đổi tên danh mục thành công!');
        } else {
            return back()->with('error', 'Không thể cập nhật danh mục. Vui lòng thử lại.');
        }
    }
}
