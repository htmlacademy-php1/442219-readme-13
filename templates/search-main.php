<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
            <span>Вы искали:</span>
            <span class="search__query-text"><?= !empty($query) ? $query : 'Вы не ввели запрос поиска'; ?></span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <?php if (empty($posts_search)) : ?>
            <?= include_template('search-no-result.php', ['link_ref' => $link_ref]); ?>
            <?php else : ?>
            <div class="container">
                <div class="search__content">
                    <?php foreach ($posts_search as $post) : ?>
                        <?= include_template('search-post-' . $post['alias'] . '.php', ['post' => $post]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>
