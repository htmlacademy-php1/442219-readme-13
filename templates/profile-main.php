<main class="page__main page__main--profile">
    <h1 class="visually-hidden">Профиль</h1>
    <div class="profile profile--default">
        <div class="profile__user-wrapper">
            <div class="profile__user user container">
            <div class="profile__user-info user__info">
                <div class="profile__avatar user__avatar">
                    <img class="profile__picture user__picture" src="<?= $user_profile['avatar_url'] ?? 'img/avatar-default.png'; ?>" alt="Аватар пользователя">
                </div>
                <div class="profile__name-wrapper user__name-wrapper">
                    <span class="profile__name user__name"><?= $user_profile['user_name']; ?></span>
                    <time class="profile__user-time user__time" datetime="2014-03-20">5 лет на сайте</time>
                </div>
            </div>
            <div class="profile__rating user__rating">
                <p class="profile__rating-item user__rating-item user__rating-item--publications">
                    <span class="user__rating-amount"><?= $user_publications ?? '0'; ?></span>
                    <span class="profile__rating-text user__rating-text">публикаций</span>
                </p>
                <p class="profile__rating-item user__rating-item user__rating-item--subscribers">
                    <span class="user__rating-amount"><?= $user_subscribe ?? '0'; ?></span>
                    <span class="profile__rating-text user__rating-text">подписчиков</span>
                </p>
            </div>
            <div class="profile__user-buttons user__buttons">
                <?php if ($is_not_you && $is_subscribe) : ?>
                    <a class="profile__user-button user__button user__button--subscription button button--main"  href="subscrube.php?user_id=<?= $user_profile['id']; ?>">Отписаться</a>
                    <a class="profile__user-button user__button user__button--writing button button--green" href="#">Сообщение</a>
                <?php elseif ($is_not_you) : ?>
                    <a class="profile__user-button user__button user__button--subscription button button--main" href="subscrube.php?user_id=<?= $user_profile['id']; ?>">Подписаться</a>
                <?php endif; ?>
            </div>
            </div>
        </div>
        <div class="profile__tabs-wrapper tabs">
            <div class="container">
                <div class="profile__tabs filters">
                    <b class="profile__tabs-caption filters__caption">Показать:</b>
                    <ul class="profile__tabs-list filters__list tabs__list">
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button filters__button--active tabs__item tabs__item--active button">Посты</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="#">Лайки</a>
                        </li>
                        <li class="profile__tabs-item filters__item">
                            <a class="profile__tabs-link filters__button tabs__item button" href="#">Подписки</a>
                        </li>
                    </ul>
                </div>
                <div class="profile__tab-content">
                <!-- ПОСТЫ -->
                    <section class="profile__posts tabs__content tabs__content--active">
                        <h2 class="visually-hidden">Публикации</h2>
                        <?php foreach ($user_posts as $post) : ?>
                            <?= include_template('profile-post-' . $post['alias'] . '.php', ['user_profile' => $user_profile,'post' => $post, 'is_show_comments' => $is_show_comments]); ?>
                        <?php endforeach; ?>
                    </section>
                <!-- ЛАЙКИ -->
                    <?= include_template('profile-likes.php', ['user_profile' => $user_profile,'post' => $post]); ?>
                <!-- ПОДПИСКИ -->
                    <?= include_template('profile-subscribers.php', ['user_profile' => $user_profile,'post' => $post]); ?>
                </div>
            </div>
        </div>
    </div>
</main>
