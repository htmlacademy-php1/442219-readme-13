-- DELETE FROM types;

INSERT INTO types (title, class)
VALUES
  ('Текст', 'text'),
  ('Цитата', 'quote'),
  ('Картинка', 'photo'),
  ('Видео', 'video'),
  ('Ссылка', 'link');

INSERT INTO users (registered_at, email, user_name, user_password, avatar_url)
VALUES
  (NOW(), 'larisa@mail.ru', 'Лариса', 'larisapassword', 'userpic-larisa-small.jpg'),
  (NOW(), 'vlad99@mail.ru', 'Владик', 'vlad99password', 'userpic.jpg'),
  (NOW(), 'victory@mail.ru', 'Виктор', 'victorypassword', 'userpic-mark.jpg'),
  (NOW(), 'mark@mail.ru', 'Максим', 'maksimpassword', 'userpic.jpg'),
  (NOW(), 'anna@mail.ru', 'Анна', 'annapassword', 'userpic-larisa-small.jpg');

INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
VALUES
  (NOW(), 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', 'Неизвестный', NULL, NULL, NULL, 2, 1, 2),
  (NOW(), 'Игра престолов', 'Не могу дождаться, начала финального сезона своего любимого сериала!', NULL, NULL, NULL, NULL, 10, 2, 1),
  (NOW(), 'Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, 18, 3, 3),
  (NOW(), 'Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, 34, 1, 3),
  (NOW(), 'Лучшие курсы', NULL, NULL, NULL, NULL, 'www.htmlacademy.ru', 55, 2, 5),
  (NOW(), 'Лучший подкаст', NULL, NULL, NULL, 'https://www.youtube.com/channel/UCY35dlJe-V5J_IqzU-XksAg', NULL, 8, 4, 4),
  (NOW(), 'Доклад интрига', NULL, NULL, NULL, 'https://www.youtube.com/watch?v=nIFClfBXuIQ&list=RDCMUCTUyoZMfksbNIHfWJjwr5aQ&index=2', NULL, 12, 5, 4);

INSERT INTO comments (created_at, content, author_id, post_id)
VALUES
  (NOW(), 'Потрясающий доклад, оставил глубокое впечатление.', 2, 7),
  (NOW(), 'Фотки класс!', 5, 3),
  (NOW(), 'Фотки класс! Впечатлил...', 1, 3);

INSERT INTO likes (user_id, post_id)
VALUES
  (1, 1),
  (2, 2),
  (3, 3),
  (4, 4),
  (5, 5),
  (1, 2),
  (2, 3),
  (3, 4),
  (4, 4),
  (5, 6),
  (1, 3),
  (2, 4),
  (3, 5),
  (4, 6),
  (5, 7),
  (4, 7),
  (3, 7),
  (2, 7),
  (1, 7);

-- получить список постов с сортировкой по популярности и вместе с именами авторов и типом контента:
SELECT COUNT(p.id) like_count, p.title, user_name AS author, t.title AS type_content
  FROM posts p
  JOIN  users u ON p.user_id = u.id
  JOIN types t ON p.type_id = t.id
  JOIN likes l ON p.id = l.post_id
  GROUP BY p.id ORDER BY COUNT(p.id) DESC;

-- получить список постов для конкретного пользователя:
SELECT user_name, p.title post_title
  FROM posts p
  JOIN users u ON u.id = p.user_id
  WHERE user_name = 'Анна';

-- получить список комментариев для одного поста, в комментариях должен быть логин пользователя:
SELECT p.title post, com.content comment, u.user_name FROM comments com
  JOIN posts p ON p.id = com.post_id
  JOIN users u ON com.author_id = u.id
  WHERE com.post_id = 3;

-- добавить лайк к посту:
INSERT INTO likes SET user_id = 2, post_id = 5;

-- подписаться на пользователя:
INSERT INTO subscriptions SET author_id = 1, subscriber_id = 5;
