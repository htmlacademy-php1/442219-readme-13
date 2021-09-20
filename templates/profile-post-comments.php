<ul class="comments__list">
    <?php foreach ($comments as $comment) : ?>
    <li class="comments__item user">
        <div class="comments__avatar">
        <a class="user__avatar-link" href="profile.php?user_id=<?= $comment['author_id']; ?>">
            <img class="comments__picture" src="<?= htmlspecialchars($comment['avatar_url']); ?>" alt="Аватар пользователя">
        </a>
        </div>
        <div class="comments__info">
        <div class="comments__name-wrapper">
            <a class="comments__user-name" href="profile.php?user_id=<?= $comment['author_id']; ?>">
            <span><?= htmlspecialchars($comment['user_name']); ?>
            <time class="comments__time" datetime="2019-03-20"><?= get_diff_time_public_post($comment['created_at']); ?></time>
        </div>
        <p class="comments__text">
            <?= htmlspecialchars($comment['content']); ?>
        </p>
        </div>
    </li>
    <?php endforeach; ?>
</ul>
