<div id="chatModal"
    class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center p-2 z-[2000] hidden">
    <div
        class="bg-white rounded-xl w-full max-w-2xl h-[90vh] flex flex-col shadow-2xl overflow-hidden border border-gray-200">
        <div
            class="flex items-center justify-between px-5 py-3 bg-gradient-to-r from-teal-500 via-teal-400 to-cyan-400 text-white rounded-t-xl shadow-md border-b border-white/20">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm border border-white/30 overflow-hidden">
                        <img src="{{ asset('/images/ai-image.png') }}" alt="" class="w-full h-full object-cover">
                    </div>
                    <div
                        class="absolute -top-1 -right-1 w-3 h-3 bg-green-400 rounded-full border border-white animate-pulse">
                    </div>
                </div>
                <div>
                    <h2 class="text-lg font-semibold tracking-wide">AI Chat Assistant</h2>
                    <div class="flex items-center gap-2 text-xs text-cyan-100">
                        <div class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></div>
                        <span>Online • Ready to help</span>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button id="closeChat" class="w-8 h-8 flex items-center justify-center rounded-full">
                    ✖
                </button>
            </div>
        </div>

        <div class="hidden md:block px-5 py-2 bg-gradient-to-r from-teal-100 to-cyan-100 border-b border-teal-200">
            <div class="flex items-center justify-between text-xs">
                <div class="text-teal-600">Response: 0.8s</div>
                <div class="text-teal-600">AI Confidence: 95%</div>
                <div class="text-teal-600">v2.1 • MyExpenseVn Assistant</div>
            </div>
        </div>

        <div id="chat-container"
            class="flex-1 p-4 overflow-y-auto bg-gradient-to-br from-teal-50 to-cyan-50 space-y-4 scrollbar-thin scrollbar-thumb-teal-400 scrollbar-track-transparent hover:scrollbar-thumb-teal-500">

            <div class="text-center py-4">
                <div
                    class="w-12 h-12 mx-auto mb-3 bg-gradient-to-r from-teal-400 to-cyan-400 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M9.5 3A6.5 6.5 0 0 1 16 9.5c0 1.61-.59 3.09-1.56 4.23l.27.27h.79l5 5-1.5 1.5-5-5v-.79l-.27-.27A6.516 6.516 0 0 1 9.5 16 6.5 6.5 0 0 1 3 9.5 6.5 6.5 0 0 1 9.5 3m0 2C7 5 5 7 5 9.5S7 14 9.5 14 14 12 14 9.5 12 5 9.5 5z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-teal-700 mb-1">Chào mừng đến với AI Assistant</h3>
                <p class="text-teal-600 text-sm">Tôi có thể giúp bạn với MyExpenseVn và nhiều câu hỏi khác</p>
            </div>

            <div class="grid grid-cols-2 gap-3 mb-4">
                <div
                    class="bg-white border border-teal-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                    <div class="w-8 h-8 bg-teal-400 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-teal-700 font-medium text-sm mb-1">Đăng ký nhanh</h4>
                    <p class="text-teal-600 text-xs">Hướng dẫn từng bước</p>
                </div>

                <div
                    class="bg-white border border-cyan-200 rounded-lg p-3 shadow-sm hover:shadow-md transition-all duration-200 hover:scale-105">
                    <div class="w-8 h-8 bg-cyan-400 rounded-lg flex items-center justify-center mb-2">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z" />
                        </svg>
                    </div>
                    <h4 class="text-cyan-700 font-medium text-sm mb-1">Thống kê AI</h4>
                    <p class="text-cyan-600 text-xs">Phân tích thông minh</p>
                </div>
            </div>

            <div class="bg-white border border-teal-200 rounded-lg p-4 shadow-sm">
                <div class="flex items-center gap-2 mb-3">
                    <div class="w-6 h-6 bg-teal-400 rounded-full flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <h4 class="text-teal-700 font-medium">Hướng dẫn đăng ký MyExpenseVn</h4>
                </div>
                <div class="space-y-2">
                    <div class="flex items-start gap-3 p-2 bg-teal-50 rounded-md border border-teal-100">
                        <div
                            class="w-5 h-5 bg-teal-400 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0 mt-0.5">
                            1</div>
                        <div>
                            <p class="text-teal-800 font-medium text-sm">Truy cập trang web chính thức</p>
                            <p class="text-teal-600 text-xs mt-0.5">Đảm bảo URL chính xác để bảo mật</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-2 bg-teal-50 rounded-md border border-teal-100">
                        <div
                            class="w-5 h-5 bg-teal-400 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0 mt-0.5">
                            2</div>
                        <div>
                            <p class="text-teal-800 font-medium text-sm">Nhấn nút "Đăng ký" ở góc trên phải</p>
                            <p class="text-teal-600 text-xs mt-0.5">Thường có màu xanh hoặc nổi bật</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3 p-2 bg-teal-50 rounded-md border border-teal-100">
                        <div
                            class="w-5 h-5 bg-teal-400 rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0 mt-0.5">
                            3</div>
                        <div>
                            <p class="text-teal-800 font-medium text-sm">Điền thông tin và xác thực email</p>
                            <p class="text-teal-600 text-xs mt-0.5">Kiểm tra spam folder nếu cần</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-2">
                <div class="w-8 h-8 rounded-full bg-teal-400 flex items-center justify-center text-white font-bold">
                    AI
                </div>
                <div class="bg-white border border-teal-200 rounded-lg px-3 py-2 max-w-[70%] shadow">
                    <p class="mb-1">Xin chào! Mình là trợ lý AI của bạn 😊</p>
                    <div class="flex items-center gap-1 text-xs text-teal-500">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <span>95% tin cậy</span>
                    </div>
                </div>
            </div>

            <div class="flex items-start gap-2">
                <div class="w-8 h-8 rounded-full bg-teal-400 flex items-center justify-center text-white font-bold">
                    AI
                </div>
                <div class="bg-white border border-teal-200 rounded-lg px-3 py-2 max-w-[70%] shadow">
                    Bạn cần giúp gì về MyExpenseVn không? 🚀
                </div>
            </div>
        </div>

        <div class="p-4 border-t bg-white rounded-b-xl space-y-3">
            <div class="w-full grid grid-cols-2 md:grid-cols-4 gap-2 mb-2">
                <button
                    class="quick-send flex justify-center items-center gap-1 px-3 py-1 bg-teal-100 hover:bg-teal-200 text-teal-700 rounded-full text-sm transition-all duration-200 hover:scale-105">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                    </svg>
                    Giới thiệu
                </button>
                <button
                    class="quick-send flex justify-center items-center gap-1 px-3 py-1 bg-teal-100 hover:bg-teal-200 text-teal-700 rounded-full text-sm transition-all duration-200 hover:scale-105">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-5 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z" />
                    </svg>
                    Hướng dẫn
                </button>
                <button
                    class="quick-send flex justify-center items-center gap-1 px-3 py-1 bg-teal-100 hover:bg-teal-200 text-teal-700 rounded-full text-sm transition-all duration-200 hover:scale-105">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z" />
                    </svg>
                    Liên hệ
                </button>
                <button
                    class="quick-send flex justify-center items-center gap-1 px-3 py-1 bg-cyan-100 hover:bg-cyan-200 text-cyan-700 rounded-full text-sm transition-all duration-200 hover:scale-105">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19.14,12.94c0.04-0.3,0.06-0.61,0.06-0.94c0-0.32-0.02-0.64-0.07-0.94l2.03-1.58c0.18-0.14,0.23-0.41,0.12-0.61 l-1.92-3.32c-0.12-0.22-0.37-0.29-0.59-0.22l-2.39,0.96c-0.5-0.38-1.03-0.7-1.62-0.94L14.4,2.81c-0.04-0.24-0.24-0.41-0.48-0.41 h-3.84c-0.24,0-0.43,0.17-0.47,0.41L9.25,5.35C8.66,5.59,8.12,5.92,7.63,6.29L5.24,5.33c-0.22-0.08-0.47,0-0.59,0.22L2.74,8.87 C2.62,9.08,2.66,9.34,2.86,9.48l2.03,1.58C4.84,11.36,4.82,11.69,4.82,12s0.02,0.64,0.07,0.94l-2.03,1.58 c-0.18,0.14-0.23,0.41-0.12,0.61l1.92,3.32c0.12,0.22,0.37,0.29,0.59,0.22l2.39-0.96c0.5,0.38,1.03,0.7,1.62,0.94l0.36,2.54 c0.05,0.24,0.24,0.41,0.48,0.41h3.84c0.24,0,0.44-0.17,0.47-0.41l0.36-2.54c0.59-0.24,1.13-0.56,1.62-0.94l2.39,0.96 c0.22,0.08,0.47,0,0.59-0.22l1.92-3.32c0.12-0.22,0.07-0.47-0.12-0.61L19.14,12.94z M12,15.6c-1.98,0-3.6-1.62-3.6-3.6 s1.62-3.6,3.6-3.6s3.6,1.62,3.6,3.6S13.98,15.6,12,15.6z" />
                    </svg>
                    Cài đặt
                </button>
            </div>

            <div class="bg-gradient-to-r from-teal-50 to-cyan-50 border border-teal-200 rounded-lg p-2">
                <div class="w-full flex items-center gap-2 p-2 bg-gray-50">
                    <input type="text" placeholder="Nhập tin nhắn..." id="input-form"
                        class="flex-1 border border-teal-400 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-teal-400 bg-white">
                    <button id="button-send"
                        class="bg-gradient-to-r from-teal-400 to-cyan-400 text-white px-4 py-2 rounded-md transition hover:scale-105 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z" />
                        </svg>
                        <span class="hidden md:inline">Gửi</span>
                    </button>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center gap-2 text-teal-600">
                        <div class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></div>
                        <span>AI sẵn sàng hỗ trợ</span>
                    </div>
                    <div class="flex items-center gap-1 text-gray-500">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                        </svg>
                        <span>Bảo mật</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('client.components.scripts.ai-modal')
