<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Verifikasi - Astera</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #58C1D1 0%, #4A90A4 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 30px;
            background-color: #ffffff;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .message {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
            margin-bottom: 30px;
        }
        .otp-container {
            background: linear-gradient(135deg, #58C1D1 0%, #4A90A4 100%);
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
        }
        .otp-code {
            font-size: 48px;
            font-weight: bold;
            color: white;
            letter-spacing: 8px;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .otp-label {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            margin-top: 10px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .warning p {
            margin: 0;
            font-size: 14px;
            color: #856404;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }
        .footer p {
            margin: 0;
            font-size: 12px;
            color: #6c757d;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">ASTERA</div>
            <h1>Kode OTP Verifikasi</h1>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo <strong>{{ $user->name }}</strong>,
            </div>
            
            <div class="message">
                Terima kasih telah mendaftar di Astera. Untuk menyelesaikan proses pendaftaran, 
                silakan masukkan kode OTP berikut:
            </div>
            
            <div class="otp-container">
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-label">Kode OTP Anda</div>
            </div>
            
            <div class="warning">
                <p><strong>⚠️ Penting:</strong></p>
                <p>• Kode ini berlaku selama 1 menit</p>
                <p>• Jangan bagikan kode ini kepada siapapun</p>
                <p>• Jika Anda tidak merasa mendaftar di Astera, abaikan email ini</p>
            </div>
            
            <div class="message">
                Jika kode OTP tidak muncul atau sudah expired, Anda dapat meminta kode baru 
                melalui halaman verifikasi.
            </div>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Astera. Semua hak dilindungi.</p>
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>
