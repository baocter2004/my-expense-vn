{{-- <nav class="navbar flex justify-between items-center px-4 py-3 bg-white shadow-md">
    <button type="button" id="sidebarToggle"
        class="navbar-btn flex items-center gap-2 bg-teal-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-teal-600 transition">
        <i class="fa-solid fa-bars text-lg"></i>
        <span class="hidden sm:inline">Menu</span>
    </button>
    <div class="relative" id="buttonDropdown">
        <div class="flex border-l-4 border-r-4 cursor-pointer rounded-md border-teal-500 items-center px-2 gap-3">
            <div
                class="w-10 h-10 rounded-full bg-teal-100 flex items-center justify-center text-teal-600 font-bold shadow-inner">
                {{ strtoupper(substr(Auth::guard('admin')->user()->first_name, 0, 1)) }}
            </div>
            <h2 class="text-slate-700 font-medium">
                {{ Auth::guard('admin')->user()->first_name . ' ' . Auth::guard('admin')->user()->last_name ?? 'Name' }}
            </h2>
        </div>
        <div id="dropDownMenu"
            class="absolute right-0 mt-2 w-full bg-white border border-gray-200 rounded-lg shadow-lg py-2 z-50 hidden">
            <a href="{{ route('admin.profile.show')}}" class="block px-4 py-2 text-slate-700 hover:bg-teal-50 hover:text-teal-600 transition">
                Thông tin cá nhân
            </a>
            <a href="{{ route('admin.profile.change-password') }}"
                class="block px-4 py-2 text-slate-700 hover:bg-teal-50 hover:text-teal-600 transition">
                Đổi mật khẩu
            </a>
            <form action="{{ route('auth.admin.logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="w-full text-left px-4 py-2 text-slate-700 hover:bg-red-50 hover:text-red-600 transition">
                    Đăng xuất
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
    $(document).ready(function() {
        $("#buttonDropdown").on('click', function(e) {
            $("#dropDownMenu").toggleClass('hidden');
        });
    });
</script> --}}
