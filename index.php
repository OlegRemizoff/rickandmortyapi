<?php 
error_reporting(E_ALL);

require_once './classes/Db.php';
require_once './classes/Pagination.php';
require_once 'functions.php';
$config = require_once 'config.php';


// Подключение к БД
$db = Db::getInstance()->getConnection($config['db']);


$uri = trim($_SERVER['REQUEST_URI']);
$id = getId();


// Получение id для передачи в функцию show
function getId() {
    global $uri;
    $params = explode('?', $uri);
    $arr = explode('/', $params[0]);
    $id = (int)$arr[1];
    return $id;
}

// Отображение всех персонажей
function index() {
    global $db;
    global $config;

    $page = $_GET['page'] ?? 1;
    $total = $db->query("SELECT COUNT('character_id') AS count FROM characters")->findColumn();
    $pagination = new Pagination((int)$page, $config['per_page'], $total);
    $start = $pagination->get_start();

    $characters = $db->query(
        "SELECT image,
        character_id,
        character_name,
        character_status,
        species, gender,
        location_name
        FROM
            characters
        LEFT JOIN
            locations ON characters.location_id = locations.location_id
        LIMIT {$start}, {$config['per_page']}")->findAll();


    require_once "views/index.tpl.php";


}

// Отображение информации о персонаже
function show($id) {
    global $db;

    $character = $db->query(
        "SELECT
            image,
            character_name,
            character_status,
            species, gender,character_type,
            location_name,
            location_url,
            character_name,
            episodes.episode_name
        FROM 
            characters
        LEFT JOIN
            locations ON characters.location_id = locations.location_id
        JOIN
            character_episode ON characters.character_id = character_episode.character_id
        JOIN
            episodes ON character_episode.episode_id = episodes.episode_id
        WHERE characters.character_id = $id")->find();

    $episodes = $db->query(
        "SELECT
        image,
        episodes.episode_id, 
        episodes.episode_name,
        episode,
        episode_created,
        episodes.episode_url 
        FROM 
            characters
        JOIN
            character_episode ON characters.character_id = character_episode.character_id
        JOIN
            episodes  ON character_episode.episode_id = episodes.episode_id
        WHERE characters.character_id = $id")->findAll();

    require_once "views/show.tpl.php";
}


// Формирование excel для персонажей
function getCharacterExcel() {
    global $db;
    
    $characters_all = $db->query(
        "SELECT 
            characters.character_name,
            characters.character_status,
            characters.species,
            characters.gender,
            locations.location_name,
            locations.location_url,
            GROUP_CONCAT(episodes.episode ORDER BY episodes.episode_id SEPARATOR ', ') AS episodes
        FROM
            characters
        LEFT JOIN
            locations ON characters.location_id = locations.location_id
        JOIN
            character_episode ON characters.character_id = character_episode.character_id
        JOIN
            episodes ON character_episode.episode_id = episodes.episode_id
        GROUP BY
            characters.character_id,
            characters.character_name,
            characters.character_status,
            characters.species,
            characters.gender,
            locations.location_name,
            locations.location_url;")->findAll();

    $fp = fopen('characters_all.csv', 'w');
    $headers = [
        'Имя персонажа',
        'Статус',
        'Вид',
        'Пол',
        'Локация',
        'URL локации',
        'Эпизоды'
    ];
    fputcsv($fp, $headers, ',', '"', '');

    foreach ($characters_all as $character) {
        $fields = [
            $character['character_name'],
            $character['character_status'],
            $character['species'],
            $character['gender'],
            $character['location_name'],
            $character['location_url'],
            $character['episodes']
        ];
        fputcsv($fp, $fields, ',', '"', '');
    }
    
    fclose($fp);
}
if (!file_exists('characters_all.csv')) {
    getCharacterExcel();
}




if ($uri === '') {
    index();
} elseif (!empty($id)) {
    show($id);
} else {
    index();
}



/*Заполнение БД
****************************************** */

// Получение всех персонажей
function getAllCharacters() {
    // Колличество страниц
    $get_pages_count = json_decode(file_get_contents('https://rickandmortyapi.com/api/character'), true);
    $pages = $get_pages_count['info']['pages'];

    // Сюда будем добавлять персонажей 
    $all_characters = [];

    // Запускаем цикл с изменением страниц, 
    for ($page = 1; $page <= $pages; $page++) {
        $url = "https://rickandmortyapi.com/api/character?page=$page";
        $json = file_get_contents($url);
        $data = json_decode($json, true);
    
        if (isset($data['results'])) {
            $all_characters = array_merge($all_characters, $data['results']);
        }
    }

    return $all_characters;
}

// Получение всех локаций
function getAllLacation() {
    // Колличество страниц
    $get_pages_count = json_decode(file_get_contents('https://rickandmortyapi.com/api/location'), true);
    $pages = $get_pages_count['info']['pages'];

    $location = [];

    for ($page = 1; $page <= $pages; $page++) {
        $url = "https://rickandmortyapi.com/api/location?page=$page";
        $json = file_get_contents($url);
        $data = json_decode($json, true);
    
        if (isset($data['results'])) {
            $location = array_merge($location, $data['results']);
        }    
    }
    return $location;
}

// Получение всех эпизодов
function getAllEpisodes() {
    // Колличество страниц
    $get_pages_count = json_decode(file_get_contents('https://rickandmortyapi.com/api/episode'), true);
    $pages = $get_pages_count['info']['pages'];

    $episodes = [];

    for ($page = 1; $page <= $pages; $page++) {
        $url = "https://rickandmortyapi.com/api/episode?page=$page";
        $json = file_get_contents($url);
        $data = json_decode($json, true);
    
        if (isset($data['results'])) {
            $episodes = array_merge($episodes, $data['results']);
        }    
    }

    return $episodes;
}

// Втавка персонажей
function insertCharacters($characters) {
    // Подключение к базе данных
    $mysqli = new mysqli('localhost', 'root', '', 'rickandmorty');
    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }
    // Подготовка запроса на вставку данных
    $stmt = $mysqli->prepare("INSERT INTO characters (character_id, character_name, character_status, species, character_type, gender, image, character_url, characters_created) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssss", $id, $name, $status, $species, $type, $gender, $image, $url, $created);

    foreach ($characters as $character) {
        // Получаем данные из каждого персонажа
        $id = $character['id'];
        $name = $character['name'];
        $status = $character['status'];
        $species = $character['species'];
        $type = isset($character['type']) ? $character['type'] : '';
        $gender = $character['gender'];
        $image = $character['image'];
        $url = $character['url'];
        $created = $character['created'];

        // Выполняем запрос на вставку
        $stmt->execute();
    }
    // Закрытие подключения
    $stmt->close();
    $mysqli->close();
}

// Втавка локаций
function insertLocations($locations) {
    // Подключение к базе данных
    $mysqli = new mysqli('localhost', 'root', '', 'rickandmorty');
    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }
    // Подготовка запроса на вставку данных
    $stmt = $mysqli->prepare("INSERT INTO locations (location_id, location_name, location_type, dimension, location_url, location_created) 
                              VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id, $name, $type, $dimension, $url, $created);

    foreach ($locations as $location) {
        // Получаем данные о каждом эпизоде
        $id = $location['id'];
        $name = $location['name'];
        $type = $location['type'];
        $dimension = $location['dimension']; 
        $url = $location['url'];
        $created = $location['created'];


        // Выполняем запрос на вставку
        $stmt->execute();
    }
    // Закрытие подключения
    $stmt->close();
    $mysqli->close();
}

// Втавка эпизодов
function insertEpisodes($episodes) {
    // Подключение к базе данных
    $mysqli = new mysqli('localhost', 'root', '', 'rickandmorty');
    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }
    // Подготовка запроса на вставку данных
    $stmt = $mysqli->prepare("INSERT INTO episodes (episode_id, episode_name, air_date, episode, episode_url, episode_created) 
                              VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id, $name, $air_date, $episode_code, $url, $created);

    foreach ($episodes as $episode) {
        // Получаем данные о каждом эпизоде
        $id = $episode['id'];
        $name = $episode['name'];
        $air_date = $episode['air_date'];
        $episode_code = $episode['episode']; 
        $url = $episode['url'];
        $created = $episode['created'];


        // Выполняем запрос на вставку
        $stmt->execute();
    }
    // Закрытие подключения
    $stmt->close();
    $mysqli->close();
}


// Создание many-to-many персонажа и его эпизодов
function relationshipCharacterEpisode ($characters) {

    // Подключение к базе данных
    $mysqli = new mysqli('localhost', 'root', '', 'rickandmorty');
    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }
    // Подготовка данных для вставки
    $stmt = $mysqli->prepare("INSERT INTO character_episode (character_id, episode_id) VALUES (?, ?)");
    if (!$stmt) {
        die('Ошибка подготовки запроса: ' . $mysqli->error);
    }

    // Привязка параметров
    $stmt->bind_param("ii", $character_id, $episode_id);

    try {
        // Этот цикл будет проходить по каждому персонажу
        foreach ($characters as $character) {
            $character_id = $character['id'];

        // Тут проходимся по массиву episode: [0] => https://rickandmortyapi.com/api/episode/6, 
        // и заберем id каждого. Затем преобразуем в строку и добавим в БД.
            foreach ($character['episode'] as $ch) {
                // $character =  https://rickandmortyapi.com/api/episode/1
                $tmp = (explode('/', $ch));
                $episode_id = (int)end($tmp);
                $stmt->execute();
            }
        }
    


    } finally {
        $stmt->close();
        $mysqli->close();
    }

}

// One-to-many локации и персонажа
function updateLocationCharacter($characters) {
    // Подключение к базе данных
    $mysqli = new mysqli('localhost', 'root', '', 'rickandmorty');
    if ($mysqli->connect_error) {
        die('Ошибка подключения: ' . $mysqli->connect_error);
    }

    // Подготовка запроса для обновления location_id
    $stmt = $mysqli->prepare("UPDATE characters SET location_id = ? WHERE character_id = ?");
    if (!$stmt) {
        die('Ошибка подготовки запроса: ' . $mysqli->error);
    }

    // Привязка параметров
    $stmt->bind_param("ii", $location_id, $character_id);

    try {
        foreach ($characters as $character) {

            if (empty($character['location']['url'])) {
                echo "Пропуск персонажа: URL локации отсутствует.\n";
                continue;
            }

            // $character['location']['url']): https://rickandmortyapi.com/api/location/3
            $tmp = explode('/', $character['location']['url']);
            $location_id = (int)end($tmp);

            // Устанавливаем character_id
            $character_id = $character['id'];

            // Выполняем запрос на обновление
            if (!$stmt->execute()) {
                echo "Ошибка при обновлении персонажа ID $character_id: " . $stmt->error . "\n";
            }
        }
    } finally {
        // Закрытие ресурсов
        $stmt->close();
        $mysqli->close();
    }

}



// $characters = getAllCharacters();
// $locations = getAllLacation();
// $episodes = getAllEpisodes();


// insertCharacters($characters);
// insertLocations($locations);
// insertEpisodes($episodes);


// relationshipCharacterEpisode($characters);
// updateLocationCharacter($characters);


// echo 'success';
