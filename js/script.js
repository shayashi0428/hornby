'use strict';


$(function() {

  /* ---------------- Mobile slide navigagion ---------------- */
  
  function toggleSlideNav() {
    $('#main-menu-bg-overlay').fadeToggle();
    $('#main-menu').addClass('nav-transition');
    $('#main-menu').toggleClass('nav-active');
    setTimeout(function() {
      $('#main-menu').removeClass('nav-transition');
    }, 600);
  }
  
  $('.nav-toggle, #main-menu-bg-overlay').click(function() {
    toggleSlideNav();
  });
  
  $('#nav-links > li > a').click(function() {
    const $linkPath = this.pathname;
    const $currentPath = window.location.pathname;
    const $linkAnchor = this.hash;
    if ($linkPath == $currentPath && $linkAnchor) {
      toggleSlideNav();
    }
  });

  // $('.nav-toggle, #main-menu-bg-overlay').click(function() {
  //   $('#main-menu-bg-overlay').fadeToggle();
  //   $('#main-menu').addClass('nav-transition');
  //   $('#main-menu').toggleClass('nav-active');
  //   setTimeout(function() {
  //     $('#main-menu').removeClass('nav-transition');
  //   }, 600);    
  // });

  /* ---------------- Change navigation color on scroll ---------------- */

  const $nav = $("header nav");
  const $scrollPosition = $(document).scrollTop();
  const $home = $('.main').is('#home');

  function changeNavColor() {
    $(document).scroll(function() {
      $nav.toggleClass('nav-transparent', $(this).scrollTop() <= $nav.height());
    });
  }

  if (!$home) {
    $nav.removeClass('nav-transparent');
  } else if ($home && $scrollPosition > $nav.height()) {
    $nav.removeClass('nav-transparent');
    changeNavColor();
  } else {
    changeNavColor();
  }

  /* ---------------- Change padding for responsive cards ---------------- */

  const $cardBody = $('.blog-card .card-body');

  function changeCardPadding() {
    const $cardWidth = $cardBody.outerWidth();
    if ($cardWidth >= 340) {
      $cardBody.css('padding', '12%');
    } else {
      $cardBody.css('padding', '');
    }
  }  
  // Execute on load
  changeCardPadding();
  // Bind event listener
  $(window).resize(changeCardPadding);

  /* ---------------- Video modal popup ---------------- */
  
  $('.video-modal-toggle').click(function() {
    $('#video-modal').fadeToggle();
  });

  
});
