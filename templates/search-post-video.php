<article class="search__post post post-video">
    <header class="post__header post__author">
        <a class="post__author-link" href="#" title="Автор">
            <div class="post__avatar-wrapper">
                <img class="post__author-avatar" src="<?= $post['avatar_url']; ?>" alt="Аватар пользователя">
            </div>
            <div class="post__info">
                <b class="post__author-name"><?= $post['author']; ?></b>
                <span class="post__time">5 часов назад</span>
            </div>
        </a>
    </header>
    <div class="post__main">
        <div class="post-video__block">
            <div class="post-video__preview">
                <?= embed_youtube_video($post['video_url']); ?>
            </div>
        </div>
    </div>
    <footer class="post__footer post__indicators">
        <div class="post__buttons">
            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                    <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                    <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span><?= $post['likes'] ?? '0'; ?></span>
                <span class="visually-hidden">количество лайков</span>
            </a>
            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                <svg class="post__indicator-icon" width="19" height="17">
                    <use xlink:href="#icon-comment"></use>
                </svg>
                <span>25</span>
                <span class="visually-hidden">количество комментариев</span>
            </a>
        </div>
    </footer>
</article>
