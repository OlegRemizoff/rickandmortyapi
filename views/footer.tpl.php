<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Простой футер прижат к низу</title>
    <!-- Подключаем Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        html, body {
            height: 100%; /* Занимаем всю высоту экрана */
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Растягиваем контент, чтобы футер был внизу */
            padding: 20px 0;
        }
        footer {
            background-color: #343a40;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>
<body>
    <!-- Основной контент -->
    <main class="container">
        <!-- <h1 class="text-center">Основной контент страницы</h1>
        <p class="text-center">Это пример страницы с футером, прижатым к низу.</p> -->
    </main>

    <!-- Футер -->
    <footer class="bg-dark text-white">
        <div class="container">
            <p class="mb-0">&copy; 2025 Copyright</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>