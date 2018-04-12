<!--
<script src="js/jquery.js"></script>
<script src="js/jquery-migrate-1.2.1.js"></script>
<script src="js/superfish.js"></script>
<script src="js/jquery.mobilemenu.js"></script>
<script src="js/jquery.easing.1.3.js"></script>
<script src="js/jquery.ui.totop.js"></script>
<script src="js/jquery.touchSwipe.min.js"></script>
<script src="js/jquery.equalheights.js"></script>
<script src='js/camera.js'></script>
<script src="js/wow.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/tm-scripts.js"></script>
<script src="js/owl.carousel.min.js"></script>
-->
<!-- JS comprimido y junto -->
<script src="js/app.min.js"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-117103858-1"></script>
<!--[if (gt IE 9)|!(IE)]><!-->
<script src="js/jquery.mobile.customized.min.js"></script>
<!--<![endif]-->
<!--[if lt IE 9]>
<div style='text-align:center'><a
        href="http://windows.microsoft.com/en-US/internet-explorer/products/ie/home?ocid=ie6_countdown_bannercode"><img
        src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" height="42"
        width="820"
        alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."/></a>
</div>
<link rel="stylesheet" href="assets/tm/css/tm_docs.css" type="text/css" media="screen">
<script src="assets/assets/js/html5shiv.js"></script>
<script src="assets/assets/js/respond.min.js"></script>
<![endif]-->
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }

    gtag('js', new Date());
    gtag('config', 'UA-117103858-1');
    $(document).ready(function () {
        $(".owl-carousel").owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 1000,
            autoplayHoverPause: true

        });
        new WOW().init();
    });
    $(window).load(function () {
        jQuery('.camera_wrap').camera();

    });
</script>