<article class="profile__post post post-text">
    <header class="post__header">
        <div class="post__author">
            <a class="post__author-link" href="#" title="Автор">
                <div class="post__avatar-wrapper post__avatar-wrapper--repost">
                    <img class="post__author-avatar" src="img/userpic-tanya.jpg" alt="Аватар пользователя">
                </div>
                <div class="post__info">
                    <b class="post__author-name">Репост: Таня Фирсова</b>
                    <time class="post__time" datetime="2019-03-30T14:31">25 минут назад</time>
                </div>
            </a>
        </div>
    </header>
    <div class="post__main">
        <h2>
            <a href="#">Полезный пост про Байкал</a>
        </h2>
        <p>
            Озеро Байкал – огромное древнее озеро в горах Сибири к северу от монгольской границы. Байкал считается самым глубоким озером в мире. Он окружен сетью пешеходных маршрутов, называемых Большой байкальской тропой. Деревня Листвянка, расположенная на западном берегу озера, – популярная отправная точка для летних экскурсий. Зимой здесь можно кататься на коньках и собачьих упряжках.
        </p>
        <a class="post-text__more-link" href="#">Читать далее</a>
    </div>
    <footer class="post__footer">
    <div class="post__indicators">
        <div class="post__buttons">
            <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                <svg class="post__indicator-icon" width="20" height="17">
                    <use xlink:href="#icon-heart"></use>
                </svg>
                <svg class="post__indicator-icon post__indicator-icon--like-active" width="20" height="17">
                    <use xlink:href="#icon-heart-active"></use>
                </svg>
                <span>250</span>
                <span class="visually-hidden">количество лайков</span>
            </a>
            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                <svg class="post__indicator-icon" width="19" height="17">
                    <use xlink:href="#icon-repost"></use>
                </svg>
                <span>5</span>
                <span class="visually-hidden">количество репостов</span>
            </a>
        </div>
        <time class="post__time" datetime="2019-01-30T23:41">15 минут назад</time>
    </div>
    <ul class="post__tags">
        <li><a href="#">#nature</a></li>
        <li><a href="#">#globe</a></li>
        <li><a href="#">#photooftheday</a></li>
        <li><a href="#">#canon</a></li>
        <li><a href="#">#landscape</a></li>
        <li><a href="#">#щикарныйвид</a></li>
    </ul>
    </footer>
    <div class="comments">
        <?= include_template('profile-post-commit.php', ['user_profile' => $user_profile,'post' => $post, 'is_show_comments' => $is_show_comments]); ?>
    </div>
    <form class="comments__form form" action="#" method="post">
        <div class="comments__my-avatar">
            <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
        </div>
        <textarea class="comments__textarea form__textarea" placeholder="Ваш комментарий"></textarea>
        <label class="visually-hidden">Ваш комментарий</label>
        <button class="comments__submit button button--green" type="submit">Отправить</button>
    </form>
</article>
