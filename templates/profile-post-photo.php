<article class="profile__post post post-photo">
    <header class="post__header">
        <h2><a href="post.php?post_id=<?= $post['id']; ?>"><?= $post['title']; ?></a></h2>
    </header>
    <div class="post__main">
        <div class="post-photo__image-wrapper">
            <img src="<?= $post['image_url']; ?>" alt="Фото от пользователя" width="760" height="396">
        </div>
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
</article>
