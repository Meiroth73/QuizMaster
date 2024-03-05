-- MySQL Script generated by MySQL Workbench
-- Mon Jan 29 18:48:03 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

DROP DATABASE IF EXISTS `quizmaster` ;

CREATE DATABASE IF NOT EXISTS `quizmaster` DEFAULT CHARACTER SET utf8;
USE `quizmaster`;

DROP TABLE IF EXISTS `quizmaster`.`user` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64) NOT NULL,
  `lastname` VARCHAR(64) NOT NULL,
  `username` VARCHAR(64) NOT NULL,
  `email` VARCHAR(64) NOT NULL,
  `password` VARCHAR(128) NOT NULL,
  `description` TEXT NULL,
  `phonenumber` VARCHAR(15) NULL,
  `createdate` DATETIME NOT NULL,
  `profileimage` INT NULL,
  `lastlogin` DATETIME NOT NULL,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `quizmaster`.`reviews` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`reviews` (
  `id` INT NOT NULL AUTO_INCREMENT, 
  `user_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `rate` FLOAT NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES user(`id`));

DROP TABLE IF EXISTS `quizmaster`.`question` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`question` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `topic_id` INT NOT NULL,
  `title` TEXT NOT NULL,
  `option1` TEXT NOT NULL,
  `option2` TEXT NOT NULL,
  `option3` TEXT NOT NULL,
  `option4` TEXT NOT NULL,
  `correct` VARCHAR(1) NOT NULL,
  `lastmodifydate` DATETIME NOT NULL,
  `lastmodifyadmin` INT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES category(`id`),
  FOREIGN KEY (`topic_id`) REFERENCES topic(`id`));

DROP TABLE IF EXISTS `quizmaster`.`admin`;

CREATE TABLE IF NOT EXISTS `quizmaster`.`admin` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `login` VARCHAR(64) NOT NULL,
  `password` VARCHAR(64) NOT NULL,
  `lastlogin` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES user(`id`));

DROP TABLE IF EXISTS `quizmaster`.`admin_log`;

CREATE TABLE IF NOT EXISTS `quizmaster`.`admin_log` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `admin_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `action` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`admin_id`) REFERENCES admin(`id`));

DROP TABLE IF EXISTS `quizmaster`.`category` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`category` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `iconclass`VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id`));

DROP TABLE IF EXISTS `quizmaster`.`topic`;

CREATE TABLE IF NOT EXISTS `quizmaster`.`topic` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `category_id` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`category_id`) REFERENCES category(`id`));

DROP TABLE IF EXISTS `quizmaster`.`report` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`report` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES user(`id`));

DROP TABLE IF EXISTS `quizmaster`.`solved` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`solved` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `duration` INT NOT NULL,
  `numberofquestions` INT NOT NULL,
  `score` FLOAT NOT NULL,
  `questions_ids` TEXT NOT NULL,
  `answers` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES user(`id`));

DROP TABLE IF EXISTS `quizmaster`.`announcements` ;

CREATE TABLE IF NOT EXISTS `quizmaster`.`announcements` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posted_by` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `announcementimage` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`posted_by`) REFERENCES user(`id`));

CREATE TABLE IF NOT EXISTS `quizmaster`.`opinion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `date` DATETIME NOT NULL,
  `rate` SMALLINT NOT NULL,
  `description` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`user_id`) REFERENCES user(`id`));

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

INSERT INTO `quizmaster`.`category` (`title`, `image`, `iconclass`) VALUES ('Informatyka', 'cjnMxkDEFtTJQi3E8WKVZ1Le9tCqIFdA.jpg', 'fa-microchip'),('Matematyka', '16149867_16149864.jpg', 'fa-square-root-variable'),('Historia', '17b1b-historia.jpg', 'fa-hourglass-half'),('Ekonomia', 'Kierunek-ekonomia-baner.png', 'fa-hand-holding-dollar'),('Geografia', '138963.jpg', 'fa-volcano'),('Psychologia', 'hero-psychology-in-education-1600.png', 'fa-people-group'),('Chemia', '17uk9kpTURBXy81ODAwNzhmODJmMmJiMDU5MzMyZjExOGY2MmFlMzI1Ni5qcGeSlQMAzLTNFoDNDKiTBc0EsM0Chd4AAaEwAQ.jpeg', 'fa-atom'),('Fizyka', 'istockphoto-936903524-612x612.jpg', 'fa-lightbulb'),('Sport', 'Sporten.jpg', 'fa-volleyball'),('Polityka', 'politica-1-.jpg', 'fa-handshake'),('Religia', '43fd856d4218f2-948-568-0-170-4000-2399.jpg', 'fa-person-praying'),('Astronomia', 'astronomia-dla-poczatkujacych.jpg', 'fa-moon'),('Muzyka', 'Wykryto-ze-muzyka-wplywa-na-dzialanie-mozgu.-Moze-zapobiec-jednej-chorobie_article.png', 'fa-guitar'),('Świat - Wiedza Ogólna', 'taj-mahal-3132348_1280.jpg', 'fa-stroopwafel'), ('Wszystko', 'XTzneAFXsTJLyfjGpCmzOoCMjz6441IZ.webp', 'fa-instalod');

INSERT INTO `quizmaster`.`topic` (`category_id`, `title`) VALUES
   (1, 'Sztuczna Inteligencja'), (1, 'Programowanie'), (1, 'Sieci Komputerowe'),
   (1, 'Cyberbezpieczeństwo'), (1, 'Bazy Danych'), (1, 'Algorytmy'),
   (1, 'Internet Rzeczy'), (1, 'Linux'), (1, 'Historia Komputerów'),
   (1, 'Historia Internetu i Jego Wpływ na Społeczeństwo'),
   (2, 'Algebra'), (2, 'Geometria'), (2, 'Statystyka'),
   (2, 'Teoria Liczb'), (2, 'Geometria Analityczna'),
   (2, 'Równania Różniczkowe'), (2, 'Logika Matematyczna'),
   (2, 'Funkcje'), (2, 'Matematyka w Codziennym Życiu'),
   (2, 'Historia Matematyki i Znani Matematycy'),
   (2, 'Okres Renesansu i Jego Wpływ na Europę'),
   (3, 'Druga Wojna Światowa'), (3, 'Pierwsza Wojna Światowa'),
   (3, 'Wojna Secesyjna'), (3, 'Królowie Polski'),
   (3, 'Czasy PRL'), (3, 'Średniowiecze'),
   (3, 'Starożytność'), (3, 'Historia Polski'),
   (3, 'Historia Chin'), (3, 'Historia Stanów Zjednoczonych'),
   (3, 'Historia Ameryki Łacińskiej'), (3, 'Najważniejsze Wydarzenia XX Wieku'),
   (4, 'Mikroekonomia'), (4, 'Makroekonomia'),
   (4, 'Finanse Publiczne'), (4, 'Rynki Finansowe'),
   (4, 'Zarządzanie Strategiczne'), (4, 'Ekonomia Rozwoju'),
   (4, 'Handel Międzynarodowy i Globalizacja'),
   (4, 'Innowacje i Przedsiębiorczość'),
   (4, 'Przedsiębiorstwa Społeczne'), (4, 'Finanse Osobiste'),
   (4, 'Zrównoważony Rozwój'), (4, 'Globalne Trendy w Handlu'),
   (4, 'Etyka w Biznesie'),
   (5, 'Kraje Europy'), (5, 'Geografia Fizyczna'),
   (5, 'Geografia Społeczno-Ekonomiczna'), (5, 'Zmiany Klimatu'),
   (5, 'Podróże'), (5, 'Kultury Świata'),
   (5, 'Geopolityka'), (5, 'Kształtowanie się Terenu'),
   (5, 'Najnowsze Odkrycia Geograficzne'),
   (5, 'Wpływ Kolorów na Ludzkie Emocje'),
   (6, 'Psychologia Kliniczna'), (6, 'Psychologia Społeczna'),
   (6, 'Rozwój Osobowości'), (6, 'Neuropsychologia'),
   (6, 'Psychologia Sportu'), (6, 'Psychoterapia'),
   (6, 'Zaburzenia Psychiczne'), (6, 'Psychologia Edukacyjna'),
   (7, 'Chemia Organiczna'), (7, 'Chemia Nieorganiczna'),
   (7, 'Chemia Analityczna'), (7, 'Chemia Fizyczna'),
   (7, 'Biochemia'), (7, 'Chemia Środowiskowa'),
   (7, 'Chemia Medyczna'), (7, 'Technologia Chemiczna'),
   (8, 'Mechanika'), (8, 'Termodynamika'),
   (8, 'Fizyka Jądrowa'), (8, 'Elektromagnetyzm'),
   (8, 'Astrofizyka'), (8, 'Fizyka Cząstek Elementarnych'),
   (8, 'Fizyka Statystyczna'), (8, 'Optyka'),
   (8, 'Drgania'),
   (9, 'Piłka Nożna'), (9, 'Koszykówka'),
   (9, 'Siatkówka'), (9, 'Biegi'),
   (9, 'Sporty Ekstremalne'), (9, 'Golf'),
   (9, 'Hokej na Lodzie'), (9, 'Najpopularniejsi Sportowcy'),
   (10, 'Systemy Polityczne'), (10, 'Polityka Międzynarodowa'),
   (10, 'Historia Polityczna'), (10, 'Polityka Społeczna'),
   (10, 'Demokracja'), (10, 'Totalitaryzm'),
   (10, 'Konflikty Globalne'),
   (11, 'Chrześcijaństwo'), (11, 'Islam'),
   (11, 'Buddyzm'), (11, 'Judaizm'),
   (11, 'Hinduizm'), (11, 'Sikhizm'),
   (11, 'Religie Starożytne'), (11, 'Ateizm'),
   (12, 'Planety Układu Słonecznego'), (12, 'Gwiazdy'),
   (12, 'Kosmiczne Odkrycia'), (12, 'Czarne Dziury'),
   (12, 'Historia Astronomii'), (12, 'Teleskopy Kosmiczne'),
   (12, 'Eksploracja Kosmosu'), (12, 'Życie Pozaziemskie'),
   (13, 'Historia Muzyki'), (13, 'Gatunki Muzyczne'),
   (13, 'Kompozytorzy'), (13, 'Instrumenty Muzyczne'),
   (13, 'Muzyka Klasyczna'), (13, 'Muzyka Rockowa'),
   (13, 'Muzyka Elektroniczna'), (13, 'Popularni Artyści'),
   (14, 'Ciekawostki Geograficzne'), (14, 'Zwierzęta Świata'),
   (14, 'Najwyższe Budowle Świata'), (14, 'Największe Jeziora'),
   (14, 'Najgłębsze Rowy Oceaniczne'),
   (14, 'Najbardziej Niezwykłe Miejsca na Ziemi'),
   (14, 'Najlepsze Plaże Świata'), (14, 'Najnowsze Odkrycia Naukowe'),
   (14, 'Historia Gatunków Muzycznych'),
   (14, 'Znani Kompozytorzy i Ich Dzieła'),
   (14, 'Historia Wynalazków i Odkryć');

INSERT INTO `quizmaster`.`user` (`name`, `lastname`, `username`, `email`, `password`, `description`, `phonenumber`, `createdate`, `profileimage`, `lastlogin`) VALUES
    ('Emily', 'Davis', 'root', 'root@example.com', 'hashed_password_4', 'Graphic designer', '+1122334455', '2024-01-30 12:45:00', 1, '2024-01-30 13:15:00'),
    ('Daniel', 'Moore', 'daniel_moore', 'daniel.moore@example.com', 'hashed_password_5', 'Marketing specialist', '+9988776655', '2024-01-30 13:00:00', 2, '2024-01-30 13:30:00'),
    ('Alice', 'Brown', 'alice_brown', 'alia.brown@example.com', 'hashed_password_6', 'UX/UI designer', NULL, '2024-01-30 13:15:00', 3, '2024-01-30 14:00:00'),
    ('Michael', 'Johnson', 'michael_johnson', 'michael.johnson@example.com', 'hashed_password_7', 'IT consultant', '+1122337788', '2024-01-30 13:30:00', 4, '2024-01-30 14:15:00'),
    ('Olivia', 'Anderson', 'olivia_anderson', 'olivia.anderson@example.com', 'hashed_password_8', 'Content writer', NULL, '2024-01-30 13:45:00', 5, '2024-01-30 14:30:00'),
    ('Ethan', 'Taylor', 'ethan_taylor', 'ethan.taylor@example.com', 'hashed_password_9', 'Software developer', '+1122339900', '2024-01-30 14:00:00', 6, '2024-01-30 15:00:00'),
    ('Ava', 'White', 'ava_white', 'ava.white@example.com', 'hashed_password_10', 'Product manager', '+1122344555', '2024-01-30 14:15:00', 7, '2024-01-30 15:15:00');

INSERT INTO `quizmaster`.`admin` (`user_id`, `login`, `password`, `lastlogin`) VALUES
    (1, 'root', 'zaq1@WSX', '2024-01-30 12:30:00'),
    (3, 'admin_alice', 'adminer_pass42234', '2024-01-30 12:45:00'); 