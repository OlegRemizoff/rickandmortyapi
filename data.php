<?php
/**
 Тестовое задание.
1. Развернуть новый проект на laravel. База данных MySql.
2.  https://rickandmortyapi.com/documentation - работа с отрытым API
      Необходимо создать таблицы в БД, содержащие информацию о персонажах, существующих локациях и эпизодах
3. Прописать связи между таблицами. Между двумя таблицами использовать связь многие ко многим. С остальными связь по персонажу.
4. Реализовать сохранение данных из таблиц ДБ в Exel-документ через очереди и возможностью скачать этот документ. 
      Содержимое excel-файла: 
      Имя персонажа | Статус | Вид | Пол | Название локации | url локации | Эпизоды, в которых снимался
5. Реализовать в blade-шаблоне минимальный функционал для работы с данными: кнопка получить персонажей и вывести их количество, кнопка получить эпизоды и вывести их количество и кнопка сохранить документ и ссылка на скачивание документа. 
6. Проект выложить на GitHab
json_encode($array, JSON_UNESCAPED_UNICODE); для кириллицы
 */

// SQL
/** 
DROP TABLE IF EXISTS character_episode;
DROP TABLE IF EXISTS locations;
DROP TABLE IF EXISTS characters;
DROP TABLE IF EXISTS episodes;

CREATE TABLE characters (
    character_id INT PRIMARY KEY,
    character_name VARCHAR(255) NOT NULL,
    character_status VARCHAR(50) NOT NULL,
    species VARCHAR(100) NOT NULL,
    character_type VARCHAR(100),
    gender VARCHAR(50) NOT NULL,
    image VARCHAR(255),
    character_url VARCHAR(255) NOT NULL,
    characters_created VARCHAR(100) NOT NULL,
    location_id INT DEFAULT 0
);

CREATE TABLE locations (
    location_id INT PRIMARY KEY,
    location_name VARCHAR(255) NOT NULL,
    location_type VARCHAR(100) NOT NULL,
    dimension VARCHAR(100) NOT NULL,
    location_url VARCHAR(255) NOT NULL,
    location_created VARCHAR(100)
);

CREATE TABLE episodes (
    episode_id INT  PRIMARY KEY,
    episode_name VARCHAR(255) NOT NULL,
    air_date VARCHAR(100) NOT NULL,
    episode VARCHAR(100) NOT NULL,
	episode_url VARCHAR(255) NOT NULL,
    episode_created VARCHAR(100)
);

CREATE TABLE character_episode (
    character_id INT,
    episode_id INT,
    FOREIGN KEY (character_id) REFERENCES characters(character_id) ON DELETE CASCADE,
    FOREIGN KEY (episode_id) REFERENCES episodes(episode_id) ON DELETE CASCADE
);



*/
