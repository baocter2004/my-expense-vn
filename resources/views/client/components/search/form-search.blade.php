@props([
    'sloganText' => '',
    'routeSearch' => '',
    'routeIndex' => '',
    'routeTrash' => '',
    'routeCreate' => '',
    'icon' => '',
])

<div class="text-center mb-10 animate-fade-in">
    <div
        class="inline-flex items-center justify-center p-3 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-2xl shadow-lg mb-4">
        <i class="fa-solid {{ $icon }} text-white text-3xl"></i>
    </div>
    <h1 class="text-4xl font-bold text-gray-800 mb-2">MyExpenseVn</h1>
    <p class="text-gray-600 max-w-2xl mx-auto">
        {{ $sloganText }}
    </p>
</div>

<div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-3 md:p-6 mb-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="w-full max-w-2xl mx-auto">
            <form method="GET" action="{{ $routeSearch }}"
                class="flex flex-col sm:flex-row gap-2 sm:gap-4 items-stretch">
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </span>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Tìm kiếm ví theo tên..."
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-1 focus:ring-teal-500 transition-all duration-300">
                </div>
                <button type="submit"
                    class="px-5 py-3 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                    Tìm kiếm
                </button>
            </form>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="#" id="reset-search"
                class="group flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300">
                <i class="fa-solid fa-rotate-left group-hover:rotate-180 transition-transform duration-500"></i>
                <span class="hidden sm:inline">Làm mới</span>
            </a>

            @if ($routeIndex)
                <a href="{{ $routeIndex }}"
                    class="group flex items-center gap-2 px-4 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-all duration-300">
                    <i class="fa-solid fa-list group-hover:scale-110 transition-transform"></i>
                    <span class="hidden sm:inline">Danh Sách</span>
                </a>
            @endif

            @if ($routeTrash)
                <a href="{{ $routeTrash }}"
                    class="group flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition-all duration-300">
                    <i class="fa-solid fa-trash group-hover:scale-110 transition-transform"></i>
                    <span class="hidden sm:inline">Thùng rác</span>
                </a>
            @endif

            @if ($routeCreate)
                <a href="{{ $routeCreate }}"
                    class="group flex items-center gap-2 px-4 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
                    <i class="fa-solid fa-plus group-hover:rotate-90 transition-transform"></i>
                    <span class="hidden sm:inline">Thêm mới</span>
                </a>
            @endif
        </div>
    </div>
</div>

<div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl p-3 md:p-6 mb-8">
    <div class="bg-gradient-to-r from-teal-50 to-yellow-50 border-l-4 border-teal-400 p-4 rounded-lg mb-6">
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-lightbulb text-teal-500 text-xl mt-0.5"></i>
            <div>
                <h4 class="font-semibold text-gray-800 mb-1">Mẹo sử dụng</h4>
                <p class="text-sm text-gray-600">
                    Sử dụng bộ lọc bên dưới để tìm kiếm ví theo thời gian tạo và sắp xếp theo nhu cầu của bạn.
                </p>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ $routeSearch }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <div class="relative">
            @include('client.components.forms.date', [
                'icon' => 'calendar-days',
                'name' => 'created_from',
                'placeholder' => 'YYYY-MM-DD',
                'label' => 'Từ ngày',
            ])
        </div>

        <div class="relative">
            @include('client.components.forms.date', [
                'icon' => 'calendar-days',
                'name' => 'created_to',
                'placeholder' => 'YYYY-MM-DD',
                'label' => 'Đến ngày',
            ])
        </div>

        <div class="relative">
            @include('client.components.forms.select', [
                'icon' => 'sort',
                'label' => 'Sắp xếp',
                'name' => 'sort',
                'options' => \App\Consts\GlobalConst::SORT_OPTIONS,
            ])
        </div>

        <button type="submit"
            class="h-fit self-end px-6 py-2.5 bg-gradient-to-r from-teal-500 to-cyan-500 text-white rounded-xl hover:shadow-lg transition-all duration-300">
            <i class="fa-solid fa-filter mr-2"></i>
            Áp dụng
        </button>
    </form>
</div>
<div class="flex items-center justify-center mb-8">
    <div
        class="relative flex items-center gap-3 px-10 py-6 border-4 border-teal-400 rounded-2xl hover:border-emerald-400 transition-all duration-300 hover:scale-105 shadow-lg">
        <div class="absolute -top-2 left-1/2 -translate-x-1/2 w-10 h-2 bg-slate-700 rounded"></div>
        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 w-16 h-2 bg-slate-700 rounded"></div>

        <div class="flex items-center gap-3 text-teal-300">
            <i class="fa-solid fa-tv text-xl"></i>
            <span class="font-semibold tracking-wide">Danh sách</span>
        </div>
    </div>
</div>
@if (request()->routeIs('client.categories.index'))
    <div class="w-full flex justify-end mb-4 relative">
        <div class="inline-flex items-center relative">
            <a href="#system-categories"
                class="relative inline-flex items-center gap-2 px-4 py-2 bg-white border border-teal-200 text-teal-700 rounded-full -ml-3 shadow-md hover:shadow-lg transition-all duration-200 focus:outline-none focus:ring-1 focus:ring-teal-300"
                aria-label="Danh mục sẵn có">
                <i class="fa-solid fa-box-open"></i>
                <span class="font-medium">Danh mục sẵn có</span>
            </a>

            <div id="system-wire" class="absolute left-1/2 transform -translate-x-1/2 top-full pointer-events-none"
                aria-hidden="true">
                <div id="wire-inner" class="inline-block animate-swing origin-top">
                    <div class="w-px h-16 sm:h-24 border-l-2 border-dashed border-teal-300 opacity-90 mx-auto"></div>
                    <div class="w-3 h-3 bg-teal-400 rounded-full mx-auto shadow-lg"></div>
                </div>
            </div>
        </div>
    </div>
@endif
