<article class="search__post post post-link">
    <header class="post__header post__author">
        <a class="post__author-link" href="#" title="Автор">
            <div class="post__avatar-wrapper">
                <img class="post__author-avatar" src="<?= $post['avatar_url']; ?>" alt="Аватар пользователя">
            </div>
            <div class="post__info">
                <b class="post__author-name"><?= $post['author'] ?></b>
                <span class="post__time">Месяц назад</span>
            </div>
        </a>
    </header>
    <div class="post__main">
        <div class="post-link__wrapper">
            <a class="post-link__external" href="<?= $post['site_url']; ?>" title="Перейти по ссылке">
                <div class="post-link__icon-wrapper">
                    <img src="img/logo-vita.jpg" alt="Иконка">
                </div>
                <div class="post-link__info">
                    <h3><?= $post['title']; ?></h3>
                    <span><?= $post['site_url']; ?></span>
                </div>
                <svg class="post-link__arrow" width="11" height="16">
                    <use xlink:href="#icon-arrow-right-ad"></use>
                </svg>
            </a>
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
