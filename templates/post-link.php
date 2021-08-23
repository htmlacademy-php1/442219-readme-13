<div class="post__main">
  <div class="post-link__wrapper">
    <a class="post-link__external" href="http://<?= $post['site_url']; ?>" title="Перейти по ссылке">
      <div class="post-link__info-wrapper">
        <div class="post-link__icon-wrapper">
          <img src="https://www.google.com/s2/favicons?domain=<?= $post['site_url']; ?>" alt="Иконка">
        </div>
        <div class="post-link__info">
          <h3><?= $post['site_url']; ?></h3>
        </div>
      </div>
    </a>
  </div>
</div>
