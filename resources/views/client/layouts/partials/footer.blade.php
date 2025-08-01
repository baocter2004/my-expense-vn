<div class="bg-white border-t border-gray-200 mt-5">
    <div class="px-5 py-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 text-sm text-gray-700">
        <div>
            <h3 class="font-semibold text-teal-600 mb-3">Về MyExpenseVN</h3>
            <p class="text-gray-600 leading-relaxed">
                MyExpenseVN là ứng dụng quản lý chi tiêu cá nhân thông minh, giúp bạn dễ dàng theo dõi thu chi, lập ngân
                sách và đạt được mục tiêu tài chính của mình.
            </p>
        </div>

        <div>
            <h3 class="font-semibold text-teal-600 mb-3">Liên hệ</h3>
            <ul class="space-y-2">
                <li><i class="fa-solid fa-envelope text-teal-500 mr-2"></i> support@myexpense.vn</li>
                <li><i class="fa-solid fa-phone text-teal-500 mr-2"></i> 0123 456 789</li>
                <li><i class="fa-solid fa-location-dot text-teal-500 mr-2"></i> Hà Nội, Việt Nam</li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold text-teal-600 mb-3">Liên kết nhanh</h3>
            <ul class="space-y-2">
                <li><a href="/" class="hover:text-teal-500 transition">Trang chủ</a></li>
                <li><a href="/about" class="hover:text-teal-500 transition">Giới thiệu</a></li>
                <li><a href="/contact" class="hover:text-teal-500 transition">Liên hệ</a></li>
                <li><a href="/privacy" class="hover:text-teal-500 transition">Chính sách bảo mật</a></li>
            </ul>
        </div>

        <div>
            <div>
                <h3 class="font-semibold text-teal-600 mb-3">Theo dõi chúng tôi</h3>
                <div class="flex space-x-3">
                    <a href="#" class="text-teal-500 hover:text-teal-600 transition"><i
                            class="fa-brands fa-facebook-f text-xl"></i></a>
                    <a href="#" class="text-teal-500 hover:text-teal-600 transition"><i
                            class="fa-brands fa-twitter text-xl"></i></a>
                    <a href="#" class="text-teal-500 hover:text-teal-600 transition"><i
                            class="fa-brands fa-instagram text-xl"></i></a>
                    <a href="#" class="text-teal-500 hover:text-teal-600 transition"><i
                            class="fa-brands fa-linkedin text-xl"></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-teal-50 border-t border-teal-100 mt-6 py-3 text-center text-xs text-teal-600">
        &copy; {{ date('Y') }} MyExpenseVN. Mọi quyền được bảo lưu.
    </div>
</div>

<div class="ai-watcher" id="aiWatcher">
    <div class="ai-face">
        <div class="ai-eyes">
            <div class="ai-eye blink">
                <div class="ai-pupil" id="leftPupil"></div>
            </div>
            <div class="ai-eye blink">
                <div class="ai-pupil" id="rightPupil"></div>
            </div>
        </div>
        <div class="ai-mouth" id="aiMouth"></div>
    </div>
    <div class="ai-speech-bubble" id="speechBubble">Chào bạn! Tôi đang theo dõi nhé 👀</div>
</div>

<button id="scrollToTop"
    class="fixed bottom-6 right-6 p-3 w-[50px] h-[50px] rounded bg-teal-500 text-white shadow-lg hover:bg-teal-600 transition opacity-0 pointer-events-none">
    <i class="fa-solid fa-arrow-up"></i>
</button>
