<div class="adding-post__input-wrapper form__textarea-wrapper">
    <label class="adding-post__label form__label" for="cite-text">Текст цитаты <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= isset($errors['quote-text']) ? 'form__input-section--error' : ''; ?>">
        <textarea class="adding-post__textarea adding-post__textarea--quote form__textarea form__input" id="cite-text" name="quote-text" placeholder="Текст цитаты"><?= (!empty($new_post['quote-text'])) ? $new_post['hashtags'] : ''; ?></textarea>
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['quote-text']; ?></p>
        </div>
    </div>
</div>
<div class="adding-post__textarea-wrapper form__input-wrapper">
    <label class="adding-post__label form__label" for="quote-author">Автор <span class="form__input-required">*</span></label>
    <div class="form__input-section <?= isset($errors['quote-author']) ? 'form__input-section--error' : ''; ?>">
        <input class="adding-post__input form__input" id="quote-author" type="text" name="quote-author" placeholder="Автор цитаты" value="<?= $new_post['quote-author']; ?>">
        <button class="form__error-button button" type="button">!<span class="visually-hidden">Информация об ошибке</span></button>
        <div class="form__error-text">
            <h3 class="form__error-title">Заголовок сообщения</h3>
            <p class="form__error-desc"><?= $errors['quote-author']; ?>.</p>
        </div>
        <input class="visually-hidden" type="text" name="type-alias" value="quote">
    </div>
</div>
