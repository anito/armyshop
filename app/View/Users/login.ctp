<div style="" id="login">
  <div id="messenger" class="dialogue-wrap">
    <div class="dialogue">
      <?php echo $this->Form->create('User', array('onsubmit' => 'Login.submit(); return false;')); ?>
      <div class="dialogue-content" style="width:525px; min-width:500px;">
        <div class="bg">
          <header>
            <fieldset class="right">
            </fieldset>
          </header>
          <div class="dialogue-inner-wrap">
            <div class="drag-handle">
              <h4 class="flash">HA-Lehmann Admin</h4>
              <span class="h2" style="line-height: 4rem;">Login</span>
              <div class="clearfix"></div>
            </div>
            <div class="dialogue-scroll">
              <fieldset>
                <div class="left">
                  <label>Benutzer</label>
                  <?php echo $this->Form->input('username', array('label' => false, 'div' => false, 'autofocus' => 'autofocus')); ?>
                </div>
                <div class="left">
                  <label>Passwort</label>
                  <?php echo $this->Form->input('password', array('label' => false, 'div' => false)); ?>
                </div>
              </fieldset>
            </div>
          </div>
          <footer>
            <span class="info"><label>keine Statusmeldungen</label></span
            <span>
              <fieldset>
                <?php echo $this->Form->hidden('redirect', array('value' => $redirect)); ?>
                <?php echo $this->Form->button('Gast', array('type'=>'button', 'class' => array('light', 'hide', 'guest'), 'id' => 'guestLogin')); ?>
                <?php echo $this->Form->button('Abbrechen', array('type'=>'submit', 'class' => 'light', 'id' => 'cancel')); ?>
                <?php echo $this->Form->button('<i class="glyphicon glyphicon-log-in"></i><span>  Login</span>', array('type'=>'submit', 'class' => 'light', 'label' => array(
                 TRUE
                ))); ?>
              </fieldset>
            </span>
          </footer>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>
<div id="loader" class="view" style="opacity: 1">
  <div class="dialogue-wrap">
    <div class="dialogue">
      <div class="dialogue-content">
        <div class="" style="line-height: 1.5em; font-size:1.5em; text-align: center; color: #E1EEF7">
          <div class="status-symbol" style="z-index: 2;">
            <img src="/img/ajax-loader.gif" style="">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/x-jquery-tmpl" id="flashTemplate">
  {{if flash}}
  {{html flash}}
  {{if success}}
  <img src="/img/ajax-loader-light.gif">
  {{/if}}
  {{/if}}
  {{if error}}
  <h3>Sorry... {{if xhr.status==403}}Your session seems to be over{{else}}Something went wrong{{/if}}</h3>
  {{/if}}
</script>

<script type="text/x-jquery-tmpl" id="infoTemplate">
  {{if record}}
  <span style="display: block;">Server action failed!</span>
  {{/if}}
</script>
<!--{json: {flash: ...}} {error: {record: {}, xhr: {}, statusText: {}, error:{}}}-->
