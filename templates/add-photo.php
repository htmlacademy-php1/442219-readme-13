<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="photo-url">Ссылка из интернета</label>
    <div class="form__input-section <?= isset($errors['photo-url']) ? 'form__input-section--error' : ''; ?>">
        <input class="adding-post__input form__input" id="photo-url" type="text" name="photo-url" placeholder="Введите ссылку" value="<?= $new_post['photo-url']; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['photo-url']; ?></p>
        </div>
        <input class="visually-hidden" type="text" name="type-alias" value="photo">
    </div>
</div>
