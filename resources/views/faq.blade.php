<head>
    @include('Frontend.partials.head')
</head>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .rotate-180 {
      transform: rotate(180deg);
    }
  </style>
</head>
<body class="bg-gray-50 text-black">
        @include('Frontend.partials.header')

  <div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-10">Câu Hỏi Thường Gặp</h1>

    <div class="space-y-4">
      <!-- FAQ Item 1 -->
      <div class="bg-white rounded-2xl shadow p-5">
        <button onclick="toggleFAQ(1)" class="flex justify-between w-full text-left items-center">
          <h2 class="text-lg font-semibold">1. Tôi có thể đặt hàng như thế nào?</h2>
          <svg id="icon-1" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="faq-1" class="mt-3 hidden">
          Bạn có thể chọn sản phẩm, thêm vào giỏ hàng và tiến hành thanh toán theo hướng dẫn trên website.
        </div>
      </div>

      <!-- FAQ Item 2 -->
      <div class="bg-white rounded-2xl shadow p-5">
        <button onclick="toggleFAQ(2)" class="flex justify-between w-full text-left items-center">
          <h2 class="text-lg font-semibold">2. Tôi có thể thanh toán bằng phương thức nào?</h2>
          <svg id="icon-2" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="faq-2" class="mt-3 hidden">
          Chúng tôi hỗ trợ thanh toán qua MoMo, chuyển khoản ngân hàng và tiền mặt khi nhận hàng (COD).
        </div>
      </div>

      <!-- FAQ Item 3 -->
      <div class="bg-white rounded-2xl shadow p-5">
        <button onclick="toggleFAQ(3)" class="flex justify-between w-full text-left items-center">
          <h2 class="text-lg font-semibold">3. Bao lâu tôi nhận được hàng?</h2>
          <svg id="icon-3" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="faq-3" class="mt-3 hidden">
          Thời gian giao hàng từ 2 - 5 ngày làm việc tùy khu vực. Bạn sẽ nhận được mã theo dõi sau khi đặt hàng thành công.
        </div>
      </div>

      <!-- FAQ Item 4 -->
      <div class="bg-white rounded-2xl shadow p-5">
        <button onclick="toggleFAQ(4)" class="flex justify-between w-full text-left items-center">
          <h2 class="text-lg font-semibold">4. Tôi có thể đổi/trả hàng không?</h2>
          <svg id="icon-4" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="faq-4" class="mt-3 hidden">
          Có. Bạn có thể đổi/trả trong vòng 7 ngày nếu sản phẩm bị lỗi hoặc không đúng mô tả.
        </div>
      </div>

      <!-- FAQ Item 5 -->
      <div class="bg-white rounded-2xl shadow p-5">
        <button onclick="toggleFAQ(5)" class="flex justify-between w-full text-left items-center">
          <h2 class="text-lg font-semibold">5. Tôi có thể liên hệ ở đâu nếu có thắc mắc khác?</h2>
          <svg id="icon-5" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" stroke-width="2"
               viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>
        <div id="faq-5" class="mt-3 hidden">
          Bạn có thể liên hệ với chúng tôi qua trang <a href="/lien-he" class="underline text-blue-600">Liên hệ</a> hoặc hotline 1900 1234.
        </div>
      </div>
    </div>

    <!-- Câu hỏi khác -->
    <div class="bg-white rounded-2xl shadow p-6 mt-10">
      <h3 class="text-xl font-semibold mb-3">Bạn có câu hỏi khác?</h3>
      <p class="mb-4">Vui lòng nhập câu hỏi của bạn bên dưới, chúng tôi sẽ phản hồi sớm nhất có thể.</p>
      <form onsubmit="return validateQuestion()">
        <textarea id="questionInput" rows="4" placeholder="Nhập câu hỏi của bạn..."
          class="w-full p-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent resize-none"></textarea>
        <p id="errorText" class="text-red-500 text-sm mt-2 hidden">Vui lòng nhập câu hỏi trước khi gửi.</p>
        <button type="submit"
          class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-5 rounded-lg shadow transition">
          Gửi câu hỏi
        </button>
      </form>
    </div>
  </div>

  <script>
    function toggleFAQ(id) {
      const answer = document.getElementById('faq-' + id);
      const icon = document.getElementById('icon-' + id);

      answer.classList.toggle('hidden');
      icon.classList.toggle('rotate-180');
    }

    function validateQuestion() {
      const input = document.getElementById("questionInput");
      const error = document.getElementById("errorText");

      if (input.value.trim() === "") {
        error.classList.remove("hidden");
        input.classList.add("border-red-500", "ring-red-300", "focus:ring-red-300");
        return false;
      }

      error.classList.add("hidden");
      input.classList.remove("border-red-500", "ring-red-300", "focus:ring-red-300");
      alert("Câu hỏi của bạn đã được gửi!");
      return false; // giữ lại để không gửi form thực sự (trong demo)
    }
  </script>
      @include('Frontend.partials.footer')
    @include('Frontend.partials.modal')
</body>
@include('Frontend.partials.scrip')

