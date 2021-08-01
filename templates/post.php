<article class="popular__post post <?= $value['type']; ?>">
    <header class="post__header">
        <h2><?= htmlspecialchars($value['title']); ?></h2>
    </header>
    <div class="post__main">
        <?php if($value['type'] == 'post-quote'): ?>
            <blockquote>
                <p>
                    <?= htmlspecialchars($value['content']);?>
                </p>
                <cite>Неизвестный Автор</cite>
            </blockquote>
        <?php elseif ($value['type'] == 'post-text'): ?>
            <?php $arr_content = cut_text(htmlspecialchars($value['content'])) ?>
            <?php if ($arr_content[1]): ?>
                <p>
                    <?=$arr_content[0] . '...'; ?>
                </p>
                <a class="post-text__more-link" href="#">Читать далее</a>
                <?php else: ?>
                <p>
                    <?= htmlspecialchars($value['content']); ?>
                </p>
            <?php endif; ?>
        <?php elseif ($value['type'] == 'post-photo'): ?>
            <div class="post-photo__image-wrapper">
                <img src="img/<?= $value['content']; ?>" alt="Фото от пользователя" width="360" height="240">
            </div>
        <?php elseif ($value['type'] == 'post-video'): ?>
            <div class="post-video__block">
                <div class="post-video__preview">
                    <?= embed_youtube_cover($value['content']); ?>
                    <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                </div>
                <a href="post-details.html" class="post-video__play-big button">
                    <svg class="post-video__play-big-icon" width="14" height="14">
                        <use xlink:href="#icon-video-play-big"></use>
                    </svg>
                    <span class="visually-hidden">Запустить проигрыватель</span>
                </a>
            </div>
        <?php elseif ($value['type'] == 'post-link'): ?>
            <div class="post-link__wrapper">
                <a class="post-link__external" href="http://<?= $value['content']; ?>" title="Перейти по ссылке">
                    <div class="post-link__info-wrapper">
                        <div class="post-link__icon-wrapper">
                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                        </div>
                        <div class="post-link__info">
                            <h3><?= htmlspecialchars($value['title']); ?></h3>
                        </div>
                    </div>
                    <span><?= htmlspecialchars($value['content']); ?></span>
                </a>
            </div>
        <?php endif; ?>
    </div>
    <footer class="post__footer">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper">
                    <img class="post__author-avatar" src="img/<?= $value['avatar']; ?>" alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name"><?= htmlspecialchars($value['name']); ?></b>
                    <?php $public_date = get_date_public_posts($key); ?>
                    <time class="post__time" datetime="<?= $public_date ?>" title="<?= format_date($public_date, DATE_TITLE); ?>"><?= get_diff_time_public_post($public_date); ?></time>
                </div>
            </a>
        </div>
        <div class="post__indicators">
            <div class="post__buttons">
                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                    <svg class="post__indicator-icon" width="20" height="17">
                        <use xlink:href="#icon-heart"></use>
                    </svg>
                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                        <use xlink:href="#icon-heart-active"></use>
                    </svg>
                    <span>0</span>
                    <span class="visually-hidden">количество лайков</span>
                </a>
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
