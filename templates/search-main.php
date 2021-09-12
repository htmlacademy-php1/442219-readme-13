<main class="page__main page__main--search-results">
    <h1 class="visually-hidden">Страница результатов поиска</h1>
    <section class="search">
        <h2 class="visually-hidden">Результаты поиска</h2>
        <div class="search__query-wrapper">
            <div class="search__query container">
            <span>Вы искали:</span>
            <span class="search__query-text">#photooftheday</span>
            </div>
        </div>
        <div class="search__results-wrapper">
            <div class="container">
                <div class="search__content">
                    <?php foreach ($posts_search as $post) : ?>
                        <?= $post_tamplate_path = 'search-post-' . $post['type'] . '.php'; ?>
                        <?= include_template($post_tamplate_path, ['post' => $post]); ?>
                        <?= include_template('search-post-video.php', ['post' => $post]); ?>
                        <?= include_template('search-post-text.php', ['post' => $post]); ?>
                        <?= include_template('search-post-quote.php', ['post' => $post]); ?>
                        <?= include_template('search-post-link.php', ['post' => $post]); ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</main>
