<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="popular.php?page=1&sort=popular">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="popular.php?page=1&sort=like">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="popular.php?page=1&sort=date">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?php if (!$type_id) : ?>filters__button--active<?php endif; ?>" href="popular.php?type_id=0&sort=popular">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($types as $type): ?>
                        <li class="popular__filters-item filters__item">
                            <a class="filters__button filters__button--<?= $type['alias'] ?> button <?php if ($type_id === $type['id']) : ?>filters__button--active<?php endif; ?>" href="popular.php?type_id=<?= $type['id']; ?>&sort=popular">
                                <span class="visually-hidden"><?= $type['title']; ?></span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $type['alias']; ?>"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $index => $post): ?>
                <?= include_template('popular-post.php', ['post' => $post]); ?>
            <?php endforeach; ?>
        </div>
        <?php if ($pages_count > 1) : ?>
        <div class="popular__page-links">
            <a class="popular__page-link popular__page-link--prev button button--gray" <?php if ($page_prev_url) : ?>href="<?= $page_prev_url; ?>"<?php endif; ?>>Предыдущая страница</a>
            <a class="popular__page-link popular__page-link--next button button--gray" <?php if ($page_next_url) : ?>href="<?= $page_next_url; ?>"<?php endif; ?>>Следующая страница</a>
        </div>
        <?php endif; ?>
    </div>
</section>
