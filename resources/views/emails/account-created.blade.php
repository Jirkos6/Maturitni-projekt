<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Účet vytvořen</title>
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
            <h1>Úspěšné vytvoření účtu!</h1>
            <p>Vaše přihlašovací údaje jsou níže</p>
        </div>

        <div class="p-6">
            <h2 class="text-xl font-bold text-gray-800">
                Vážená Paní, Vážený Pane {{ $name }} {{ $surname }}!
            </h2>
            <p class="mt-4 text-gray-600">
                Níže naleznete informace k přihlášení:
            </p>

            <div class="bg-gray-100 border border-gray-300 rounded-lg p-4 mt-4">
                <p class="text-gray-800">
                    <span class="font-semibold">Vaše heslo:</span> <span class="font-bold">{{ $password }}</span>
                </p>
                <p class="mt-2 text-gray-800">
                    <span class="font-semibold">Přihlášení:</span> Použijte svůj e-mail jako přihlašovací jméno.
                </p>
            </div>

            <div class="divider"></div>

            <p class="mt-4 text-gray-700">
                Po přihlášení si prosím změňte své heslo pro vyšší zabezpečení.
            </p>

            <div class="mt-6">
                <a href="{{ url('/login') }}">
                    <button class="button">
                        Přihlásit se
                    </button>
                </a>
            </div>

            <div class="mt-6 text-center">
                <p class="text-gray-600">Nebo klikněte na níže uvedený odkaz:</p>
                <a href="{{ url('/login') }}" class="text-blue-600 font-semibold hover:underline">
                    Klikněte zde pro přihlášení
                </a>
            </div>
        </div>
        <footer class="bg-gray-50 border-t border-gray-200 text-center p-4 text-gray-500 text-sm">
            Copyright © Skaut @php echo date("Y"); @endphp
        </footer>
    </div>
</body>

</html>
