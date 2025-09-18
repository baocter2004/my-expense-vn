<div class="sidebar-header relative p-6 flex items-center justify-between">
    <div>
        <h3 class="font-semibold text-lg">
            <span id="sidebar-header-logo">MY EXPENSE VN</span>
        </h3>
        <p class="sidebar-role-label text-sm opacity-80">Dành cho Quản trị viên</p>
    </div>

    <button id="closeSidebar"
        class="md:hidden w-10 h-10 rounded-full bg-white text-teal-600 flex items-center justify-center shadow-md hover:bg-gray-200 transition">
        <i class="fa-solid fa-xmark text-lg"></i>
    </button>
</div>

<ul class="components" id="sidebar-menu">
    <li class="active">
        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-chart-line"></i>
            Thống Kê
        </a>
    </li>

    <li class="has-submenu">
        <a href="#" class="sidebar-link dropdown-toggle">
            <span>
                <i class="fa-solid fa-users"></i>
                Người Dùng
            </span>
            <i class="fa-solid fa-chevron-down caret"></i>
        </a>
        <ul class="submenu">
            <li><a href="#" class="sidebar-link"><i class="fa-solid fa-user-plus"></i> Thêm</a></li>
            <li><a href="#" class="sidebar-link"><i class="fa-solid fa-user-pen"></i> Sửa</a></li>
            <li><a href="#" class="sidebar-link"><i class="fa-solid fa-user-xmark"></i> Xóa</a></li>
        </ul>
    </li>

    <li>
        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-wallet"></i>
            Tài Khoản
        </a>
    </li>

    <li>
        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-file-alt"></i>
            Báo Cáo
        </a>
    </li>

    <li>
        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-cog"></i>
            Cài Đặt
        </a>
    </li>

    <li>
        <a href="#" class="sidebar-link">
            <i class="fa-solid fa-right-from-bracket"></i>
            Đăng Xuất
        </a>
    </li>
</ul>
