$(function () {
    const randomMessages = [
        "Xin chào bạn 👋",
        "Hãy khám phá MyExpenseVn nhé 🚀",
        "Cần giúp gì thì bấm vào mình nha 😊",
        "MyExpenseVn – Quản lý chi tiêu dễ dàng 💰",
    ];

    const aiWatcher = $("#aiWatcher");
    const pupils = $("#leftPupil, #rightPupil");
    const speechBubble = $("#speechBubble");
    const chatModal = $("#chatModal");
    const showMessage = (text) => {
        speechBubble.text(text).addClass("show");
        setTimeout(() => speechBubble.removeClass("show"), 3000);
    };

    $(document).on("mousemove", (e) => {
        const rect = aiWatcher[0].getBoundingClientRect();
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;

        const angle = Math.atan2(e.clientY - centerY, e.clientX - centerX);
        const distance = Math.min(
            6,
            Math.hypot(e.clientX - centerX, e.clientY - centerY) / 50
        );

        pupils.css(
            "transform",
            `translate(calc(-50% + ${Math.cos(angle) * distance
            }px), calc(-50% + ${Math.sin(angle) * distance}px))`
        );
    });

    setInterval(() => {
        const msg =
            randomMessages[Math.floor(Math.random() * randomMessages.length)];
        showMessage(msg);
    }, 10000);

    speechBubble.on("click", (e) => {
        if (speechBubble.hasClass("show")) {
            chatModal.removeClass("hidden");
        }

        e.stopPropagation();
    });


    aiWatcher.on("click", () => {
        chatModal.removeClass("hidden");
    });

    $("#closeChat").on("click", () => chatModal.addClass("hidden"));
});
