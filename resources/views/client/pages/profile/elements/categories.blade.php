<div
    class="mx-auto mb-6 bg-white rounded-lg shadow-sm flex flex-col items-center text-center gap-3
         md:flex-row md:justify-between md:items-center md:text-left md:gap-0 p-4">
    <div class="flex items-center gap-2">
        <a href="{{ route('client.categories.index') }}">
            <h2
                class="flex items-center gap-2 text-lg font-extrabold text-teal-600
           border-b-2 border-teal-200 pb-1 md:pb-0">
                <i class="fa-solid fa-list-ul text-teal-500 text-lg md:text-xl"></i>
                Danh Mục
            </h2>
        </a>
    </div>
    <a href="{{ route('client.categories.create') }}"
        class="inline-flex items-center gap-2 text-sm md:text-base font-medium
            px-4 py-2 border border-teal-300 text-teal-600 rounded-full
            hover:bg-teal-50 transition mt-2 md:mt-0">
        <i class="fa-solid fa-plus"></i>
        Thêm Mới
    </a>
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

<div id="editCategoryModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm">
    <div class="bg-white rounded-lg p-6 w-full max-w-sm shadow relative animate-fade-in">
        <h3 class="text-lg text-teal-500 font-bold mb-4">Chỉnh sửa danh mục</h3>
        <form id="editCategoryForm" method="POST" action="{{ route('client.categories.update') }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" id="editCategoryId">
            <div class="mb-4">
                <div class="flex items-center gap-2">
                    <label class="flex items-center gap-x-2 text-sm font-medium text-teal-500 mb-1">
                        Tên danh mục mới
                    </label>
                    <span class="text-red-500 text-base leading-none">*</span>
                </div>
                <input type="text" name="name" id="editCategoryName"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-1 focus:ring-teal-500">
                @if ($errors->has('name'))
                    <p class="text-red-500 text-sm mt-1">{{ $errors->first('name') }}</p>
                @endif
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

<style>
    @keyframes fade-in {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in {
        animation: fade-in 0.3s ease-out;
    }
</style>


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

            @if ($errors->any() && session('edit_mode'))

                $('#editCategoryModal').removeClass('hidden').addClass('flex');
            @endif
        });
    </script>
@endpush
