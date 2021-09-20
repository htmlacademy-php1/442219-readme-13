<div class="adding-post__textarea-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="post-text">Текст поста <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= isset($errors['post-text']) ? 'form__input-section--error' : ''; ?>">
        <textarea class="adding-post__textarea form__textarea form__input" id="post-text" name="post-text" placeholder="Введите текст публикации" value="<?= (!empty($new_post['post-text'])) ? htmlspecialchars($new_post['post-text']) : ''; ?>"></textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['post-text']; ?></p>
        </div>
        <input class="visually-hidden" type="text" name="type-alias" value="text">
    </div>
</div>
