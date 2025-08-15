<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phản hồi từ F1GENZ</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .header {
            background: linear-gradient(135deg, #fcc419, #fab005);
            padding: 30px;
            text-align: center;
            color: white;
        }
        
        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .header p {
            font-size: 16px;
            opacity: 0.9;
        }
        
        .content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        
        .message-section {
            background: #f8f9fa;
            border-left: 4px solid #fcc419;
            padding: 20px;
            margin: 25px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .message-section h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: 600;
        }
        
        .original-message {
            background: #e9ecef;
            padding: 15px;
            border-radius: 6px;
            font-style: italic;
            margin-bottom: 20px;
        }
        
        .admin-reply {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }
        
        .contact-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }
        
        .contact-info h3 {
            color: #856404;
            margin-bottom: 15px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .contact-item strong {
            min-width: 80px;
            color: #856404;
        }
        
        .footer {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .footer h3 {
            margin-bottom: 15px;
            font-size: 20px;
        }
        
        .footer p {
            margin-bottom: 8px;
            opacity: 0.9;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #fcc419;
            text-decoration: none;
            font-weight: 500;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
            margin: 30px 0;
        }
        
        .timestamp {
            font-size: 12px;
            color: #6c757d;
            text-align: right;
            margin-top: 15px;
        }
        
        @media (max-width: 600px) {
            .content {
                padding: 20px 15px;
            }
            
            .header {
                padding: 20px 15px;
            }
            
            .header h1 {
                font-size: 24px;
            }
            
            .message-section {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>👋 F1GENZ</h1>
            <p>Cảm ơn bạn đã liên hệ với chúng tôi</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">
                Xin chào <strong>{{ $customerName }}</strong>,
            </div>
            
            <p>Cảm ơn bạn đã liên hệ với F1GENZ! Chúng tôi đã nhận được tin nhắn của bạn và rất vui được phản hồi.</p>

            <div class="divider"></div>

            <!-- Original Message -->
            <div class="message-section">
                <h3>📨 Tin nhắn của bạn:</h3>
                <div class="original-message">
                    "{{ $originalMessage }}"
                </div>
                
                <!-- Admin Reply -->
                <h3>💬 Phản hồi từ chúng tôi:</h3>
                <div class="admin-reply">
                    {{ $adminReply }}
                </div>
                
                @if($repliedAt)
                <div class="timestamp">
                    Phản hồi vào: {{ $repliedAt->format('d/m/Y lúc H:i') }}
                </div>
                @endif
            </div>

            <div class="divider"></div>

            <p>Nếu bạn có thêm bất kỳ câu hỏi nào, đừng ngần ngại liên hệ lại với chúng tôi. Chúng tôi luôn sẵn sàng hỗ trợ bạn!</p>

            <!-- Contact Info -->
            <div class="contact-info">
                <h3>📞 Thông tin liên hệ</h3>
                <div class="contact-item">
                    <strong>Email:</strong> info@f1genz.com
                </div>
                <div class="contact-item">
                    <strong>Hotline:</strong> 1900 6868
                </div>
                <div class="contact-item">
                    <strong>Website:</strong> www.f1genz.com
                </div>
                <div class="contact-item">
                    <strong>Địa chỉ:</strong> 123 Đường ABC, Quận XYZ, TP.HCM
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>F1GENZ - Your Sneaker Destination</h3>
            <p>🏪 Cửa hàng giày sneaker uy tín hàng đầu Việt Nam</p>
            <p>✨ Chất lượng - Uy tín - Phong cách</p>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Instagram</a>
                <a href="#">TikTok</a>
                <a href="#">YouTube</a>
            </div>
            
            <div style="margin-top: 20px; font-size: 12px; opacity: 0.8;">
                © {{ date('Y') }} F1GENZ. All rights reserved.
            </div>
        </div>
    </div>
</body>
</html> 