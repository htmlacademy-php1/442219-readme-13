-- DELETE FROM types;

INSERT INTO types (title, class)
VALUES
  ('Текст', 'post-text'),
  ('Цитата', 'post-quote'),
  ('Картинка', 'post-photo'),
  ('Видео', 'post-video'),
  ('Ссылка', 'post-link');

INSERT INTO users (registered_at, email, user_name, user_password, avatar_url)
VALUES
  (NOW(), 'mark@mail.ru', 'Максим', 'maksimpassword', 'userpic.jpg'),
  (NOW(), 'anna@mail.ru', 'Анна', 'annapassword', 'userpic-larisa-small.jpg');

INSERT INTO posts (created_at, title, text_content, author_quote, img_url, video_url, site_url, view_counter, user_id, type_id)
VALUES
  (NOW(), 'Цитата', 'Мы в жизни любим только раз, а после ищем лишь похожих', NULL, NULL, NULL, NULL, NULL, 1, 2),
  (NOW(), 'Игра престолов', 'Не могу дождаться, начала финального сезона своего любимого сериала!', NULL, NULL, NULL, NULL, NULL, 2, 1),
  (NOW(), 'Наконец, обработал фотки!', NULL, NULL, 'rock-medium.jpg', NULL, NULL, NULL, 1, 3),
  (NOW(), 'Моя мечта', NULL, NULL, 'coast-medium.jpg', NULL, NULL, NULL, 2, 3),
  (NOW(), 'Лучшие курсы', NULL, NULL, NULL, NULL, 'www.htmlacademy.ru', NULL, 1, 5);

INSERT INTO comments (created_at, content, author_id, post_id)
VALUES
  (NOW(), 'Текст комментария второго поста', 2, 2),
  (NOW(), 'Текст комментария первого поста', 1, 3);
