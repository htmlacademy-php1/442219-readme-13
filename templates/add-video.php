<div class="adding-post__input-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="video-url">Ссылка youtube <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= isset($errors['video-url']) ? 'form__input-section--error' : ''; ?>">
        <input class="adding-post__input form__input" id="video-url" type="text" name="video-url" placeholder="Введите ссылку" value="<?= (!empty($new_post['video-url'])) ? htmlspecialchars($new_post['video-url']) : ''; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['video-url']; ?></p>
        </div>
        <input class="visually-hidden" type="text" name="type-alias" value="video">
    </div>
</div>
