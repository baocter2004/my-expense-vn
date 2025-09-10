<style>
    .typing {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .dot {
        width: 6px;
        height: 6px;
        background: teal;
        border-radius: 50%;
        animation: blonok 1.4s infinite both;
    }

    .dot:nth-child(2) {
        animation-delay: 0.2s;
    }

    .dot:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes blonok {
        0% {
            opacity: .2;
        }

        20% {
            opacity: 1;
        }

        100% {
            opacity: .2;
        }
    }
</style>

<script>
    $(document).ready(function() {
        const chatContainer = $("#chat-container");
        const input = $("#input-form");
        const btnSend = $("#button-send");
        const quickBtns = $(".quick-send");

        let isWaiting = false;

        const apiUrl = @json(Auth::check() ? '/api/ai/query' : getenv('N8N_URL') . '/20089df3-6bdc-4de8-bcbf-dd80785c2326');
        function setWaiting(state) {
            isWaiting = state;
            input.prop("disabled", state);
            btnSend.prop("disabled", state);
            quickBtns.prop("disabled", state);
        }

        function addMessage(text, type, isPending = false) {
            let msgHtml = "";
            if (type === "user") {
                msgHtml = `
                <div class="flex items-start gap-2 justify-end">
                    <div class="bg-teal-500 text-white rounded-lg px-3 py-2 max-w-[70%] shadow">
                        ${text}
                    </div>
                    <div class="w-8 h-8 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold">U</div>
                </div>`;
            } else {
                if (isPending) {
                    msgHtml = `
                    <div class="flex items-start gap-2 ai-message">
                        <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">AI</div>
                        <div class="bg-gray-100 border border-teal-200 rounded-2xl px-4 py-3 max-w-[70%] shadow">
                            <div class="typing">
                                <span class="dot"></span>
                                <span class="dot"></span>
                                <span class="dot"></span>
                            </div>
                        </div>
                    </div>`;
                } else {
                    msgHtml = `
                    <div class="flex items-start gap-2 ai-message">
                        <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">AI</div>
                        <div class="bg-white border border-teal-200 rounded-2xl px-4 py-3 max-w-[70%] shadow ai-text"></div>
                    </div>`;
                }
            }
            chatContainer.append(msgHtml);
            chatContainer.scrollTop(chatContainer[0].scrollHeight);
            return chatContainer.children().last();
        }

        function typeWriter(element, html, speed = 30, done = null) {
            let div = $("<div>").html(html);
            let nodes = div.contents();
            let i = 0;

            function typingNode() {
                if (i < nodes.length) {
                    let node = nodes[i];
                    if (node.nodeType === Node.TEXT_NODE) {
                        let text = node.nodeValue;
                        let j = 0;
                        (function typeText() {
                            if (j < text.length) {
                                element.append(document.createTextNode(text[j]));
                                j++;
                                setTimeout(typeText, speed);
                                chatContainer.scrollTop(chatContainer[0].scrollHeight);
                            } else {
                                i++;
                                typingNode();
                            }
                        })();
                    } else {
                        element.append(node);
                        i++;
                        setTimeout(typingNode, speed);
                    }
                } else {
                    if (done) done();
                }
            }
            typingNode();
        }

        function sendMessage(message) {
            if (isWaiting) return;
            setWaiting(true);

            addMessage(message, "user");
            input.val("");
            const pendingEl = addMessage("", "ai", true);

            $.ajax({
                url: apiUrl,
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify({
                    message: message,
                    @if (Auth::check())
                        user_id: {{ Auth::id() }},
                        conversation_id: null
                    @endif
                }),
                success: function(res) {
                    let reply = "Không có phản hồi từ AI";
                    if (res.reply) reply = res.reply;
                    if (res.data?.reply) reply = res.data.reply;

                    const newEl = $(`
                        <div class="flex items-start gap-2 ai-message">
                            <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">AI</div>
                            <div class="bg-white border border-teal-200 rounded-2xl px-4 py-3 max-w-[70%] shadow ai-text"></div>
                        </div>
                    `);

                    pendingEl.find("div.bg-gray-100").parent().replaceWith(newEl);

                    typeWriter(newEl.find(".ai-text"), reply, 10, function() {
                        setWaiting(false);
                    });
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    pendingEl.find("div.bg-gray-100").parent().replaceWith(`
                        <div class="flex items-start gap-2 ai-message">
                            <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">AI</div>
                            <div class="bg-red-100 border border-red-300 rounded-2xl px-4 py-3 max-w-[70%] shadow text-red-600">
                                ❌ Có lỗi khi gửi tin nhắn, vui lòng thử lại!
                            </div>
                        </div>
                    `);
                    setWaiting(false);
                }
            });
        }

        btnSend.on("click", function() {
            const message = input.val().trim();
            if (message) sendMessage(message);
        });

        quickBtns.on("click", function() {
            const message = $(this).text().trim();
            if (message) sendMessage(message);
        });

        input.on("keypress", function(e) {
            if (e.which === 13 && !e.shiftKey) {
                e.preventDefault();
                const message = input.val().trim();
                if (message) sendMessage(message);
            }
        });
    });
</script>
