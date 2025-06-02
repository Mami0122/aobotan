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

      setTimeout(() => {
        contentCover.style.display = 'none';
      }, 775);

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
    contentCover.style.display = 'none';
    contentCover.style.transition = 'unset';
    contentCover.classList.remove('active');
  }

  //ヘッダーメニュー・バーガーメニュー
  const burger = document.querySelector('.burgerBtn');
  const navMenu = document.querySelector('.header__nav');
  const navLinks = document.querySelectorAll('.header__navListItemLink, .header__navSubListItemLink');
  const mediaQuery = window.matchMedia('(min-width: 960px)');

  function handleMenuState() {
    if (mediaQuery.matches) {
      // PC: 常にメニュー表示、aria-hiddenはfalse
      navMenu.classList.remove('active');
      navMenu.setAttribute('aria-hidden', 'false');
      burger.setAttribute('aria-expanded', 'false'); //幅960以上でバーガーボタンはdisplay:none
      body.classList.remove('locked');
      if(burger.classList.contains('open')){
        burger.classList.remove('open');
      }
    } else {
      //スマホ・タブレット時: 初期状態では閉じた状態（aria-hidden: true）
      if (!burger.classList.contains('open')) {
        navMenu.setAttribute('aria-hidden', 'true');
      }
    }
  }

  function closeMobileMenu() {
    burger.setAttribute('aria-expanded', 'false');
    navMenu.classList.remove('active');
    navMenu.setAttribute('aria-hidden', 'true');
    body.classList.remove('locked');
    burger.classList.remove('open');
  }

  // バーガークリック処理
  burger.addEventListener('click', function () {
    this.classList.toggle('open');

    const isOpen = this.classList.contains('open');
    this.setAttribute('aria-expanded', isOpen);
    navMenu.classList.toggle('active', isOpen);
    navMenu.setAttribute('aria-hidden', !isOpen);
    body.classList.toggle('locked', isOpen);
  });

  // スマホ時、navリンククリックでメニューを閉じる処理
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      if (!mediaQuery.matches) {
        closeMobileMenu();
      }
    });
  });

  // メディアクエリが切り替わった時の処理
  mediaQuery.addEventListener('change', handleMenuState);

  // 初期状態反映
  handleMenuState();

  //PCのヘッダーnavメニュー内のサブメニューをキーボードで選択できるようにする処理
  const navItemHasSubMenu = document.querySelectorAll('.header__navListItem--hasSubMenu');

  function setupHeaderSubMenuBehavior(){
    if(mediaQuery.matches){
      navItemHasSubMenu.forEach((item) => {
        const subMenuLinks = item.querySelectorAll('.header__navSubListItemLink');

        item.addEventListener('focusin', ()=>{
          showNavSubMenu(item);
        });

        item.addEventListener('mouseenter', () => {
          showNavSubMenu(item);
        });

        item.addEventListener('focusout', ()=>{
              hideNavSubMenu(item);
        });

        item.addEventListener('mouseleave', () => {
          hideNavSubMenu(item);
        });

        subMenuLinks.forEach(link => {
          link.addEventListener('click', () => {
            setTimeout(() => {
              link.blur();
            }, 0);
          });
        });
      });
    } else {
      navItemHasSubMenu.forEach((item) => {
        const subMenu = item.querySelector('.header__navSubList');
        if(subMenu){
          subMenu.style.display = '';
        }
      });
    }
  }

  function showNavSubMenu(item){
    const subMenu = item.querySelector('.header__navSubList');
    if (subMenu) {
      subMenu.style.display = 'block';
    }
  }

  function hideNavSubMenu(item){
    const subMenu = item.querySelector('.header__navSubList');
    if (subMenu) {
      // 小さな遅延を設けて、フォーカスが移動済みかを判定する
      setTimeout(() => {
        if (!item.contains(document.activeElement)) {
          subMenu.style.display = '';
        }
      }, 10);
    }
  }

  setupHeaderSubMenuBehavior();
  mediaQuery.addEventListener('change', setupHeaderSubMenuBehavior);

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

  document.querySelectorAll('a[href*="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      const link = e.currentTarget;
      const href = link.getAttribute('href');

      // 現在のページのURLオブジェクトを作成
      const currentUrl = new URL(window.location.href);

      // リンクのURLオブジェクトを作成（相対パスも正しく処理）
      const targetUrl = new URL(href, currentUrl);

      // 同一ページかどうか（ホスト・パスが同じ）
      const isSamePage =
        targetUrl.origin === currentUrl.origin &&
        targetUrl.pathname === currentUrl.pathname;

      if (isSamePage && targetUrl.hash) {
        const targetId = targetUrl.hash;
        const targetElem = document.querySelector(targetId);

        if (targetElem) {
          e.preventDefault();

          const headerHeight = document.querySelector('header').offsetHeight;
          let targetPosition = targetElem.offsetTop;

          if (window.innerWidth < 960) {
            targetPosition -= (headerHeight + 30);
          }

          window.scrollTo({
            top: targetPosition,
            left: 0,
            behavior: 'smooth'
          });
        }
      }
    });
  });


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
        let position = target.offset().top;

        if (window.innerWidth < 960) {
          position -= (headerHeight + 30);
        }

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
    const modals = Array.from(document.querySelectorAll('.modal'));
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
        if(input.type == 'text' && input.required){
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

    const debounce = (mainFunction, delay) => {
      // Declare a variable called 'timer' to store the timer ID
      let timer;

      // Return an anonymous function that takes in any number of arguments
      return function (...args) {
        // Clear the previous timer to prevent the execution of 'mainFunction'
        clearTimeout(timer);

        // Set a new timer that will execute 'mainFunction' after the specified delay
        timer = setTimeout(() => {
          mainFunction(...args);
        }, delay);
      };
    };

    const debouncedCheckInputs = debounce(checkInputs, 300);

    inputs.forEach((input)=>{
      input.addEventListener('input',debouncedCheckInputs);
    });

    //バリデーションエラーでリダイレクトされた時の為に実施
    checkInputs();

    // フォーム送信後のバリデーションエラーでcontactページにリダイレクト後にエラーメッセージが表示された際のアクセシビリティ処理
    const formErrorMessageList = document.querySelector('.form-error-list');

    if(formErrorMessageList){
      formErrorMessageList.focus();
    }
  }

});
