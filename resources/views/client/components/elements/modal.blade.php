@props([
    'action' => '#',
    'title' => 'Xác nhận xoá',
    'message' => 'Bạn có chắc chắn muốn xoá mục này không?',
    'showId' => 'deleteModal',
])

<div id="deleteModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 sm:mx-auto p-6 relative animate-fade-in">
        <button type="button" onclick="closeDeleteModal()"
            class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <h2 class="text-xl font-semibold text-gray-800 mb-4" id="modalTitle">Xác nhận xoá</h2>
        <p class="text-gray-600 mb-6 text-sm leading-relaxed" id="modalMessage">
            Bạn có chắc chắn muốn xoá mục này không?
        </p>
        <div class="flex justify-end space-x-3">
            <button type="button" onclick="closeDeleteModal()"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition">
                Hủy
            </button>
            <form method="POST" id="deleteModalForm">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-lg hover:bg-red-600 transition">
                    Xoá
                </button>
            </form>
        </div>
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
