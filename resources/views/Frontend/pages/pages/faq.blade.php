<head>
    @include('Frontend.partials.head')
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
</head>
<body class="bg-light text-dark">
    @include('Frontend.partials.header')

    <div class="container py-5">
        <h1 class="display-5 fw-bold text-center mb-5">Câu Hỏi Thường Gặp</h1>

        <div class="accordion" id="faqAccordion">
            <!-- FAQ Item 1 -->
            <div class="card mb-3">
                <div class="card-header">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" onclick="toggleFAQ(1)">
                        <span>1. Tôi có thể đặt hàng như thế nào?</span>
                        <svg id="icon-1" class="" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="faq-1" class="card-body d-none">
                    Bạn có thể chọn sản phẩm, thêm vào giỏ hàng và tiến hành thanh toán theo hướng dẫn trên website.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="card mb-3">
                <div class="card-header">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" onclick="toggleFAQ(2)">
                        <span>2. Tôi có thể thanh toán bằng phương thức nào?</span>
                        <svg id="icon-2" class="" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="faq-2" class="card-body d-none">
                    Chúng tôi hỗ trợ thanh toán qua MoMo, chuyển khoản ngân hàng và tiền mặt khi nhận hàng (COD).
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="card mb-3">
                <div class="card-header">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" onclick="toggleFAQ(3)">
                        <span>3. Bao lâu tôi nhận được hàng?</span>
                        <svg id="icon-3" class="" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="faq-3" class="card-body d-none">
                    Thời gian giao hàng từ 2 - 5 ngày làm việc tùy khu vực. Bạn sẽ nhận được mã theo dõi sau khi đặt hàng thành công.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="card mb-3">
                <div class="card-header">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" onclick="toggleFAQ(4)">
                        <span>4. Tôi có thể đổi/trả hàng không?</span>
                        <svg id="icon-4" class="" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="faq-4" class="card-body d-none">
                    Có. Bạn có thể đổi/trả trong vòng 7 ngày nếu sản phẩm bị lỗi hoặc không đúng mô tả.
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="card mb-3">
                <div class="card-header">
                    <button class="btn w-100 d-flex justify-content-between align-items-center" type="button" onclick="toggleFAQ(5)">
                        <span>5. Tôi có thể liên hệ ở đâu nếu có thắc mắc khác?</span>
                        <svg id="icon-5" class="" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
                <div id="faq-5" class="card-body d-none">
                    Bạn có thể liên hệ với chúng tôi qua trang <a href="/lien-he" class="text-decoration-underline text-primary">Liên hệ</a> hoặc hotline 1900 1234.
                </div>
            </div>
        </div>

        <!-- Submit Question -->
        <div class="card mt-5">
            <div class="card-body">
                <h3 class="h5 fw-semibold mb-3">Bạn có câu hỏi khác?</h3>
                <p class="mb-3">Vui lòng nhập câu hỏi của bạn bên dưới, chúng tôi sẽ phản hồi sớm nhất có thể.</p>
                <form onsubmit="return validateQuestion()">
                    <div class="mb-3">
                        <textarea id="questionInput" rows="4" placeholder="Nhập câu hỏi của bạn..." class="form-control"></textarea>
                        <p id="errorText" class="text-danger small mt-2 d-none">Vui lòng nhập câu hỏi trước khi gửi.</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi câu hỏi</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleFAQ(id) {
            const answer = document.getElementById('faq-' + id);
            const icon = document.getElementById('icon-' + id);

            answer.classList.toggle('d-none');
            icon.classList.toggle('rotate-180');
        }

        function validateQuestion() {
            const input = document.getElementById("questionInput");
            const error = document.getElementById("errorText");

            if (input.value.trim() === "") {
                error.classList.remove("d-none");
                input.classList.add("is-invalid");
                return false;
            }

            error.classList.add("d-none");
            input.classList.remove("is-invalid");
            alert("Câu hỏi của bạn đã được gửi!");
            return false;
        }
    </script>

    @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
    @include('Frontend.partials.scrip')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>