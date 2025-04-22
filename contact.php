<?php
  session_start();
  if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
  }
  
  $title="お問い合わせ｜青牡丹工務店 | 大阪市北区の住宅建築・リフォーム・公共事業なら青牡丹工務店";
  $description="大阪府大阪市に拠点をおく青牡丹工務店です。青牡丹工務店のサービスにご興味を持って頂き、誠にありがとうございます。下記のフォームよりお問い合わせください。";

  require_once('header.php'); ?>
<div class="pcHeaderSpacer">
  <div class="mainWrapper">
    <main class="contactPage">
      <div class="hero">
        <div class="hero__image hero__image--sizeShort">
        </div>
      </div>
      <section class="sectionContactForm">
        <div class="sectionInner">
          <div class="subPageLead">
            <h1 class="subPageLead__title">お問い合わせ</h1>
            <p class="subPageLead__text">
              青牡丹工務店のサービスにご興味を持って頂き、誠にありがとうございます。下記のフォームよりお問い合わせください。
            </p>
            <div class="subPageLead__img">
              <img src="images/contact/icon-contact.svg" alt="">
            </div>
          </div>
          <div class="beforeFormArea">
            <div class="beforeFormArea__stateboxes">
              <div class="beforeFormArea__statebox active">入力</div>
              <div class="beforeFormArea__statebox">送信完了</div>
            </div>
            <p class="beforeFormArea__telInfo">
              <span class="beforeFormArea__telText">お電話も受け付けています。</span>
              <a href="tel:0000-000-0000" class="beforeFormArea__telNumber">0000-000-0000</a>
              <span class="beforeFormArea__telHours">営業時間10:00-20:00</span>
            </p>
          </div>

          <?php
            if(isset($_SESSION['errors']) && !empty($_SESSION['errors'])):
              echo '<ul class="form-error-list" tabindex="-1">';
              foreach($_SESSION['errors'] as $error ):
          ?>
                    <li><?php echo $error; ?></li>
          <?php
              endforeach;
              echo '</ul>';

            endif;
          ?>

          <form action="process-contact.php" class="contactForm" method="POST">
            <fieldset class="contactForm__radioArea">
              <legend class="contactForm__fieldLabel">
                お問い合わせの種類
                <span class="contactForm__requiredText"><span class="red">★</span>必須</span>
              </legend>
              <label  class="contactForm__fieldLabel radio">
                <input type="radio" name="fld_inquiry" id="" class="contactForm__radio" value="注文住宅の相談" required <?= (!isset($_SESSION['fld_inquiry']) || $_SESSION['fld_inquiry'] == '注文住宅の相談') ?  'checked' : '' ?>>
                <span class="text">注文住宅の相談</span>
              </label>
              <label  class="contactForm__fieldLabel radio">
                <input type="radio" name="fld_inquiry" id="" class="contactForm__radio" value="法人建築の相談" <?= (isset($_SESSION['fld_inquiry']) && $_SESSION['fld_inquiry'] == '法人建築の相談') ? 'checked' : ''  ?>>
                <span class="text">法人建築の相談</span>
              </label>
              <label  class="contactForm__fieldLabel radio">
                <input type="radio" name="fld_inquiry" id="" class="contactForm__radio" value="リフォームの相談" <?= (isset($_SESSION['fld_inquiry']) && $_SESSION['fld_inquiry'] == 'リフォームの相談') ? 'checked' : ''  ?>>
                <span class="text">リフォームの相談</span>
              </label>
              <label  class="contactForm__fieldLabel radio">
                <input type="radio" name="fld_inquiry" id="" class="contactForm__radio" value="公共工事の相談" <?= (isset($_SESSION['fld_inquiry']) && $_SESSION['fld_inquiry'] == '公共工事の相談') ? 'checked' : ''  ?>>
                <span class="text">公共工事の相談</span>
              </label>
              <label  class="contactForm__fieldLabel radio">
                <input type="radio" name="fld_inquiry" id="" class="contactForm__radio" value="その他" <?= (isset($_SESSION['fld_inquiry']) && $_SESSION['fld_inquiry'] == 'その他') ? 'checked' : ''  ?>>
                <span class="text">その他</span>
              </label>
            </fieldset>
            <div class="contactForm__fieldGroup">
              <label for="familyName" class="contactForm__fieldLabel">
                お名前
                <span class="contactForm__requiredText"><span class="red">★</span>必須</span>
              </label>
              <div class="contactForm__twoInputWrap">
                <input type="text" name="fld_familyName" id="familyName" class="contactForm__textInput" placeholder="青牡丹" value="<?= $_SESSION['fld_familyName'] ?? '' ?>" autocomplete="family-name" required>
                <input type="text" name="fld_givenName" class="contactForm__textInput" placeholder="幸太郎" value="<?= $_SESSION['fld_givenName'] ?? '' ?>" autocomplete="given-name" required>
              </div>
            </div>
            <div class="contactForm__fieldGroup">
              <label for="email" class="contactForm__fieldLabel">
                メールアドレス
                <span class="contactForm__requiredText"><span class="red">★</span>必須</span>
              </label>
              <input type="email" name="fld_email" id="email" class="contactForm__textInput" placeholder="aobotan@gmail.com" value="<?= $_SESSION['fld_email'] ?? '' ?>" autocomplete="email" required>
            </div>
            <div class="contactForm__fieldGroup">
              <label for="tel" class="contactForm__fieldLabel">
                電話番号
                <span class="contactForm__requiredText"><span class="red">★</span>必須</span>
              </label>
              <input type="tel" name="fld_tel" id="tel" class="contactForm__textInput" placeholder="000-0000-0000" value="<?= $_SESSION['fld_tel'] ?? '' ?>"  autocomplete="tel-national" required>
            </div>
            <div class="contactForm__fieldGroup">
              <label for="address" class="contactForm__fieldLabel">住所</label>
              <input type="text" name="fld_address" id="address" class="contactForm__textInput" placeholder="大阪府大阪市中央区北区南町5-6-7" value="<?= $_SESSION['fld_address'] ?? '' ?>">
            </div>
            <div class="contactForm__confirmWrapper">
              <input type="checkbox" name="fld_confirm" id="confirm" class="contactForm__confirmCheckbox" value="確認しました" required>
              <label for="confirm" class="contactForm__confirmText">入力内容に間違いないことを確認しました</label>
            </div>
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <div class="contactForm__submit">
              <button type="submit" class="btn btn--bgMainColor" disabled>送信する</button>
            </div>
          </form>
        </div>
      </section> 
      <?php
        foreach($_SESSION as $key => $value){
          if($key != 'token'){
            unset($_SESSION[$key]);
          }
        }
      ?>        
      <?php require_once('common_contact.php'); ?>
    </main>
    <!-- End of main -->
    <?php require_once('footer.php'); ?>
  </div>
  <!-- End of mainWrapper -->
</div>
<!-- End of pcHeaderSpacer -->

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
