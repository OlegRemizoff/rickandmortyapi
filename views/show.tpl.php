<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Информация о персонаже</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div style="margin-bottom: 10px;">
            <?php require_once 'views/navbar.tpl.php' ?>
        </div>
        <div class="row">
            <div class="col-md-4">
                <!-- Карточка персонажа -->
                <div class="card">
                    <img src="<?= $character['image'] ?>" class="card-img-top" alt="Фото персонажа">
                    <div class="card-body">
                        <h5 class="card-title"><?= $character['character_name'] ?></h5>
                        <p class="card-text"><a href="<?php $character_url; ?>"></a></p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Статуc:</strong> <?= $character['character_status'] ?></li>
                        <li class="list-group-item"><strong>Пол:</strong> <?= $character['gender'] ?></li>
                        <li class="list-group-item"><strong>Вид:</strong> <?= $character['species'] ?></li>
                        <li class="list-group-item"><strong>Тип:</strong> <?php echo $character['character_type'] ?? '' ?></li>
                        <li class="list-group-item"><strong>Локация: </strong><?= $character['location_name'] ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Список эпизодов:</h5>
                        <p class="card-text">
                            <!-- ... -->
                        </p>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Имя</th>
                                            <th scope="col">Серия</th>
                                            <th scope="col">Дата</th>
                                            <th scope="col">URL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($episodes as $episode): ?>
                                            <tr">
                                                <td class=""><?=  $episode['episode_name'] ?></td>
                                                <td class=""><?=  $episode['episode'] ?></td>
                                                <td class=""><?=  $episode['episode_created'] ?></td>
                                                <td class=""><a href="<?= $episode['episode_url']?>"><?= $episode['episode_url']?></a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                                    
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'views/footer.tpl.php' ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>