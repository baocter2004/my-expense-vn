<div class="flex justify-center items-center">
    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-list-ul text-teal-500"></i> Danh Mục
    </h2>
</div>

<div class="w-full bg-gray-50 p-2 md:p-6 rounded-lg border border-gray-100">
    @if ($categories->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach ($categories as $category)
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-md transition-shadow duration-300 p-4 flex justify-between md:justify-center items-center gap-3 hover:bg-teal-50">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-tag text-teal-500 text-lg"></i>
                        <span class="font-semibold text-gray-800">{{ $category->name }}</span>
                    </div>
                    <button
                        class="edit-category-btn flex items-center gap-1 text-sm text-teal-600 hover:text-teal-800 transition"
                        data-id="{{ $category->id }}" data-name="{{ $category->name }}">Chỉnh sửa
                    </button>
                </div>
            @endforeach
        </div>

        <div class="mt-6 flex justify-end">
            {{ $categories->onEachSide(1)->links('client.components.elements.paginate') }}
        </div>
    @else
        <p class="text-center text-gray-500 italic">Bạn chưa có danh mục nào.</p>
    @endif
</div>

<div id="editCategoryModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow relative">
        <h3 class="text-lg font-bold mb-4">Chỉnh sửa danh mục</h3>
        <form id="editCategoryForm" method="POST" action="{{ route('client.categories.update') }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="editCategoryId">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tên danh mục mới</label>
                <input type="text" name="name" id="editCategoryName"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" id="cancelEditBtn" class="px-3 py-1 bg-gray-300 rounded">Hủy</button>
                <button type="submit" class="px-3 py-1 bg-teal-600 text-white rounded">Lưu</button>
            </div>
        </form>
        <button id="closeEditModalBtn" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            $('.edit-category-btn').click(function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#editCategoryId').val(id);
                $('#editCategoryName').val(name);
                $('#editCategoryModal').removeClass('hidden').addClass('flex');
            });

            $('#cancelEditBtn, #closeEditModalBtn').click(function() {
                $('#editCategoryModal').addClass('hidden').removeClass('flex');
            });
        });
    </script>
@endpush
