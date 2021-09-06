<main class="page__main page__main--adding-post">
    <div class="page__main-section">
        <div class="container">
            <h1 class="page__title page__title--adding-post">Добавить публикацию</h1>
        </div>
        <div class="adding-post container">
            <div class="adding-post__tabs-wrapper tabs">
                <div class="adding-post__tabs filters">
                    <ul class="adding-post__tabs-list filters__list tabs__list">
                        <?php foreach ($types as $type) : ?>
                            <li class="adding-post__tabs-item filters__item">
                                <a class="adding-post__tabs-link filters__button filters__button--photo  tabs__item button <?= ($type['alias'] === $type_current) ? 'filters__button--active tabs__item--active' : ''; ?>" href="add.php">
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-photo"></use>
                                </svg>
                                <span><?= $type['title']; ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="adding-post__tab-content">
                    <section class="adding-post__photo tabs__content <?= ($type_current === 'photo') ? 'tabs__content--active' : ''; ?>">
                        <h2 class="visually-hidden">Форма добавления фото</h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['heading']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="photo-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= (!empty($new_post['heading'])) ? $new_post['heading'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('add-photo.php', ['errors'=> $errors, 'new_post' => $new_post]); ?>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="photo-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtags']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="photo-tags" type="text" name="hashtags" placeholder="Введите теги" value="<?= (!empty($new_post['hashtags'])) ? $new_post['hashtags'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['hashtags']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($errors) : ?>
                                    <?= include_template('add-errors-block.php', ['errors'=> $errors]); ?>
                                <?php endif; ?>
                            </div>
                            <?= include_template('add-photo-file.php'); ?>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="index.php">Закрыть</a>
                            </div>
                        </form>
                    </section>

                    <section class="adding-post__video tabs__content <?= ($type_current === 'video') ? 'tabs__content--active' : ''; ?>">
                        <h2 class="visually-hidden">Форма добавления видео</h2>
                        <form class="adding-post__form form" action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['heading']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="video-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= (!empty($new_post['heading'])) ? $new_post['heading'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <?= include_template('add-video.php', ['errors'=> $errors, 'new_post' => $new_post]); ?>
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="video-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtags']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="video-tags" type="text" name="hashtags" placeholder="Введите теги" value="<?= (!empty($new_post['hashtags'])) ? $new_post['hashtags'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['hashtags']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($errors) : ?>
                                    <?= include_template('add-errors-block.php', ['errors'=> $errors]); ?>
                                <?php endif; ?>
                            </div>

                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="index.php">Закрыть</a>
                            </div>
                        </form>
                    </section>

                    <section class="adding-post__text tabs__content <?= ($type_current === 'text') ? 'tabs__content--active' : ''; ?>">
                        <h2 class="visually-hidden">Форма добавления текста</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="text-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['heading']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="text-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= (!empty($new_post['heading'])) ? $new_post['heading'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading']; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <?= include_template('add-text.php', ['errors'=> $errors, 'new_post' => $new_post]); ?>

                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="post-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtags']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="post-tags" type="text" name="hashtags" placeholder="Введите теги" value="<?= (!empty($new_post['hashtags'])) ? $new_post['hashtags'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                            <h3 class="form__error-title">Заголовок сообщения</h3>
                                            <p class="form__error-desc"><?= $errors['hashtags']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($errors) : ?>
                                    <?= include_template('add-errors-block.php', ['errors'=> $errors]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="index.php">Закрыть</a>
                            </div>
                        </form>
                    </section>

                    <section class="adding-post__quote tabs__content <?= ($type_current === 'quote') ? 'tabs__content--active' : ''; ?>">
                        <h2 class="visually-hidden">Форма добавления цитаты</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="quote-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['heading']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="quote-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= (!empty($new_post['heading'])) ? $new_post['heading'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading']; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <?= include_template('add-quote.php', ['errors'=> $errors, 'new_post' => $new_post]); ?>

                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                    <label class="adding-post__label form__label" for="cite-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtags']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="cite-tags" type="text" name="hashtags" placeholder="Введите теги" value="<?= (!empty($new_post['hashtags'])) ? $new_post['hashtags'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['hashtags']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($errors) : ?>
                                    <?= include_template('add-errors-block.php', ['errors'=> $errors]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="index.php">Закрыть</a>
                            </div>
                        </form>
                    </section>

                    <section class="adding-post__link tabs__content <?= ($type_current === 'link') ? 'tabs__content--active' : ''; ?>">
                        <h2 class="visually-hidden">Форма добавления ссылки</h2>
                        <form class="adding-post__form form" action="add.php" method="post">
                            <div class="form__text-inputs-wrapper">
                                <div class="form__text-inputs">
                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="link-heading">Заголовок <span class="form__input-required">*</span></label>
                                        <div class="form__input-section <?= isset($errors['heading']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="link-heading" type="text" name="heading" placeholder="Введите заголовок" value="<?= (!empty($new_post['heading'])) ? $new_post['heading'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['heading']; ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <?= include_template('add-link.php', ['errors'=> $errors, 'new_post' => $new_post]); ?>

                                    <div class="adding-post__input-wrapper form__input-wrapper">
                                        <label class="adding-post__label form__label" for="link-tags">Теги</label>
                                        <div class="form__input-section <?= isset($errors['hashtags']) ? 'form__input-section--error' : ''; ?>">
                                            <input class="adding-post__input form__input" id="link-tags" type="link-tags" name="hashtags" placeholder="Введите теги" value="<?= (!empty($new_post['hashtags'])) ? $new_post['hashtags'] : ''; ?>">
                                            <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
                                            <div class="form__error-text">
                                                <h3 class="form__error-title">Заголовок сообщения</h3>
                                                <p class="form__error-desc"><?= $errors['hashtags']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($errors) : ?>
                                    <?= include_template('add-errors-block.php', ['errors'=> $errors]); ?>
                                <?php endif; ?>
                            </div>
                            <div class="adding-post__buttons">
                                <button class="adding-post__submit button button--main" type="submit">Опубликовать</button>
                                <a class="adding-post__close" href="index.php">Закрыть</a>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>
