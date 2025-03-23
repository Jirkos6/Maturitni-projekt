<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet vytvořen</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: #334155;
            line-height: 1.6;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.06);
        }

        .header {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            padding: 32px 24px;
            text-align: center;
        }

        .header h1 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
            letter-spacing: -0.025em;
        }

        .header p {
            font-size: 16px;
            opacity: 0.9;
            letter-spacing: -0.01em;
        }

        .content {
            padding: 32px 28px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1e3a8a;
            margin-bottom: 20px;
            letter-spacing: -0.01em;
        }

        .message {
            color: #475569;
            margin-bottom: 20px;
            font-size: 15px;
        }

        .credentials-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-left: 4px solid #0284c7;
            border-radius: 10px;
            padding: 22px;
            margin: 25px 0;
        }

        .credentials-item {
            margin-bottom: 14px;
        }

        .credentials-label {
            font-weight: 600;
            color: #0369a1;
            display: inline-block;
            width: 100px;
        }

        .credentials-value {
            font-weight: 600;
            color: #0f172a;
            font-family: 'SF Mono', 'Cascadia Code', Menlo, monospace;
            background-color: #e0f2fe;
            padding: 2px 8px;
            border-radius: 4px;
        }

        .divider {
            height: 1px;
            background: #e2e8f0;
            margin: 28px 0;
        }

        .btn-container {
            text-align: center;
            margin: 32px 0;
        }

        .btn-primary {
            display: inline-block;
            background: linear-gradient(135deg, #8ca3f8, #8db6f8);
            color: white;
            padding: 14px 28px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            border: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(59, 130, 246, 0.5);
        }

        .text-center {
            text-align: center;
            margin-top: 16px;
            font-size: 14px;
            color: #64748b;
        }

        .text-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
            margin-top: 6px;
            display: inline-block;
        }

        .text-link:hover {
            text-decoration: underline;
        }

        .note {
            font-size: 14px;
            color: #64748b;
            margin-top: 18px;
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 12px 16px;
            border: 1px solid #e2e8f0;
        }

        .note strong {
            color: #0369a1;
        }

        .footer {
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            padding: 24px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .brand-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 16px;
        }

        .logo {
            height: 36px;
            width: 36px;
            border-radius: 8px;
            margin-right: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .brand-name {
            font-weight: 600;
            color: #1e40af;
        }

        .support-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .support-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1 style="color: white !important;">Váš účet byl úspěšně vytvořen!</h1>
            <p>Vítejte v systému skautského oddílu Kormorán</p>
        </div>

        <div class="content">
            <h2 class="greeting">
                Vážená Paní, Vážený Pane {{ $name }} {{ $surname }}
            </h2>

            <p class="message">
                Váš účet byl úspěšně vytvořen a je připraven k použití. Níže najdete své
                přihlašovací údaje:
            </p>

            <div class="credentials-box">
                <div class="credentials-item">
                    <span class="credentials-label">E-mail:</span>
                    <span class="credentials-value">{{ $email }}</span>
                </div>
                <div class="credentials-item">
                    <span class="credentials-label">Heslo:</span>
                    <span class="credentials-value">{{ $password }}</span>
                </div>
            </div>

            <p class="note">
                <strong>Bezpečnostní doporučení:</strong> Z důvodu zvýšení bezpečnosti vašeho účtu si prosím po prvním
                přihlášení změňte heslo v sekci nastavení účtu.
            </p>

            <div class="divider"></div>

            <div class="btn-container">
                <a href="{{ url('/login') }}" class="btn-primary">
                    Přihlásit se nyní
                </a>
            </div>

            <div class="text-center">
                <p>Nebo použijte tento odkaz:</p>
                <a href="{{ url('/login') }}" class="text-link">
                    {{ url('/login') }}
                </a>
            </div>
        </div>

        <div class="footer">
            <div class="brand-container">
                <img src="https://psohlavci.skauting.cz/cardfiles/card-psohlavci/img/thumbs/kormoran-kamen-web-1edf38721253620.svg"
                    alt="Kormorán" class="logo">
                <span class="brand-name">Kormorán</span>
            </div>
            <p style="margin-top: 16px;">© Kormorán {{ date('Y') }}. Všechna práva vyhrazena.</p>
        </div>
    </div>
</body>

</html>
