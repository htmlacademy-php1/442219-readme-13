<main class="page__main page__main--publication">
    <div class="container">
        <h1 class="page__title page__title--publication"><?= htmlspecialchars($post['title']); ?></h1>
        <section class="post-details">
            <h2 class="visually-hidden">Публикация</h2>
            <div class="post-details__wrapper post-text">

                <div class="post-details__main-block post post--details">
                    <?php
                        print(include_template('post-' . $post['alias'] . '.php', [
                            'post' => $post,
                        ]));
                    ?>
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
                            <a class="post__indicator post__indicator--comments button" href="#" title="Комментарии">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-comment"></use>
                                </svg>
                                <span><?= count($comments); ?></span>
                                <span class="visually-hidden">количество комментариев</span>
                            </a>
                            <a class="post__indicator post__indicator--repost button" href="#" title="Репост">
                                <svg class="post__indicator-icon" width="19" height="17">
                                    <use xlink:href="#icon-repost"></use>
                                </svg>
                                <span>5</span>
                                <span class="visually-hidden">количество репостов</span>
                            </a>
                        </div>
                        <span class="post__view"><?= $post['view_counter']; ?> <?= get_noun_plural_form($post['view_counter'], 'просмотр', 'просмотра', 'просмотров'); ?></span>
                    </div>
                    <ul class="post__tags">
                        <li><a href="#">#nature</a></li>
                        <li><a href="#">#globe</a></li>
                        <li><a href="#">#photooftheday</a></li>
                        <li><a href="#">#canon</a></li>
                        <li><a href="#">#landscape</a></li>
                        <li><a href="#">#щикарныйвид</a></li>
                    </ul>
                    <div class="comments">
                        <form class="comments__form form" action="comments.php" method="post">
                            <div class="comments__my-avatar">
                                <img class="comments__picture" src="img/userpic-medium.jpg" alt="Аватар пользователя">
                            </div>
                            <div class="form__input-section"><!-- form__input-section--error -->
                                <textarea class="comments__textarea form__textarea form__input" name="comment" placeholder="Ваш комментарий"></textarea>
                                <label class="visually-hidden">Ваш комментарий</label>
                                <button class="form__error-button button" type="button">!</button>
                                <div class="form__error-text">
                                    <h3 class="form__error-title">Ошибка валидации</h3>
                                    <p class="form__error-desc">Это поле обязательно к заполнению</p>
                                </div>
                            </div>
                            <input class="visually-hidden" type="text" name="post-id" value="<?= $post['post_id']; ?>">
                            <button class="comments__submit button button--green" type="submit">Отправить</button>
                        </form>
                        <div class="comments__list-wrapper">
                            <?php if (!empty($comments)) : ?>
                            <?= include_template('profile-post-comments.php', ['comments' => $comments]); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!--  -->
                <div class="post-details__user user">
                    <div class="post-details__user-info user__info">
                        <div class="post-details__avatar user__avatar">
                            <a class="post-details__avatar-link user__avatar-link" href="#">
                                <img class="post-details__picture user__picture" src="<?= htmlspecialchars($post['avatar_url']); ?>" alt="Аватар пользователя">
                            </a>
                        </div>
                        <div class="post-details__name-wrapper user__name-wrapper">
                            <a class="post-details__name user__name" href="profile.php?user_id=<?= $post['id_user']; ?>">
                            <span><?= htmlspecialchars($post['author']); ?></span>
                            </a>
                            <time class="post-details__time user__time" datetime="2014-03-20"><?= get_diff_time_public_post($post['registered_at']); ?></time>
                        </div>
                    </div>
                    <div class="post-details__rating user__rating">
                        <p class="post-details__rating-item user__rating-item user__rating-item--subscribers">
                            <span class="post-details__rating-amount user__rating-amount"><?= $subscribers['count_sub']; ?></span>
                            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($subscribers['count_sub'], 'подписчик', 'подписчика', 'подписчиков'); ?></span>
                        </p>
                        <p class="post-details__rating-item user__rating-item user__rating-item--publications">
                            <span class="post-details__rating-amount user__rating-amount"><?= $posting['count_posts']; ?></span>
                            <span class="post-details__rating-text user__rating-text"><?= get_noun_plural_form($posting['count_posts'], 'публикация', 'публикации', 'публикаций'); ?></span>
                        </p>
                    </div>
                    <div class="post-details__user-buttons user__buttons">
                        <button class="user__button user__button--subscription button button--main" type="button">Подписаться</button>
                        <a class="user__button user__button--writing button button--green" href="#">Сообщение</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
