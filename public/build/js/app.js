/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Version: 4.0.0.
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Main Js File
*/

function rtlSwitchMode(){
    // $(".bootstrap-style").attr('href', 'build/css/bootstrap-rtl.min.css');
    $("html").attr("dir", 'rtl');
    $(".app-style").attr('href', assetPath+'build/css/app-rtl.min.css');
    sessionStorage.setItem("dir", "rtl-mode-switch");
}

function ltrSwitchMode(){
    $("html").attr("dir", 'ltr');
    $(".bootstrap-style").attr('href', 'build/css/bootstrap.min.css');
    $(".app-style").attr('href', assetPath+'build/css/app.min.css');
    sessionStorage.setItem("dir", "ltr-mode-switch");
}

(function ($) {

    'use strict';

    var language = localStorage.getItem('language');
    // Default Language
    var default_lang = 'en';

    function setLanguage(lang) {
        if (document.getElementById("header-lang-img")) {
            if (lang == 'en') {
                document.getElementById("header-lang-img").src = "build/images/flags/us.jpg";
            } else if (lang == 'ar') {
                document.getElementById("header-lang-img").src = "build/images/flags/eg.jpg";
            }
            
            localStorage.setItem('language', lang);
            language = localStorage.getItem('language');
            getLanguage();
        }
    }

    // Multi language setting
    function getLanguage() {
        (language == null) ? setLanguage(default_lang) : false;
        $.getJSON('build/lang/' + language + '.json', function (lang) {
            $('html').attr('lang', language);
            $.each(lang, function (index, val) {
                (index === 'head') ? $(document).attr("title", val['title']) : false;
                $("[key='" + index + "']").text(val);
            });
        });
    }

    function initMetisMenu() {
        //metis menu
        $("#side-menu").metisMenu();
    }

    function initLeftMenuCollapse() {
        $('#vertical-menu-btn').on('click', function (event) {
            event.preventDefault();
            $('body').toggleClass('sidebar-enable');
            if ($(window).width() >= 992) {
                $('body').toggleClass('vertical-collpsed');
            } else {
                $('body').removeClass('vertical-collpsed');
            }
        });
    }

    function initActiveMenu() {
        // === following js will activate the menu in left side bar based on url ====
        var pageUrl = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        pageUrl = pageUrl.substring(pageUrl.lastIndexOf("/") + 1);
        if (pageUrl) {
            if(document.getElementById("sidebar-menu")){
                var a = document.getElementById("sidebar-menu").querySelector('[href="' + pageUrl + '"]');
                // if (this.href == pageUrl) {
                if (a) {
                    $(a).addClass("active");
                    $(a).parent().addClass("mm-active"); // add active to li of the current link
                    $(a).parent().parent().addClass("mm-show");
                    $(a).parent().parent().prev().addClass("mm-active"); // add active class to an anchor
                    $(a).parent().parent().parent().addClass("mm-active");
                    $(a).parent().parent().parent().parent().addClass("mm-show"); // add active to li of the current link
                    $(a).parent().parent().parent().parent().parent().addClass("mm-active");
                }
            }
        }
    }

    function initMenuItemScroll() {
        // focus active menu in left sidebar
        $(document).ready(function () {
            if ($("#sidebar-menu").length > 0 && $("#sidebar-menu .mm-active .active").length > 0) {
                var activeMenu = $("#sidebar-menu .mm-active .active").offset().top;
                if (activeMenu > 300) {
                    activeMenu = activeMenu - 300;
                    $(".vertical-menu .simplebar-content-wrapper").animate({ scrollTop: activeMenu }, "slow");
                }
            }
        });
    }

    function initHoriMenuActive() {

        var pageUrl = location.pathname == "/" ? "index.html" : location.pathname.substring(1);
        pageUrl = pageUrl.substring(pageUrl.lastIndexOf("/") + 1);
        if (pageUrl) {
            if(document.getElementById("topnav-menu-content")){
                var a = document.getElementById("topnav-menu-content").querySelector('[href="' + pageUrl + '"]');
                // if (this.href == pageUrl) {
                if (a) {
                    $(a).addClass("active");
                    $(a).parent().addClass("active");
                    $(a).parent().parent().addClass("active");
                    $(a).parent().parent().parent().addClass("active");
                    $(a).parent().parent().parent().parent().addClass("active");
                    $(a).parent().parent().parent().parent().parent().addClass("active");
                    $(a).parent().parent().parent().parent().parent().parent().addClass("active");
                }
            }
        }
    }

    function initFullScreen() {
        $('[data-bs-toggle="fullscreen"]').on("click", function (e) {
            e.preventDefault();
            $('body').toggleClass('fullscreen-enable');
            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
        document.addEventListener('fullscreenchange', exitHandler);
        document.addEventListener("webkitfullscreenchange", exitHandler);
        document.addEventListener("mozfullscreenchange", exitHandler);
        function exitHandler() {
            if (!document.webkitIsFullScreen && !document.mozFullScreen && !document.msFullscreenElement) {
                console.log('pressed');
                $('body').removeClass('fullscreen-enable');
            }
        }
    }

    function initRightSidebar() {
        // right side-bar toggle
        $('.right-bar-toggle').on('click', function (e) {
            $('body').toggleClass('right-bar-enabled');
        });

        $(document).on('click', 'body', function (e) {
            if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
                return;
            }

            $('body').removeClass('right-bar-enabled');
            return;
        });
    }

    function initDropdownMenu() {
        if (document.getElementById("topnav-menu-content")) {
            var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
            for (var i = 0, len = elements.length; i < len; i++) {
                elements[i].onclick = function (elem) {
                    if (elem.target.getAttribute("href") === "#") {
                        elem.target.parentElement.classList.toggle("active");
                        elem.target.nextElementSibling.classList.toggle("show");
                    }
                }
            }
            window.addEventListener("resize", updateMenu);
        }
    }

    function updateMenu() {
        var elements = document.getElementById("topnav-menu-content").getElementsByTagName("a");
        for (var i = 0, len = elements.length; i < len; i++) {
            if (elements[i].parentElement.getAttribute("class") === "nav-item dropdown active") {
                elements[i].parentElement.classList.remove("active");
                if (elements[i].nextElementSibling !== null) {
                    elements[i].nextElementSibling.classList.remove("show");
                }
            }
        }
    }

    function initComponents() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
        var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl)
        });

        var offcanvasElementList = [].slice.call(document.querySelectorAll('.offcanvas'))
        var offcanvasList = offcanvasElementList.map(function (offcanvasEl) {
            return new bootstrap.Offcanvas(offcanvasEl)
        })
    }

    function initPreloader() {
        $(window).on('load', function () {
            $('#status').fadeOut();
            $('#preloader').delay(350).fadeOut('slow');
        });
    }

    function initSettings() {
        if (window.sessionStorage) {
            var alreadyVisited = sessionStorage.getItem("mode");
            if (!alreadyVisited) {
                if ($('body').attr('data-layout-mode') === 'dark') {
                    $("#dark-mode-switch").prop('checked', true);
                    $("#light-mode-switch").prop('checked', false);
                    sessionStorage.setItem("mode", "dark-mode-switch");
                    updateThemeSetting(alreadyVisited);
                } else {
                    sessionStorage.setItem("mode", "light-mode-switch");
                }
            } else {
                $(".right-bar input:checkbox").prop('checked', false);
                $("#" + alreadyVisited).prop('checked', true);
                updateThemeSetting(alreadyVisited);
            }
        }
        $("#light-mode-switch, #dark-mode-switch").on("change", function (e) {
            updateThemeSetting(e.target.id);
        });

        // show password input value
        $("#password-addon").on('click', function () {
            if ($(this).siblings('input').length > 0) {
                $(this).siblings('input').attr('type') == "password" ? $(this).siblings('input').attr('type', 'input') : $(this).siblings('input').attr('type', 'password');
            }
        })
    }

    function initDirSetting(){
        if (window.sessionStorage) {
            var dir = sessionStorage.getItem("dir");
            if (dir) {
                if (dir === "rtl-mode-switch") {
                    rtlSwitchMode();
                }else if (id === "ltr-mode-switch") {
                    ltrSwitchMode();
                }
            }else{
                if(language == 'en'){
                    ltrSwitchMode();
                }else if(language == 'ar'){
                    rtlSwitchMode();
                }
                
            }
        }
    }

    function updateThemeSetting(id) {
        if (id === "light-mode-switch") {
            $("#dark-mode-switch").prop("checked", false);
            // $(".bootstrap-style").attr('href', assetPath+'build/css/bootstrap.min.css');
            $('body').attr('data-layout-mode', 'light');
            // $(".app-style").attr('href', assetPath+'build/css/app.min.css');
            sessionStorage.setItem("mode", "light-mode-switch");
        } else if (id === "dark-mode-switch") {
            $("#light-mode-switch").prop("checked", false);
            $('body').attr('data-layout-mode', 'dark');
            sessionStorage.setItem("mode", "dark-mode-switch");
        }
    }

    function initLanguage() {
        // Auto Loader
        if (language != null && language !== default_lang)
            setLanguage(language);
        $('.language').on('click', function (e) {
            setLanguage($(this).attr('data-lang'));
        });
    }

    function initCheckAll() {
        $('#checkAll').on('change', function () {
            $('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
        });
        $('.table-check .form-check-input').change(function () {
            if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
                $('#checkAll').prop('checked', true);
            } else {
                $('#checkAll').prop('checked', false);
            }
        });
    }

    function init() {
        initMetisMenu();
        initLeftMenuCollapse();
        initActiveMenu();
        initMenuItemScroll();
        initHoriMenuActive();
        initFullScreen();
        initRightSidebar();
        initDropdownMenu();
        initComponents();
        initSettings();
        initDirSetting(); // handle initializing direction
        initLanguage();
        initPreloader();
        Waves.init();
        initCheckAll();
    }

    init();

})(jQuery)