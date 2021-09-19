<article class="popular__post post post-<?= $post['alias']; ?>">
    <header class="post__header">
        <h2><a href="post.php?post_id=<?= $post['post_id'] ?>"><?= htmlspecialchars($post['title']); ?></a></h2>
    </header>
    <div class="post__main">
        <?php if($post['alias'] === 'quote'): ?>
            <blockquote>
                <p>
                    <?= htmlspecialchars($post['text_content']);?>
                </p>
                <cite><?= $post['author_quote']; ?></cite>
            </blockquote>
        <?php elseif ($post['alias'] === 'text'): ?>
            <p>
                <?= cut_text(htmlspecialchars($post['text_content'])); ?>
            </p>
            <?php if (is_text_big($post['text_content'], MAX_LENGTH_TEXT)) : ?>
                <div class="post-text__more-link-wrapper">
                    <a class="post-text__more-link" href="#">Читать далее</a>
                </div>
            <?php endif; ?>
        <?php elseif ($post['alias'] === 'photo'): ?>
            <div class="post-photo__image-wrapper">
                <img src="<?= $post['img_url']; ?>" alt="Фото от пользователя" width="360" height="240">
            </div>
        <?php elseif ($post['alias'] === 'video'): ?>
            <div class="post-video__block">
                <div class="post-video__preview">
                    <?= embed_youtube_cover($post['video_url']); ?>
                </div>
                <a href="post-details.html" class="post-video__play-big button">
                    <svg class="post-video__play-big-icon" width="14" height="14">
                        <use xlink:href="#icon-video-play-big"></use>
                    </svg>
                    <span class="visually-hidden">Запустить проигрыватель</span>
                </a>
            </div>
        <?php elseif ($post['alias'] === 'link'): ?>
            <div class="post-link__wrapper">
                <a class="post-link__external" href="http://<?= $post['site_url']; ?>" title="Перейти по ссылке">
                    <div class="post-link__info-wrapper">
                        <div class="post-link__icon-wrapper">
                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                        </div>
                        <div class="post-link__info">
                            <h3><?= htmlspecialchars($post['title']); ?></h3>
                        </div>
                    </div>
                    <span><?= htmlspecialchars($post['site_url']); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="profile.php?user_id=<?= $post['user_id']; ?>" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="img/<?= $post['avatar_url']; ?>" alt="Аватар пользователя">
                </div>
                <!-- TODO Исправить дату -->
                <div class="post__info">
                    <b class="post__author-name"><?= htmlspecialchars($post['author']); ?></b>
                    <?php $public_date = generate_random_date($index); ?>
                    <time class="post__time" datetime="<?= $public_date ?>" title="<?= format_date($public_date, DATE_TITLE); ?>"><?= get_diff_time_public_post($public_date); ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="likes.php?post_id=<?= $post['post_id']; ?>" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span><?= $post['likes']; ?></span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
                <!-- TODO Добавить комментарии -->
                <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                    <svg class="post__indicator-icon" width="19" height="17">
                        <use xlink:href="#icon-comment"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество комментариев</span>
                </a>
            </div>
        </div>
    </footer>
</article>
