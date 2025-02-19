<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="assets/favicon.ico" type="image/x-icon">
    <title>RickAndMortyApi</title>
</head>
    
<body>
    <?php if ($characters):?>
    <div class="container">
        <div style="margin-bottom: 10px;">
            <?php require_once 'views/navbar.tpl.php' ?>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover">
                    <thead class="table-dark">
                        <tr>
                            <!-- <th scope="col">#</th> -->
                            <th scope="col">Миниатюра</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Вид</th>
                            <th scope="col">Пол</th>
                            <th scope="col">Локация</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($characters as $character): ?>
                            <tr">
                                <td class=""><img src="<?= $character['image'] ?>" alt="" style="width: 55px;"></td>
                                <td class=""><a href="<?= $character['character_id']?>"><?= $character['character_name'] ?></a></td>
                                <!-- <td class=""><?= $character['character_name'] ?></td> -->
                                <td class=""><?= $character['character_status'] ?></td>
                                <td class=""><?= $character['species'] ?></td>
                                <td class=""><?= $character['gender'] ?></td>
                                <td class=""><?= $character['location_name'] ?></td>

                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?= $pagination ?>
        </div>

    </div>
    <?php endif; ?>

    <?php require_once 'views/footer.tpl.php' ?>
</body>

</html>


<!-- <td class=""><a href="<?= $character['character_id']?>"><?= $character['character_name'] ?></a></td> -->