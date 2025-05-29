document.addEventListener("DOMContentLoaded", function () {

  new WOW().init();

  // ローディング
  let storage = sessionStorage;
  const body = document.querySelector('body');
  const contentCover = document.querySelector('.contentCover'); 
  const loading = document.querySelector('.loading');

  function loading_fadeOut() {
    loading.classList.remove('active');
    loading.style.display = 'none';

    setTimeout(() => {
      contentCover.classList.remove('active');
    }, 200);

    storage.setItem('session', true);
  }

  if (!storage.getItem('session')) {
    loading.classList.add('active');

    window.addEventListener('load', () => {
      setTimeout(loading_fadeOut, 3000);
    })

  } else {
    loading.style.display = 'none';
    contentCover.classList.remove('active');
  }

  //バーガーメニュー
  const burger = document.querySelector('.burgerBtn');
  const navMenu = document.querySelector('.header__nav');

  burger.addEventListener('click', function () {
    this.classList.toggle('open');

    if (this.classList.contains('open')) {
      burger.setAttribute('aria-expanded', true);
      navMenu.classList.add('active');
      navMenu.setAttribute('aria-hidden', false);
      body.classList.add('locked');
    } else {
      burger.setAttribute('aria-expanded', false);
      navMenu.classList.remove('active');
      navMenu.setAttribute('aria-hidden', true);
      body.classList.remove('locked');
    }
  });

  const headerNavLink = document.querySelectorAll('.header__navListItemLink');
  const headerNavSubListLink = document.querySelectorAll('.header__navSubListItemLink');

  function closeMobileMenu(headerNavLinks) {
    for (const headerNavLink of headerNavLinks) {
      headerNavLink.addEventListener('click', function () {
        navMenu.classList.remove('active');
        burger.classList.remove('open');
      })
    }
  }

  closeMobileMenu(headerNavLink);
  closeMobileMenu(headerNavSubListLink);

  // swiper
  const swiper = new Swiper('.frontAbout__swiper', {
    slidesPerView: 'auto',
    loopAdditionalSlides: 2,
    spaceBetween: 16,
    loop: true,
    speed: 6000,
    autoplay: {
      delay: 0, 
    },
    breakpoints: {
      768: {
        spaceBetween: 32,
      },
      960: {
        spaceBetween: 32,
      },
      1360: {
        spaceBetween: 48,
      },
      1440: {
        spaceBetween: 48,
      },
    }
  });

  // 同ページ内のid要素へのスムーススクロール
  const hash_anchors = document.querySelectorAll('a[href^="#"]');

  for (const anchor of hash_anchors) {
    anchor.addEventListener('click', (e) => {
      const href = e.currentTarget.getAttribute('href');
      const target = (href == "" || href == "#") ? 'html' : href;
      const headerHeight = document.querySelector('header').offsetHeight;

      if (target !== 'html') {
        const target_elem = document.querySelector(target);

        if (target_elem) {
          e.preventDefault();
        }

        let target_position = target_elem.offsetTop;

        if(window.innerWidth < 960){
          target_position = target_elem.offsetTop - headerHeight
        }

        window.scrollTo({
          top: target_position,
          left: 0,
          behavior: "smooth"
        });
      }
    });
  }

  // ページ外のid要素へのスムーススクロール処理
  const urlHash = location.hash;
  if (urlHash) {
    const target = jQuery(urlHash);
    if (target.length) {
      // ページトップから開始（ブラウザ差異を考慮して併用）
      history.replaceState(null, '', window.location.pathname);
      jQuery("html,body").stop().scrollTop(0);

      jQuery(window).on("load", function () {
        const headerHeight = jQuery("header").outerHeight();
        const position = target.offset().top - headerHeight - 20;
        jQuery("html, body").animate({ scrollTop: position }, 500, "swing");

        // ハッシュを再設定
        history.replaceState(null, '', window.location.pathname + urlHash);
      });
    }
  }

  // お知らせセクションモーダル
  const newsItems = document.querySelectorAll('.newsItem__btn');
  let modal = '';

  newsItems.forEach((news, index)=>{
    news.addEventListener('click', ()=>{
      newsModalOpen(index);
    });
  });

  function newsModalOpen(index){
    const modals = Array.from(document.querySelectorAll('.newsItem__modal'));
    modal = modals[index];
    const modalClosers = modal.querySelectorAll('.js-newsModalCloser'); 
    
    modal.showModal();

    if(window.matchMedia('(pointer: coarse)').matches){
      modalClosers[0].blur();
    }

    body.classList.add('locked');

    modalClosers.forEach((modalCloser) => {
      modalCloser.addEventListener('click', newsModalClose);
    });

    // モーダル背景のクリックでモーダルを閉じる処理
    modal.addEventListener('click', (event)=>{
      const isBackdropClicked = (event.target === modal) ? true : false;

      if(isBackdropClicked){
        newsModalClose();
      }
    });
  }

  function newsModalClose(){
    modal.close();
    body.classList.remove('locked');
  }

  // フォーム
  if(location.pathname.includes('contact')){
    const form = document.querySelector('.contactForm');
    const inputs = form.querySelectorAll('input');
    const radios = [];
    const submitButton = form.querySelector('.btn');

    inputs.forEach((input)=>{
      if(input.type === 'radio'){
        radios.push(input);
      }
    });

    function checkInputs(){
      let textInputFilled = true;
      let radioCheckedArray = [];
      let radioChecked = true;

      inputs.forEach((input)=>{
        if(input.type !== 'radio' && input.type !== 'checkbox' && input.required){
          if(input.value.trim() === ''){
            textInputFilled = false;
          }
        }else if(input.type === 'checkbox'){
          if(input.checked){
          }else{
            textInputFilled = false;
          }
        }
      });
      
      radios.forEach((radio)=>{
        if(radio.checked){
          radioCheckedArray.push(true);
        }else{
          radioCheckedArray.push(false);
        }
      });

      if(!radioCheckedArray.includes(true)){
        radioChecked = false;
      }

      if(textInputFilled && radioChecked){
        submitButton.disabled = false;
      }else{
        submitButton.disabled = true;
      }
    }
    
    inputs.forEach((input)=>{
      input.addEventListener('input',checkInputs);
    });

    // フォーム送信後のバリデーションエラーでcontactページにリダイレクト後にエラーメッセージが表示された際のアクセシビリティ処理
    const formErrorMessageList = document.querySelector('.form-error-list');

    if(formErrorMessageList){
      formErrorMessageList.focus();
    }
  }

});
