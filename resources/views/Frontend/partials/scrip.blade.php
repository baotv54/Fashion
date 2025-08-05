<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.favorite-form').on('submit', function(e) {
            e.preventDefault();

            var form = $(this);
            var btn = form.find('button.favorite-btn');
            var countEl = $('#wishlist-count'); // 💥 sửa ở đây
            var countText = countEl.text().trim();
            var count = parseInt(countText, 10);
            if (isNaN(count)) count = 0;

            $.ajax({
                url: form.attr('action'),
                method: 'POST',
                data: form.serialize(),
                success: function(response) {
                    var productId = form.find('input[name="product_id"]').val();
                    
                    if (response.status === 'added') {
                        // Cập nhật tất cả button yêu thích của sản phẩm này
                        $('.favorite-btn[data-product-id="' + productId + '"]').css({
                            'color': '#dc3545',
                            'background': 'rgba(220, 53, 69, 0.1)'
                        });
                        countEl.text(count + 1);
                        
                        // Hiển thị thông báo thêm thành công
                        // showToast('Đã thêm vào danh sách yêu thích!', 'success');
                        
                    } else if (response.status === 'removed') {
                        // Cập nhật button yêu thích ở section favorites và products
                        $('.favorite-product-card .favorite-btn[data-product-id="' + productId + '"], .product-item .favorite-btn[data-product-id="' + productId + '"]').css({
                            'color': 'gray',
                            'background': 'transparent'
                        });
                        
                        // Cập nhật button yêu thích ở section bestselling (màu cam)
                        $('.bestselling-product-card .favorite-btn[data-product-id="' + productId + '"]').css({
                            'color': '#ff6b35',
                            'background': 'transparent'
                        });
                        
                        countEl.text(Math.max(count - 1, 0));
                        
                        // Hiển thị thông báo xóa thành công
                        showToast('Đã xóa khỏi danh sách yêu thích!', 'info');

                        // Xóa khỏi trang favorites
                        if (window.location.pathname === '{{ route("favorites.index") }}') {
                            form.closest('.product-item').remove();
                        }
                        
                        // Xóa khỏi section favorites ở trang chủ
                        if (window.location.pathname === '/') {
                            $('.favorite-product-card').each(function() {
                                var cardProductId = $(this).find('input[name="product_id"]').val();
                                if (cardProductId === productId) {
                                    $(this).fadeOut(300, function() {
                                        $(this).remove();
                                        // Ẩn section nếu không còn sản phẩm yêu thích
                                        if ($('.favorite-product-card').length === 0) {
                                            $('.home-favorites').fadeOut(500);
                                        }
                                    });
                                }
                            });
                        }
                    }
                },
                error: function() {
                    window.location.href = '{{ route("account.login") }}';
                }
            });
        });
    });

    // Hàm hiển thị thông báo toast
    function showToast(message, type = 'success') {
        // Tạo toast element
        const toast = $(`
            <div class="custom-toast toast-${type}" style="
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${type === 'success' ? '#28a745' : '#17a2b8'};
                color: white;
                padding: 15px 20px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                z-index: 9999;
                font-weight: 600;
                display: none;
                min-width: 300px;
            ">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'info-circle'}" style="margin-right: 8px;"></i>
                ${message}
            </div>
        `);
        
        // Thêm vào body và hiển thị
        $('body').append(toast);
        toast.fadeIn(300);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    let chatOpened = false;

    function toggleChat() {
        const chatbot = document.getElementById('chatbot');
        const display = document.getElementById('chat-display');

        if (!chatOpened) {
            chatbot.style.display = 'flex';
            loadChatHistory(display);
            chatOpened = true;
        } else {
            chatbot.style.display = 'none';
            chatOpened = false;
        }
    }

    function loadChatHistory(display) {
        fetch('/chat/history')
            .then(res => res.json())
            .then(data => {
                display.innerHTML = '';
                data.history.forEach(msg => {
                    const bubble = document.createElement('div');
                    bubble.className = 'chat-bubble ' + (msg.role === 'user' ? 'user-bubble' : 'bot-bubble');
                    bubble.innerText = msg.message;
                    display.appendChild(bubble);
                });
                display.scrollTop = display.scrollHeight;
            });
    }

    function sendChat() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        const display = document.getElementById('chat-display');

        if (!message) return;

        const userBubble = document.createElement('div');
        userBubble.className = 'chat-bubble user-bubble';
        userBubble.innerText = message;
        display.appendChild(userBubble);

        input.value = '';
        display.scrollTop = display.scrollHeight;

        const typingIndicator = document.createElement('div');
        typingIndicator.className = 'chat-bubble bot-bubble';
        typingIndicator.innerText = 'Đang trả lời...';
        display.appendChild(typingIndicator);
        display.scrollTop = display.scrollHeight;

        fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message
                })
            })
            .then(res => res.json())
            .then(data => {
                display.removeChild(typingIndicator);

                const botBubble = document.createElement('div');
                botBubble.className = 'chat-bubble bot-bubble';
                botBubble.innerText = data.reply;
                display.appendChild(botBubble);

                if (data.products && data.products.length > 0) {
                    const productWrap = document.createElement('div');
                    productWrap.style.display = 'flex';
                    productWrap.style.flexDirection = 'column';
                    productWrap.style.gap = '10px';
                    productWrap.style.marginTop = '10px';

                    data.products.forEach(product => {
                        const card = document.createElement('div');
                        card.style.border = '1px solid #ddd';
                        card.style.borderRadius = '10px';
                        card.style.padding = '10px';
                        card.style.background = '#fff';
                        card.style.display = 'flex';
                        card.style.gap = '10px';
                        card.style.alignItems = 'center';

                        card.innerHTML = `
                        <img src="${product.image}" width="60" height="60" style="border-radius: 6px; object-fit: cover;">
                        <div style="flex:1">
                            <div><strong>${product.name}</strong></div>
                            ${product.brand ? `<div style="font-size: 13px;">Thương hiệu: ${product.brand}</div>` : ''}
                            ${product.category ? `<div style="font-size: 13px;">Danh mục: ${product.category}</div>` : ''}
                            <div style="color: #007bff; font-weight: bold;">${product.price}</div>
                            <a href="${product.url}" target="_blank" style="font-size: 13px; color: #007bff;">Xem chi tiết</a>
                            <button onclick="addToCartFromChat(${product.id}, '${product.variant_id ?? ''}')"
                                style="margin-top: 5px; background:#28a745; color:white; border:none; padding:5px 10px; border-radius:4px; font-size: 13px; cursor:pointer;">
                                🛒 Thêm vào giỏ
                            </button>
                        </div>
                    `;

                        productWrap.appendChild(card);
                    });

                    display.appendChild(productWrap);
                }

                display.scrollTop = display.scrollHeight;
            })
            .catch(() => {
                display.removeChild(typingIndicator);

                const botBubble = document.createElement('div');
                botBubble.className = 'chat-bubble bot-bubble';
                botBubble.innerText = 'Bot gặp lỗi kết nối.';
                display.appendChild(botBubble);
            });
    }

    // ✅ Thêm giỏ hàng từ chatbot (phân biệt có hoặc không có biến thể)
    function addToCartFromChat(productId, variantId = '') {
        const quantity = 1;

        if (variantId && variantId !== 'null' && variantId !== '') {
            // Gọi route thêm biến thể
            fetch('/chat/add-variant-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        variant_id: variantId,
                        quantity: quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message || 'Đã thêm vào giỏ hàng!');
                })
                .catch(() => {
                    alert('Lỗi khi thêm biến thể vào giỏ hàng.');
                });
        } else {
            // Gọi route thêm sản phẩm thường
            fetch('/chat/add-to-cart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: quantity
                    })
                })
                .then(res => res.json())
                .then(data => {
                    alert(data.message || 'Đã thêm vào giỏ hàng!');
                })
                .catch(() => {
                    alert('Lỗi khi thêm sản phẩm vào giỏ hàng.');
                });
        }
    }
</script>

<script>
    $("body").removeClass("preload");

    document.addEventListener('lazybeforeunveil', function(e) {
        var bg = e.target.getAttribute('data-bg');
        if (bg) e.target.style.backgroundImage = 'url(' + bg + ')';
    });

    if (window.noPS) {
        window.addEventListener("load", (event) => {
            if ($('input[name="Token"]').length > 0) {
                $.getScript('https://www.google.com/recaptcha/apif78f.js?render=6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK').done(function(s, r) {
                    $('head').append(s);
                    $('input[name="Token"]').each(function() {
                        var flagId = $(this).attr('id');
                        grecaptcha.ready(function() {
                            grecaptcha.execute('6Ldtu4IUAAAAAMQzG1gCw3wFlx_GytlZyLrXcsuK', {
                                    action: 'submit'
                                })
                                .then(function(token) {
                                    document.getElementById(flagId).value = token;
                                });
                        });
                    });
                });
            }

            $('img[loading="lazy"]').each(function() {
                $(this).removeAttr('loading');
            });
        });
    } else {
        // Jquery touch
        jQuery.event.special.touchstart = {
            setup: function(e, t, n) {
                this.addEventListener("touchstart", n, {
                    passive: !t.includes("noPreventDefault")
                });
            }
        };
        jQuery.event.special.touchmove = {
            setup: function(e, t, n) {
                this.addEventListener("touchmove", n, {
                    passive: !t.includes("noPreventDefault")
                });
            }
        };
    }
</script>
<button class="overplay-all" title="Đóng"></button>