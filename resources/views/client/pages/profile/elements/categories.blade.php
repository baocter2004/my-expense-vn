 <h2 class="text-2xl font-extrabold text-teal-600 mb-4 flex items-center gap-2">
     <i class="fa-solid fa-list-ul text-teal-500"></i> Danh Mục
 </h2>
 @if ($categories->count())
     <ul class="divide-y divide-gray-200 border border-gray-100 rounded-lg overflow-hidden">
         @foreach ($categories as $category)
             <li class="py-3 px-4 hover:bg-teal-50 transition">
                 <span class="font-semibold">Tên danh mục:</span> {{ $category->name }}
             </li>
         @endforeach
     </ul>
 @else
     <p class="text-center text-gray-500 italic">Bạn chưa có danh mục nào.</p>
 @endif
