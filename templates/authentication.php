<main>
    <h1 class="visually-hidden">Главная страница сайта по созданию микроблога readme</h1>
    <div class="page__main-wrapper page__main-wrapper--intro container">
        <section class="intro">
            <h2 class="visually-hidden">Наши преимущества</h2>
            <b class="intro__slogan">Блог, каким<br> он должен быть</b>
            <ul class="intro__advantages-list">
                <li class="intro__advantage intro__advantage--ease">
                    <p class="intro__advantage-text">
                        Есть все необходимое для&nbsp;простоты публикации
                    </p>
                </li>
                <li class="intro__advantage intro__advantage--no-excess">
                    <p class="intro__advantage-text">
                        Нет ничего лишнего, отвлекающего от сути
                    </p>
                </li>
            </ul>
        </section>
        <section class="authorization">
            <h2 class="visually-hidden">Авторизация</h2>
            <form class="authorization__form form" action="#" method="post">
                <div class="authorization__input-wrapper form__input-wrapper">
                    <div class="form__input-section <?= isset($errors['email']) ? 'form__input-section--error' : ''; ?>">
                        <input class="authorization__input authorization__input--email form__input" type="email" name="email" placeholder="Email" value="<?= (!empty($aut_user['email'])) ? htmlspecialchars($aut_user['email']) : ''; ?>">
                        <svg class="form__input-icon" width="19" height="18">
                            <use xlink:href="#icon-input-user"></use>
                        </svg>
                        <label class="visually-hidden">Email</label>
                    </div>
                    <span class="form__error-label form__error-label--login"><?= $errors['email'] ?></span>
                </div>
                <div class="authorization__input-wrapper form__input-wrapper">
                    <div class="form__input-section <?= isset($errors['password']) ? 'form__input-section--error' : ''; ?>">
                        <input class="authorization__input authorization__input--password form__input" type="password" name="password" placeholder="Пароль" value="<?= (!empty($aut_user['password'])) ? htmlspecialchars($aut_user['password']) : ''; ?>">
                        <svg class="form__input-icon" width="16" height="20">
                            <use xlink:href="#icon-input-password"></use>
                        </svg>
                        <label class="visually-hidden">Пароль</label>
                    </div>
                    <span class="form__error-label"><?= $errors['password'] ?></span>
                </div>
                <a class="authorization__recovery" href="#">Восстановить пароль</a>
                <button class="authorization__submit button button--main" type="submit">Войти</button>
            </form>
        </section>
    </div>
</main>
