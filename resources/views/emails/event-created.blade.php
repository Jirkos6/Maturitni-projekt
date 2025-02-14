<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nová Akce Vytvořena</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(to bottom, #f0f4f8, #d9e6f1);
        }

        .header {
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .header p {
            margin-top: 5px;
            font-size: 1rem;
            opacity: 0.9;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, #d9e6f1, transparent);
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="max-w-2xl mx-auto mt-10 bg-white shadow-lg rounded-lg overflow-hidden">
        <!-- Header -->
        <div class="header">
            <h1>Nová Akce Vytvořena!</h1>
        </div>

        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">
                Vážená Paní, Vážený Pane
            </h2>
            <p class="mt-4 text-gray-600">
                Přidali jsme Vašeho syna/dceru k nové akci. Níže naleznete detaily:
            </p>

            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mt-4">
                <p class="text-gray-800">
                    <span class="font-semibold">Název akce:</span> <span class="font-bold">{{ $title }}</span>
                </p>
                <p class="mt-2 text-gray-800">
                    <span class="font-semibold">Popis akce:</span> {{ $description }}
                </p>
                <p class="mt-2 text-gray-800">
                    <span class="font-semibold">Datum a čas:</span>
                    {{ \Carbon\Carbon::parse($start)->format('d. m. Y H:i') }} -
                    {{ \Carbon\Carbon::parse($end)->format('d. m. Y H:i') }}
                </p>

            </div>

            <div class="divider"></div>

            <p class="mt-4 text-gray-700">
                Těšíme se na Vaši účast. Pokud máte nějaké dotazy, neváhejte nás kontaktovat.
            </p>

            <div class="mt-6">
                <a href="{{ url('/dashboard') }}">
                    <button class="button">
                        Zobrazit Detaily Akce
                    </button>
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Nebo klikněte na níže uvedený odkaz:</p>
                <a href="{{ url('/dashboard') }}" class="text-blue-600 font-semibold hover:underline">
                    Klikněte zde pro zobrazení akce
                </a>
            </div>
        </div>
        <footer class="bg-gray-50 border-t border-gray-200 text-center p-4 text-gray-500 text-sm">
            Copyright © Skaut @php echo date("Y"); @endphp
        </footer>
    </div>
</body>

</html>
