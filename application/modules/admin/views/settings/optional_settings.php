    <section class="uk-section uk-section-xsmall" data-uk-height-viewport="expand: true">
      <div class="uk-container">
        <div class="uk-grid uk-grid-small uk-margin-small" data-uk-grid>
          <div class="uk-width-expand uk-heading-line">
            <h3 class="uk-h3"><i class="fas fa-sliders-h"></i> <?= lang('admin_nav_manage_settings'); ?></h3>
          </div>
          <div class="uk-width-auto">
            <a href="" class="uk-icon-button"><i class="fas fa-info"></i></a>
          </div>
        </div>
        <div class="uk-grid uk-grid-small" data-uk-grid>
          <div class="uk-width-1-4@s">
            <div class="uk-card uk-card-secondary">
              <ul class="uk-nav uk-nav-default">
                <li><a href="<?= site_url('admin/settings'); ?>"><i class="fas fa-cog"></i> <?= lang('section_general_settings'); ?></a></li>
                <li><a href="<?= site_url('admin/settings/module'); ?>"><i class="fas fa-puzzle-piece"></i> <?= lang('section_module_settings'); ?></a></li>
                <li class="uk-active"><a href="<?= site_url('admin/settings/optional'); ?>"><i class="fas fa-layer-group"></i> <?= lang('section_optional_settings'); ?></a></li>
                <li><a href="<?= site_url('admin/settings/seo'); ?>"><i class="fas fa-search"></i> <?= lang('section_seo_settings'); ?></a></li>
              </ul>
            </div>
          </div>
          <div class="uk-width-3-4@s">
            <div class="uk-card uk-card-default uk-margin-small">
              <div class="uk-card-body">
                <h5 class="uk-h5 uk-heading-line uk-text-uppercase uk-text-bold uk-text-center uk-margin-small"><span><?= lang('section_optional_settings'); ?></span></h5>
                <h5 class="uk-h5 uk-heading-bullet uk-text-uppercase uk-text-bold uk-margin-small">Ranks</h5>
                <?= form_open('', 'id="updateoptionalForm" onsubmit="UpdateOptionalForm(event)"'); ?>
                <div class="uk-margin-small">
                  <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_admin_gmlvl'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-crown"></i></span>
                          <input class="uk-input" type="text" id="admin_level" value="<?= config_item('admin_access_level'); ?>" required>
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_mod_gmlvl'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-gavel"></i></span>
                          <input class="uk-input" type="text" id="mod_level" value="<?= config_item('mod_access_level'); ?>" required>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <h5 class="uk-h5 uk-heading-bullet uk-text-uppercase uk-text-bold uk-margin-top uk-margin-small-bottom">reCaptcha</h5>
                <div class="uk-margin-small">
                  <label class="uk-form-label"><?= lang('conf_recaptcha_key'); ?></label>
                  <div class="uk-form-controls">
                    <div class="uk-inline uk-width-1-1">
                      <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-key"></i></span>
                      <input class="uk-input" type="text" id="recaptcha_key" value="<?= config_item('recaptcha_sitekey'); ?>">
                    </div>
                  </div>
                </div>
                <h5 class="uk-h5 uk-heading-bullet uk-text-uppercase uk-text-bold uk-margin-top uk-margin-small-bottom"><?= lang('tab_register'); ?></h5>
                <div class="uk-alert-danger uk-margin-small" uk-alert>
                  <p><i class="fas fa-exclamation-circle"></i> <?= lang('alert_smtp_activation'); ?></p>
                </div>
                <div class="uk-margin-small">
                  <label class="uk-form-label"><?= lang('conf_account_activation'); ?></label>
                  <div class="uk-form-controls">
                    <select class="uk-select" id="register_type">
                      <option value="TRUE" <?php if(config_item('account_activation_required') == TRUE) echo 'selected'; ?>><?= lang('option_enabled'); ?></option>
                      <option value="FALSE" <?php if(config_item('account_activation_required') == FALSE) echo 'selected'; ?>><?= lang('option_disabled'); ?></option>
                    </select>
                  </div>
                </div>
                <h5 class="uk-h5 uk-heading-bullet uk-text-uppercase uk-text-bold uk-margin-top uk-margin-small-bottom">SMTP</h5>
                <div class="uk-margin-small">
                  <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_smtp_hostname'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-mail-bulk"></i></span>
                          <input class="uk-input" type="text" id="smtp_hostname" value="<?= config_item('smtp_host'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-4@s">
                      <label class="uk-form-label"><?= lang('conf_smtp_port'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <input class="uk-input" type="number" id="smtp_port" value="<?= config_item('smtp_port'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-4@s">
                      <label class="uk-form-label"><?= lang('conf_smtp_encryption'); ?></label>
                      <div class="uk-form-controls">
                        <select class="uk-select" id="smtp_crypto">
                          <option value="ssl" <?php if(config_item('smtp_crypto') == 'ssl') echo 'selected'; ?>><?= lang('option_ssl'); ?></option>
                          <option value="tls" <?php if(config_item('smtp_crypto') == 'tls') echo 'selected'; ?>><?= lang('option_tls'); ?></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-margin-small">
                  <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_smtp_username'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-user"></i></span>
                          <input class="uk-input" type="text" id="smtp_username" value="<?= config_item('smtp_user'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_smtp_password'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-key"></i></span>
                          <input class="uk-input" type="password" id="smtp_password" value="<?= config_item('smtp_pass'); ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-margin-small">
                  <div class="uk-grid uk-grid-small" data-uk-grid>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_sender_email'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-envelope"></i></span>
                          <input class="uk-input" type="email" id="sender_email" value="<?= config_item('email_settings_sender'); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="uk-width-1-2@s">
                      <label class="uk-form-label"><?= lang('conf_sender_name'); ?></label>
                      <div class="uk-form-controls">
                        <div class="uk-inline uk-width-1-1">
                          <span class="uk-form-icon uk-form-icon-flip"><i class="fas fa-user-circle"></i></span>
                          <input class="uk-input" type="text" id="sender_name" value="<?= config_item('email_settings_sender_name'); ?>">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="uk-margin">
                  <button class="uk-button uk-button-primary uk-width-1-1" type="submit" id="button_optional"><i class="fas fa-sync"></i> <?= lang('button_update'); ?></button>
                </div>
                <?= form_close(); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <script>
      function UpdateOptionalForm(e) {
        e.preventDefault();

        var adminlvl = $.trim($('#admin_level').val());
        var modlvl = $.trim($('#mod_level').val());
        var recaptcha = $.trim($('#recaptcha_key').val());
        var register = $.trim($('#register_type').val());
        var smtphost = $.trim($('#smtp_hostname').val());
        var smtpport = $.trim($('#smtp_port').val());
        var smtpcrypto = $.trim($('#smtp_crypto').val());
        var smtpuser = $.trim($('#smtp_username').val());
        var smtppass = $.trim($('#smtp_password').val());
        var sender = $.trim($('#sender_email').val());
        var sendername = $.trim($('#sender_name').val());
        if(adminlvl == ''){
          $.amaran({
            'theme': 'awesome error',
            'content': {
              title: '<?= lang('notification_title_error'); ?>',
              message: '<?= lang('notification_title_empty'); ?>',
              info: '',
              icon: 'fas fa-times-circle'
            },
            'delay': 5000,
            'position': 'top right',
            'inEffect': 'slideRight',
            'outEffect': 'slideRight'
          });
          return false;
        }
        $.ajax({
          url:"<?= site_url('admin/settings/optional/update'); ?>",
          method:"POST",
          data:{adminlvl, modlvl, recaptcha, register, smtphost, smtpport, smtpcrypto, smtpuser, smtppass, sender, sendername},
          dataType:"text",
          beforeSend: function(){
            $.amaran({
              'theme': 'awesome info',
              'content': {
                title: '<?= lang('notification_title_info'); ?>',
                message: '<?= lang('notification_checking'); ?>',
                info: '',
                icon: 'fas fa-sign-in-alt'
              },
              'delay': 5000,
              'position': 'top right',
              'inEffect': 'slideRight',
              'outEffect': 'slideRight'
            });
          },
          success:function(response){
            if(!response)
              alert(response);

            if (response) {
              $.amaran({
                'theme': 'awesome ok',
                  'content': {
                  title: '<?= lang('notification_title_success'); ?>',
                  message: '<?= lang('notification_settings_updated'); ?>',
                  info: '',
                  icon: 'fas fa-check-circle'
                },
                'delay': 5000,
                'position': 'top right',
                'inEffect': 'slideRight',
                'outEffect': 'slideRight'
              });
            }
            $('#updateoptionalForm')[0].reset();
            window.location.replace("<?= site_url('admin/settings/optional'); ?>");
          }
        });
      }
    </script>
