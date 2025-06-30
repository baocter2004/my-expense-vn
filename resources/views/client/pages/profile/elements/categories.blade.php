<div class="flex justify-center items-center">
    <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
        <i class="fa-solid fa-list-ul text-teal-500"></i> Danh Mục
    </h2>
</div>

<div class="mt-2">
    
</div>

@if ($categories->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($categories as $category)
            <div
                class="bg-white border border-gray-200 rounded-xl shadow hover:shadow-md transition-shadow duration-300 p-4 flex items-center gap-3 hover:bg-teal-50">
                <i class="fa-solid fa-tag text-teal-500 text-lg"></i>
                <span class="font-semibold text-gray-800">{{ $category->name }}</span>
            </div>
        @endforeach
    </div>

    <div class="mt-6 flex justify-end">
        {{ $categories->onEachSide(1)->links('client.components.elements.paginate') }}
    </div>
@else
    <p class="text-center text-gray-500 italic">Bạn chưa có danh mục nào.</p>
@endif
