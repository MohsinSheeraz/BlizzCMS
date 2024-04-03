<section class="uk-section uk-padding-remove bc-slider-section">
    <div class="uk-position-relative uk-visible-toggle" uk-slideshow="animation: fade; autoplay: true; autoplay-interval: 10000; pause-on-hover: true; min-height: 125; max-height: 250">
        <ul class="uk-slideshow-items">
            <?php foreach (model('Slide')->findAll() as $slide) : ?>
                <?php if ($slide->type === SLIDE_IMAGE) : ?>
                    <li>
                        <img src="<?= $template['uploads'] . $slide->path ?>" alt="<?= $slide->title ?>" uk-cover>
                        <div class="uk-container uk-position-relative uk-margin-large-top">
                            <h2 class="uk-h2 uk-position-medium uk-text-left uk-margin-remove"><?= $slide->title ?></h2>
                            <p class="uk-position-medium uk-text-left uk-margin-remove"><?= $slide->description ?></p>
                        </div>
                    </li>
                <?php elseif ($slide->type === SLIDE_VIDEO) : ?>
                    <li>
                        <video src="<?= $template['uploads'] . $slide->path ?>" autoplay loop playslinline uk-cover></video>
                        <div class="uk-container uk-position-relative uk-margin-large-top">
                            <h2 class="uk-h2 uk-position-medium uk-text-left uk-margin-remove"><?= $slide->title ?></h2>
                            <p class="uk-position-medium uk-text-left uk-margin-remove"><?= $slide->description ?></p>
                        </div>
                    </li>
                <?php elseif ($slide->type === SLIDE_IFRAME) : ?>
                    <li>
                        <iframe src="<?= $slide->path ?>" allowfullscreen uk-video="autoplay: false" uk-cover></iframe>
                    </li>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
        <div class="uk-position-bottom-center uk-position-small">
            <ul class="uk-slideshow-nav uk-dotnav"></ul>
        </div>
    </div>
</section>

<section class="uk-section uk-section-xsmall bc-default-section" uk-height-viewport="expand: true">
    <div class="uk-container">
        <div class="uk-margin" uk-grid>
            <div class="uk-width-3-5@s uk-width-2-3@m">
                <h3 class="uk-h4 uk-text-bold uk-margin-small"><?= lang("General.latest_news") ?></h3>
                <div class="uk-grid-medium uk-child-width-1-1" uk-grid>
                    <?php if (!empty($articles) && is_array($articles)) : ?>
                        <?php foreach ($articles as $article) : ?>
                            <div>
                                <div class="uk-card uk-card-default uk-card-hover uk-grid-collapse" uk-grid>
                                    <div class="uk-width-1-3@s uk-card-media-left uk-cover-container">
                                        <img src="<?= $template['uploads'] . $article->image ?>" alt="<?= $article->title ?>" uk-cover>
                                        <canvas width="500" height="250"></canvas>
                                    </div>
                                    <div class="uk-width-2-3@s">
                                        <div class="uk-card-body">
                                            <h4 class="uk-h4 uk-text-bold uk-margin-remove">
                                                <a class="uk-link-reset" href="<?= site_url('news/' . $article->id . '/' . $article->slug) ?>"><?= word_limiter($article->title, 12) ?></a>
                                            </h4>
                                            <p class="uk-text-meta uk-margin-remove-top uk-margin-small-bottom">
                                                <i class="fa-solid fa-calendar-day"></i> <time datetime="<?= $article->created_at ?>"><?= localeDate($article->created_at) ?></time>
                                            </p>
                                            <p class="uk-text-small uk-margin-small"><?= esc($article->summary) ?></p>
                                            <div class="uk-grid-small uk-flex uk-flex-middle uk-margin-top" uk-grid>
                                                <div class="uk-width-expand uk-text-meta">
                                                    <span class="uk-margin-small-right" uk-tooltip="<?= lang('comments') ?>"><i class="fa-solid fa-comment"></i> <?= $article->comments ?></span> <span uk-tooltip="<?= lang('views') ?>"><i class="fa-solid fa-eye"></i> <?= $article->views ?></span>
                                                </div>
                                                <div class="uk-width-auto">
                                                    <a href="<?= site_url('news/' . $article->id . '/' . $article->slug) ?>" class="uk-button uk-button-default uk-button-small"><?= lang('read_more') ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="uk-width-2-5@s uk-width-1-3@m">
                <div class="uk-card uk-card-default">
                    <div class="uk-card-header">
                        <h5 class="uk-h5 uk-text-bold uk-margin-remove"><?= lang("General.realm_status") ?></h5>
                    </div>
                    <div class="uk-card-body">
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-expand">
                                <h5 class="uk-h5 uk-text-bold uk-margin-small">Nombre del Reino</h5>
                            </div>
                            <div class="uk-width-auto">
                                <div class="bc-status-dot"></div>
                            </div>
                        </div>
                        <div class="bc-stacked-bars">
                            <div class="bc-progressbar bc-alliance-bar" style="width: 80%"></div>
                            <div class="bc-progressbar bc-horde-bar" style="width: 20%"></div>
                        </div>
                        <div class="bc-realmlist">
                            <i class="fa-solid fa-gamepad"></i> Realmlist : Test.realm.com
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>