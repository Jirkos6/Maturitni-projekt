<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nová Akce Vytvořena</title>
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
            padding: 28px 24px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
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
            padding: 30px 25px;
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

        .event-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-left: 4px solid #0284c7;
            border-radius: 10px;
            padding: 22px;
            margin: 25px 0;
        }

        .event-item {
            margin-bottom: 14px;
        }

        .event-item:last-child {
            margin-bottom: 0;
        }

        .event-label {
            font-weight: 600;
            color: #0369a1;
            display: block;
            margin-bottom: 4px;
        }

        .event-value {
            font-weight: 500;
            color: #0f172a;
        }

        .event-title {
            font-size: 17px;
            font-weight: 700;
            color: #0f172a;
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

        .footer {
            background-color: #f1f5f9;
            border-top: 1px solid #e2e8f0;
            padding: 20px;
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .brand-container {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 12px;
        }

        .logo {
            height: 30px;
            width: auto;
            margin-right: 8px;
        }

        .calendar-icon {
            background-color: #dbeafe;
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px auto;
            border: 2px solid #bfdbfe;
            color: #1e40af;
            font-weight: bold;
        }

        .calendar-month {
            font-size: 12px;
            text-transform: uppercase;
            margin-bottom: -4px;
        }

        .calendar-day {
            font-size: 22px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Nová akce v družině!</h1>
            <p>Informace o nové akci</p>
        </div>

        <div class="content">
            <h2 class="greeting">
                Vážená Paní, Vážený Pane
            </h2>

            <p class="message">
                K družině byla přiřazena nová akce. Níže naleznete detaily. Nezapomeňte potvrdit účast dítěte v sekci
                Potvrzení účasti.
            </p>

            <div class="event-box">
                <div class="event-item">
                    <span class="event-label">Název akce:</span>
                    <span class="event-title">{{ $title }}</span>
                </div>
                @if ($description)
                    <div class="event-item">
                        <span class="event-label">Popis akce:</span>
                        <span class="event-value">{{ $description }}</span>
                    </div>
                @endif
                <div class="event-item">
                    <span class="event-label">Datum a čas:</span>
                    <span class="event-value">
                        {{ \Carbon\Carbon::parse($start)->format('d.m.Y H:i') }} -
                        {{ \Carbon\Carbon::parse($end)->format('d.m.Y H:i') }}
                    </span>
                </div>
            </div>

            <div class="divider"></div>

            <div class="btn-container">
                <a href="{{ url('/dashboard') }}" class="btn-primary">
                    Zobrazit detaily akce
                </a>
            </div>

            <div class="text-center">
                <p>Nebo použijte tento odkaz:</p>
                <a href="{{ url('/dashboard') }}" class="text-link">
                    {{ url('/dashboard') }}
                </a>
            </div>
        </div>

        <div class="footer">
            <p>Všechny akce můžete sledovat ve vašem profilu po přihlášení</p>
            <p style="margin-top: 12px;">Copyright © Kormorán {{ date('Y') }}. Všechna práva vyhrazena.</p>
        </div>
    </div>
</body>

</html>
