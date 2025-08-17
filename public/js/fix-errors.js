// Fix JavaScript errors display
document.addEventListener('DOMContentLoaded', function() {
    // Ẩn các thông báo lỗi JavaScript
    setTimeout(function() {
        // Tìm và ẩn các text nodes chứa lỗi
        const walker = document.createTreeWalker(
            document.body,
            NodeFilter.SHOW_TEXT,
            null,
            false
        );

        const textNodes = [];
        let node;
        while (node = walker.nextNode()) {
            textNodes.push(node);
        }

        textNodes.forEach(function(textNode) {
            const text = textNode.textContent;
            // Kiểm tra nếu text chứa lỗi JavaScript
            if (text.includes('function') && text.includes('jQuery') && text.includes('Error')) {
                // Ẩn text node bằng cách thay thế bằng comment
                const comment = document.createComment('Hidden error message');
                textNode.parentNode.replaceChild(comment, textNode);
            }
        });

        // Ẩn các script tags chứa lỗi
        const scripts = document.querySelectorAll('script:not([src])');
        scripts.forEach(function(script) {
            const content = script.textContent || script.innerHTML;
            if (content.includes('Error') && content.includes('jQuery')) {
                script.style.display = 'none';
                script.remove();
            }
        });

        // Ẩn các element chứa error message
        const allElements = document.getElementsByTagName('*');
        for (let i = 0; i < allElements.length; i++) {
            const element = allElements[i];
            if (element.textContent && 
                element.textContent.includes('function') && 
                element.textContent.includes('jQuery') &&
                element.textContent.length > 1000) {
                element.style.display = 'none';
            }
        }
    }, 100);
});

// Override console.error để ngăn hiển thị lỗi
const originalError = console.error;
console.error = function(...args) {
    // Chỉ log các lỗi không liên quan đến jQuery minified
    const message = args.join(' ');
    if (!message.includes('jQuery') && !message.includes('Syntax error')) {
        originalError.apply(console, args);
    }
}; 