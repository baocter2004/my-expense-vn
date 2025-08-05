<?php

namespace App\Http\Controllers\Client;

use App\Consts\GlobalConst;
use App\Http\Controllers\Controller;
use App\Http\Requests\Categories\GetCategoryRequest;
use App\Http\Requests\Categories\PostCategoryRequest;
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

        $items = $this->categoryService->getList($id, $request->validated());

        return view('client.pages.categories.index', $items);
    }

    public function create()
    {
        return view('client.pages.categories.create');
    }

    public function store(PostCategoryRequest $postCategoryRequest)
    {
        $result = $this->categoryService->create($postCategoryRequest->validated());

        if ($result) {
            return redirect()->route('client.categories.index')
                ->with('success', 'Thêm mới danh mục thành công!');
        } else {
            return back()->with('error', 'Có lỗi khi thêm mới. Vui lòng thử lại.');
        }
    }

    public function update(Request $request)
    {
        $id = $request->input(key: 'id');

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'descriptions' => ['nullable', 'string'],
        ]);

        $result = $this->categoryService->update($id, $data);

        if ($result) {
            if ($request->filled('descriptions')) {
                return redirect()->route('client.categories.index')
                    ->with('success', 'Cập nhật danh mục thành công!');
            } else {
                return redirect()->route('client.profile')
                    ->with('success', 'Thay đổi tên danh mục thành công!');
            }
        } else {
            return back()->with('error', 'Không thể cập nhật danh mục. Vui lòng thử lại.');
        }
    }

    public function updateStatus($id, Request $request)
    {
        $status = $request->is_active ?? 0;
        $result = $this->categoryService->updateStatus($id, $status);
        $msg = $status == GlobalConst::ACTIVE ? 'Bật danh mục thành công' : 'Tắt danh mục thành công';
        return $result
            ? response()->json(['message' => $msg, 'status' => true])
            : response()->json([
                'message' => 'Có lỗi xảy ra khi cập nhật trạng thái',
                'status' => false
            ], 500);
    }

    public function delete($id)
    {
        $result = $this->categoryService->delete($id);

        if ($result['status']) {
            return redirect()->route('client.categories.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function trash(GetCategoryRequest $request)
    {
        $id = Auth::id();

        $items = $this->categoryService->getListTrashed($id, $request->validated());
        return view('client.pages.categories.trash', compact('items'));
    }

    public function restore($id)
    {
        $result = $this->categoryService->restore($id);

        if ($result) {
            return redirect()->route('client.categories.index')
                ->with('success', 'Khôi phục danh mục thành công!');
        } else {
            return back()->with('error', 'Có lỗi khi khôi phục. Vui lòng thử lại.');
        }
    }
}
