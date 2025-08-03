<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>nickfinal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0&family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,1,0" />
    <style>
        /* Google Fonts - Inter */
@import url('https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,100..900&display=swap');

/* * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Inter", sans-serif;
} */

 /* body {
    width: 100%;
    min-height: 100vh;
    background: url('nick.mp4') no-repeat center center fixed;
    background-size: cover;
} */

#chatbot-toggler {
    position: fixed;
    bottom: 30px;
    right: 35px;
    border: none;
    height: 50px;
    width: 50px;
    display: flex;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #1E90FF;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    transition: all 0.2s ease;
    z-index: 99999 !important;
}

body.show-chatbot #chatbot-toggler {
    transform: rotate(90deg);
}

#chatbot-toggler span {
    color: #fff;
    position: absolute;
}

#chatbot-toggler span:last-child,
body.show-chatbot #chatbot-toggler span:first-child {
    opacity: 0;
}

body.show-chatbot #chatbot-toggler span:last-child {
    opacity: 1;
}

.chatbot-popup {
    position: fixed;
    right: 35px;
    bottom: 90px;
    width: 400px;
    max-width: 100vw;
    overflow: hidden;
    background: #fff;
    border-radius: 15px;
    opacity: 0;
    pointer-events: none;
    transform: scale(0.2);
    transform-origin: bottom right;
    box-shadow: 0 0 128px 0 rgba(0, 0, 0, 0.1),
        0 32px 64px -48px rgba(0, 0, 0, 0.5);
    transition: all 0.1s ease;
    z-index: 99998 !important;
}

body.show-chatbot .chatbot-popup {
    opacity: 1;
    pointer-events: auto;
    transform: scale(1);
}

.chat-header {
    display: flex;
    align-items: center;
    padding: 15px 22px;
    background: #1E90FF;
    justify-content: space-between;
}

.chat-header .header-info {
    display: flex;
    gap: 10px;
    align-items: center;
}

.header-info .chatbot-logo {
    width: 35px;
    height: 35px;
    padding: 6px;
    fill: #1E90FF;
    flex-shrink: 0;
    background: #fff;
    border-radius: 50%;
}

.header-info .logo-text {
    color: #fff;
    font-weight: 600;
    font-size: 1.31rem;
    letter-spacing: 0.02rem;
}

.chat-header #close-chatbot {
    border: none;
    color: #fff;
    height: 40px;
    width: 40px;
    font-size: 1.9rem;
    margin-right: -10px;
    padding-top: 2px;
    cursor: pointer;
    border-radius: 50%;
    background: none;
    transition: 0.2s ease;
}

.chat-header #close-chatbot:hover {
    background: #4169E1;
}

.chat-body {
    padding: 25px 22px;
    gap: 20px;
    display: flex;
    height: 420px;
    overflow-y: auto;
    margin-bottom: 82px;
    flex-direction: column;
    scrollbar-width: thin;
    scrollbar-color: #F0FFFF transparent;
}

.chat-body,
.chat-form .message-input:hover {
    scrollbar-color: #F0FFFF transparent;
}

.chat-body .message {
    display: flex;
    gap: 11px;
    align-items: center;
}

.chat-body .message .bot-avatar {
    width: 35px;
    height: 35px;
    padding: 6px;
    fill: #fff;
    flex-shrink: 0;
    margin-bottom: 2px;
    align-self: flex-end;
    border-radius: 50%;
    background: #1E90FF;
}

.chat-body .message .message-text {
    padding: 12px 16px;
    max-width: 75%;
    font-size: 0.95rem;
}

.chat-body .bot-message.thinking .message-text {
    padding: 2px 16px;
}

.chat-body .bot-message .message-text {
    background: #F2F2FF;
    border-radius: 13px 13px 13px 3px;
}

.chat-body .user-message {
    flex-direction: column;
    align-items: flex-end;
}

.chat-body .user-message .message-text {
    color: #fff;
    background: #1E90FF;
    border-radius: 13px 13px 3px 13px;
}

.chat-body .user-message .attachment {
    width: 50%;
    margin-top: -7px;
    border-radius: 13px 3px 13px 13px;
}

/* Styles cho kết quả tìm kiếm hình ảnh */
.ai-description {
    background: #f8f9fa;
    border-left: 3px solid #1E90FF;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
    font-size: 0.9rem;
    color: #666;
}

.bot-reply {
    margin-bottom: 15px;
    font-weight: 500;
}

.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.product-card {
    background: #fff;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    padding: 8px;
    position: relative;
    transition: all 0.3s ease;
}

.product-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.product-image {
    width: 100%;
    height: 80px;
    object-fit: cover;
    border-radius: 5px;
    margin-bottom: 5px;
}

.product-info {
    text-align: center;
}

.product-name {
    font-size: 0.8rem;
    font-weight: 500;
    margin: 0 0 3px 0;
    color: #333;
    line-height: 1.2;
}

.product-price {
    font-size: 0.75rem;
    color: #1E90FF;
    font-weight: 600;
    margin: 0;
}

.add-to-cart-btn {
    position: absolute;
    top: 5px;
    right: 5px;
    background: #1E90FF;
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 0.7rem;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background: #4169E1;
    transform: scale(1.1);
}

.chat-body .bot-message .thinking-indicator {
    display: flex;
    gap: 4px;
    padding-block: 15px;
}

.chat-body .bot-message .thinking-indicator .dot {
    height: 7px;
    width: 7px;
    opacity: 0.7;
    border-radius: 50%;
    background: #6F6BC2;
    animation: dotPulse 1.8s ease-in-out infinite;
}

.chat-body .bot-message .thinking-indicator .dot:nth-child(1) {
    animation-delay: 0.2s;
}

.chat-body .bot-message .thinking-indicator .dot:nth-child(2) {
    animation-delay: 0.3s;
}

.chat-body .bot-message .thinking-indicator .dot:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes dotPulse {
    0%, 44% { transform: translateY(0); }
    28% { opacity: 0.4; transform: translateY(-4px); }
    44% { opacity: 0.2; }
}

.chat-footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    background: #fff;
    padding: 15px 22px 20px;
}

.chat-footer .chat-form {
    display: flex;
    align-items: center;
    position: relative;
    background: #fff;
    border-radius: 32px;
    outline: 1px solid #CCCCE5;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.06);
    transition: 0s ease, border-radius 0s;
}

.chat-form:focus-within {
    outline: 2px solid #1E90FF;
}

.chat-form .message-input {
    width: 100%;
    height: 47px;
    outline: none;
    resize: none;
    border: none;
    max-height: 180px;
    scrollbar-width: thin;
    border-radius: inherit;
    font-size: 0.95rem;
    padding: 14px 0 12px 18px;
    scrollbar-color: transparent transparent;
}

.chat-form .chat-controls {
    gap: 3px;
    height: 47px;
    display: flex;
    padding-right: 6px;
    align-items: center;
    align-self: flex-end;
}

.chat-form .chat-controls button {
    height: 35px;
    width: 35px;
    border: none;
    cursor: pointer;
    color: #706DB0;
    border-radius: 50%;
    font-size: 1.15rem;
    background: none;
    transition: 0.2s ease;
}

.chat-form .chat-controls button:hover,
body.show-emoji-picker .chat-controls #emoji-picker {
    color: #4169E1;
    background: #f1f1ff;
}

.chat-form .chat-controls #send-message {
    color: #fff;
    display: none;
    background: #1E90FF;
}

.chat-form .chat-controls #send-message:hover {
    background: #4169E1;
}

.chat-form .message-input:valid~.chat-controls #send-message {
    display: block;
}

.chat-form .file-upload-wrapper {
    position: relative;
    height: 35px;
    width: 35px;
}

.chat-form .file-upload-wrapper :where(button, img) {
    position: absolute;
}

.chat-form .file-upload-wrapper img {
    height: 100%;
    width: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.chat-form .file-upload-wrapper #file-cancel {
    color: #ff0000;
    background: #fff;
}

.chat-form .file-upload-wrapper :where(img, #file-cancel),
.chat-form .file-upload-wrapper.file-uploaded #file-upload {
    display: none;
}

.chat-form .file-upload-wrapper.file-uploaded img,
.chat-form .file-upload-wrapper.file-uploaded:hover #file-cancel {
    display: block;
}

em-emoji-picker {
    position: absolute;
    left: 50%;
    top: -337px;
    width: 100%;
    max-width: 350px;
    visibility: hidden;
    max-height: 330px;
    transform: translateX(-50%);
}

body.show-emoji-picker em-emoji-picker {
    visibility: visible;
}

.product-list {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-top: 10px;
    width: 100%;
}

.product-card {
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    background: #f9f9f9;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    transition: box-shadow 0.2s ease;
}
.product-card:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.product-card a {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none;
    color: inherit;
    padding: 10px;
}

.product-image {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 6px;
    flex-shrink: 0;
    border: 1px solid #eee;
}

.product-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.product-name {
    font-weight: 600;
    font-size: 0.9rem;
    margin: 0;
    line-height: 1.3;
}

.product-price {
    font-size: 0.85rem;
    color: #e53935;
    font-weight: 500;
    margin: 0;
}

/* Add to cart button styles */
.product-card .add-to-cart-btn {
    margin-left: 10px;
    padding: 0;
    width: 32px;
    height: 32px;
    border: 1px solid #1E90FF;
    background-color: #1E90FF;
    color: #fff;
    border-radius: 50%;
    cursor: pointer;
    font-size: 1.2rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s, opacity 0.2s;
    white-space: nowrap;
}
.product-card .add-to-cart-btn span {
    font-size: 1.5rem;
    line-height: 1;
}
.product-card .add-to-cart-btn:hover {
    background-color: #4169E1;
}
.product-card .add-to-cart-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background-color: #1E90FF;
}

.product-card .add-to-cart-btn.success {
    background-color: #28a745;
    border-color: #28a745;
}

/* Adjust product card layout */
.product-card {
    display: flex;
    align-items: center;
    padding: 8px;
}
.product-card a {
    padding: 0; /* Override padding for anchor inside card */
    flex-grow: 1; /* Allow info to take up space */
}

/* Responsive media query for mobile screens */
@media (max-width: 520px) {

    #chatbot-toggler {
        right: 20px;
        bottom: 20px;
    }
    .chatbot-popup {
        right: 0;
        bottom: 0;
        height: 100%;
        border-radius: 0;
        width: 100%;
    }
    .chatbot-popup .chat-header {
        padding: 12px 15px;
    }
    .chat-body {
        height: calc(90% - 55px);
        padding: 25px 15px;
    }
    .chat-footer {
        padding: 10px 15px 15px;
    }
    .chat-form .file-upload-wrapper.file-uploaded #file-cancel {
        opacity: 0;
    }
    .chatbot-logo, .bot-avatar {
        object-fit: cover; /* Đảm bảo hình ảnh không bị méo */
    }
}
    </style>
</head>
<body>
    <button id="chatbot-toggler">
        <span class="material-symbols-rounded">mode_comment</span>
        <span class="material-symbols-rounded">close</span>
    </button>
    <div class="chatbot-popup">
        <div class="chat-header">
            <div class="header-info">
                <img class="chatbot-logo" src="nick.jpg" alt="Chatbot Logo" width="50" height="50">
            <h2 class="logo-text">NICK FINAL</h2>
            </div>
            <button id="close-chatbot" class="material-symbols-rounded">keyboard_arrow_down</button>
        </div>
        <div class="chat-body">
            <div class="message bot-message">
            <svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                <path
                d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"
                />
            </svg>
            <div class="message-text"> Xin chào 👋<br /> Tôi có thể giúp gì cho bạn hôm nay? </div>
            </div>
        </div>
        <div class="chat-footer">
            <form action="/chat/image-search-vector" class="chat-form">
            <textarea placeholder="Message..." class="message-input" required></textarea>
            <div class="chat-controls">
                <button type="button" id="emoji-picker" class="material-symbols-outlined">sentiment_satisfied</button>
                <div class="file-upload-wrapper">
                <input type="file" id="file-input" hidden />
                <img src="#" />
                <button type="button" id="file-upload" class="material-symbols-rounded">attach_file</button>
                <button type="button" id="file-cancel" class="material-symbols-rounded">close</button>
                </div>
                <button type="submit" id="send-message" class="material-symbols-rounded">arrow_upward</button>
            </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@latest/dist/browser.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.17.2/dist/sweetalert2.all.min.js"></script>
    <script>
    const chatBody = document.querySelector(".chat-body");
const messageInput = document.querySelector(".message-input");
const sendMessageButton = document.querySelector("#send-message");
const fileInput = document.querySelector("#file-input");
const fileUploadWrapper = document.querySelector(".file-upload-wrapper");
const fileCancelButton = document.querySelector("#file-cancel");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const closeChatbot = document.querySelector("#close-chatbot");


// Api setup
const API_KEY = "AIzaSyAKa06ydnfEI6uI-rfBOUslzKpjk91a65Y";
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=${API_KEY}`;

const userData = {
    message: null,
    file: {
        data: null,
        mime_type: null
    }
};


const chatHistory = [];

const initialInputHeight = messageInput.scrollHeight;

const createMessageElement = (content, ...classes) => {
    const div = document.createElement("div");
    div.classList.add("message", ...classes);
    div.innerHTML = content;
    return div;
};

const renderProducts = (products) => {
    if (!products || products.length === 0) return '';
    let productHTML = '<div class="product-list">';
    products.forEach(product => {
        productHTML += `
            <div class="product-card">
                <a href="${product.url}" target="_blank" title="${product.name}">
                    <img src="${product.image}" alt="${product.name}" class="product-image">
                    <div class="product-info">
                        <p class="product-name">${product.name}</p>
                        <p class="product-price">${product.price}</p>
                    </div>
                </a>
                <button class="add-to-cart-btn" data-product-id="${product.id}" title="Thêm vào giỏ hàng">
                    <span class="material-symbols-rounded">add</span>
                </button>
            </div>
        `;
    });
    productHTML += '</div>';
    return productHTML;
};

const generateBotResponse = async (incomingMessageDiv) => {
    const messageElement = incomingMessageDiv.querySelector(".message-text");
    const userMessage = userData.message.toLowerCase();

    // Kiểm tra nếu có file hình ảnh
    if (userData.file.data) {
        // Xử lý tìm kiếm bằng hình ảnh
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const formData = new FormData();

            // Chuyển base64 thành file
            const byteCharacters = atob(userData.file.data);
            const byteNumbers = new Array(byteCharacters.length);
            for (let i = 0; i < byteCharacters.length; i++) {
                byteNumbers[i] = byteCharacters.charCodeAt(i);
            }
            const byteArray = new Uint8Array(byteNumbers);
            const blob = new Blob([byteArray], { type: userData.file.mime_type });
            formData.append('image', blob, 'image.jpg');

            const response = await fetch('/chat/image-search-vector', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Lỗi Server: ${response.statusText}`);
            }

            const data = await response.json();

            if (data.success) {
                let products = [];
                if (data.products && Array.isArray(data.products)) {
                    products = data.products;
                } else if (data.product) {
                    products = [data.product];
                }
                const description = data.description;

                // Hiển thị mô tả AI và sản phẩm
                let replyHTML = `<div class="ai-description"><strong>AI phân tích:</strong> ${typeof description === 'object' ? description.description || JSON.stringify(description) : description}</div>`;
                replyHTML += `<div class="bot-reply">${data.message}</div>`;
                replyHTML += renderProducts(products);

                messageElement.innerHTML = replyHTML;
            } else {
                messageElement.innerText = data.message || "Không thể xử lý hình ảnh. Vui lòng thử lại.";
                messageElement.style.color = "#ff0000";
            }

        } catch (error) {
            messageElement.innerText = error.message;
            messageElement.style.color = "#ff0000";
        }

        // Reset file data
        userData.file = {};
        fileUploadWrapper.classList.remove("file-uploaded");

    } else {
        // Xử lý text message như cũ
        const productKeywords = ['sản phẩm', 'giày', 'nike', 'adidas', 'puma', 'vans', 'converse', 'giá', 'danh mục', 'thương hiệu', 'cỡ', 'size', 'màu', 'mua', 'tìm'];
        const isProductQuery = productKeywords.some(keyword => userMessage.includes(keyword));

        if (isProductQuery) {
            // --- GỌI VỀ SERVER LARAVEL ---
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ message: userData.message }),
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.reply || `Lỗi Server: ${response.statusText}`);
                }

                const data = await response.json();
                const botReply = data.reply || "Đây là sản phẩm tôi tìm thấy cho bạn:";
                const products = data.products || [];

                // Hiển thị câu trả lời và sản phẩm
                messageElement.innerHTML = botReply + renderProducts(products);

            } catch (error) {
                messageElement.innerText = error.message;
                messageElement.style.color = "#ff0000";
            }

        } else {
            // --- GỌI THẲNG TỚI GOOGLE GEMINI (VU VƠ) ---
            chatHistory.push({
                role: "user",
                parts: [{ text: userData.message }],
            });

            const requestOptions = {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ contents: chatHistory }),
            };

            try {
                const response = await fetch(API_URL, requestOptions);
                const data = await response.json();
                if (!response.ok) throw new Error(data.error.message);
                const apiResponseText = data.candidates[0].content.parts[0].text.replace(/\*\*(.*?)\*\*/g, "$1").trim();
                messageElement.innerText = apiResponseText;
                chatHistory.push({
                    role: "model",
                    parts: [{ text: apiResponseText }]
                });
            } catch (error) {
                messageElement.innerText = error.message;
                messageElement.style.color = "#ff0000";
            }
        }
    }

    // Hoàn tất
    incomingMessageDiv.classList.remove("thinking");
    chatBody.scrollTo({ behavior: "smooth", top: chatBody.scrollHeight });
};

const handleOutgoingMessage = (e) => {
    e.preventDefault();
    userData.message = messageInput.value.trim();
    messageInput.value = "";
    fileUploadWrapper.classList.remove("file-uploaded");
    messageInput.dispatchEvent(new Event("input"));

    const messageContent = `<div class="message-text"></div>
                            ${userData.file.data ? `<img src="data:${userData.file.mime_type};base64,${userData.file.data}" class="attachment" />` : ""}`;

    const outgoingMessageDiv = createMessageElement(messageContent, "user-message");
    outgoingMessageDiv.querySelector(".message-text").innerText = userData.message;
    chatBody.appendChild(outgoingMessageDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
    setTimeout(() => {
        const messageContent = `<svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024">
                    <path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"></path>
                </svg>
                <div class="message-text">
                    <div class="thinking-indicator">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>`;
        const incomingMessageDiv = createMessageElement(messageContent, "bot-message", "thinking");
        chatBody.appendChild(incomingMessageDiv);
        chatBody.scrollTo({ behavior: "smooth", top: chatBody.scrollHeight });
        generateBotResponse(incomingMessageDiv);
    }, 600);
};
messageInput.addEventListener("keydown", (e) => {
    const userMessage = e.target.value.trim();
    if (e.key === "Enter" && userMessage && !e.shiftKey && window.innerWidth > 768) {
        handleOutgoingMessage(e);
    }
});
messageInput.addEventListener("input", (e) => {
    messageInput.style.height = `${initialInputHeight}px`;
    messageInput.style.height = `${messageInput.scrollHeight}px`;
    document.querySelector(".chat-form").style.boderRadius = messageInput.scrollHeight > initialInputHeight ? "15px" : "32px";
});
fileInput.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = (e) => {
        fileUploadWrapper.querySelector("img").src = e.target.result;
        fileUploadWrapper.classList.add("file-uploaded");
        const base64String = e.target.result.split(",")[1];

        userData.file = {
            data: base64String,
            mime_type: file.type
        };

        fileInput.value = "";
    };

    reader.readAsDataURL(file);
});
fileCancelButton.addEventListener("click", (e) => {
    userData.file = {};
    fileUploadWrapper.classList.remove("file-uploaded");
});

// Xử lý nút "Thêm vào giỏ hàng"
document.addEventListener('click', async (e) => {
    if (e.target.closest('.add-to-cart-btn')) {
        const button = e.target.closest('.add-to-cart-btn');
        const productId = button.getAttribute('data-product-id');

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/chat/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                }),
            });

            const data = await response.json();

            if (response.ok) {
                // Hiển thị thông báo thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });

                // Thay đổi icon nút
                button.innerHTML = '<span class="material-symbols-rounded">check</span>';
                button.style.background = '#28a745';
                setTimeout(() => {
                    button.innerHTML = '<span class="material-symbols-rounded">add</span>';
                    button.style.background = '#1E90FF';
                }, 2000);
            } else {
                throw new Error(data.message || 'Lỗi khi thêm vào giỏ hàng');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Lỗi!',
                text: error.message,
                timer: 3000,
                showConfirmButton: false
            });
        }
    }
});
const picker = new EmojiMart.Picker({
    theme: "light",
    showSkinTones: "none",
    previewPosition: "none",
    onEmojiSelect: (emoji) => {
        const { selectionStart: start, selectionEnd: end } = messageInput;
        messageInput.setRangeText(emoji.native, start, end, "end");
        messageInput.focus();
    },
    onClickOutside: (e) => {
        if (e.target.id === "emoji-picker") {
            document.body.classList.toggle("show-emoji-picker");
        } else {
            document.body.classList.remove("show-emoji-picker");
        }
    },
});
document.querySelector(".chat-form").appendChild(picker);
fileInput.addEventListener("change", async (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const validImageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    if (!validImageTypes.includes(file.type)) {
        await Swal.fire({
            icon: 'error',
            title: 'Lỗi',
            text: 'Chỉ chấp nhận file ảnh (JPEG, PNG, GIF, WEBP)',
            confirmButtonText: 'OK'
        });
        resetFileInput();
        return;
    }
    const reader = new FileReader();
    reader.onload = (e) => {
        fileUploadWrapper.querySelector("img").src = e.target.result;
        fileUploadWrapper.classList.add("file-uploaded");
        const base64String = e.target.result.split(",")[1];
        userData.file = {
            data: base64String,
            mime_type: file.type
        };
    };
    reader.readAsDataURL(file);
});
function resetFileInput() {
    fileInput.value = "";
    fileUploadWrapper.classList.remove("file-uploaded");
    fileUploadWrapper.querySelector("img").src = "#";
    userData.file = { data: null, mime_type: null };
    document.querySelector(".chat-form").reset();
}
sendMessageButton.addEventListener("click", (e) => handleOutgoingMessage(e));
document.querySelector("#file-upload").addEventListener("click", (e) => fileInput.click());
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
closeChatbot.addEventListener("click", () => document.body.classList.remove("show-chatbot"));

chatBody.addEventListener('click', async (e) => {
    // Tìm phần tử button cha gần nhất nếu click vào icon bên trong
    const button = e.target.closest('.add-to-cart-btn');

    // Chỉ thực hiện nếu nút tồn tại và chưa được xử lý (chưa có class success)
    if (button && !button.classList.contains('success')) {
        const productId = button.dataset.productId;
        const originalHTML = button.innerHTML; // Lưu lại icon '+' ban đầu

        button.innerHTML = '...'; // Trạng thái đang xử lý
        button.disabled = true;

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch('/chat/add-to-cart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Có lỗi xảy ra khi thêm sản phẩm.');
            }

            const botAvatar = `<svg class="bot-avatar" xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 1024 1024"><path d="M738.3 287.6H285.7c-59 0-106.8 47.8-106.8 106.8v303.1c0 59 47.8 106.8 106.8 106.8h81.5v111.1c0 .7.8 1.1 1.4.7l166.9-110.6 41.8-.8h117.4l43.6-.4c59 0 106.8-47.8 106.8-106.8V394.5c0-59-47.8-106.9-106.8-106.9zM351.7 448.2c0-29.5 23.9-53.5 53.5-53.5s53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5-53.5-23.9-53.5-53.5zm157.9 267.1c-67.8 0-123.8-47.5-132.3-109h264.6c-8.6 61.5-64.5 109-132.3 109zm110-213.7c-29.5 0-53.5-23.9-53.5-53.5s23.9-53.5 53.5-53.5 53.5 23.9 53.5 53.5-23.9 53.5-53.5 53.5zM867.2 644.5V453.1h26.5c19.4 0 35.1 15.7 35.1 35.1v121.1c0 19.4-15.7 35.1-35.1 35.1h-26.5zM95.2 609.4V488.2c0-19.4 15.7-35.1 35.1-35.1h26.5v191.3h-26.5c-19.4 0-35.1-15.7-35.1-35.1zM561.5 149.6c0 23.4-15.6 43.3-36.9 49.7v44.9h-30v-44.9c-21.4-6.5-36.9-26.3-36.9-49.7 0-28.6 23.3-51.9 51.9-51.9s51.9 23.3 51.9 51.9z"/></svg>`;
            const successMessageContent = `${botAvatar}<div class="message-text">${data.message}</div>`;
            const successMessageDiv = createMessageElement(successMessageContent, "bot-message");
            chatBody.appendChild(successMessageDiv);
            chatBody.scrollTo({ behavior: "smooth", top: chatBody.scrollHeight });

            // Chuyển nút sang trạng thái thành công (icon check)
            button.innerHTML = '<span class="material-symbols-rounded">check</span>';
            button.classList.add('success');
            // Nút vẫn bị disabled để không cho nhấn lại

        } catch (error) {
            // Khôi phục lại trạng thái ban đầu nếu có lỗi
            button.innerHTML = originalHTML;
            button.disabled = false;
            console.error("Add to cart error:", error);
        }
    }
});
    </script>
</body>
</html>
