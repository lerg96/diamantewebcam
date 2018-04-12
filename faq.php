<!DOCTYPE html>
<html lang="en">
<?php
include('head.php')
?>

<body>
<!--==============================header=================================-->
<header id="header">
    <div class="container">
        <h1 class=""><a href="index.html"><img alt="Grill point" src="img/diamante.png"></a></h1>
        <h2 class="mia" style="font-weight: bold;<">DIAMANTE</h2>
        <br>
        <h2 class="mia" style="font-weight: bold;">WEBCAM</h2>
    </div>
    <div class="menuheader">
        <div class="container">
            <nav class="navbar navbar-default navbar-static-top tm_navbar" role="navigation">
                <ul class="nav sf-menu">
                    <li class="active"><a href="index.html">INICIO</a></li>
                    <li><a href="acerca.html">NOSOTROS</a>

                    </li>

                    <li><a href="unete.html">UNETE</a></li>
                    <li><a href="habitaciones.html">HABITACIONES</a></li>
                    <li class="active"><a href="faq.html">FAQ</a></li>
                    <li><a href="contacto.html">CONTACTO</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!--==============================content=================================-->
<div class="container">

    <div class="page-header">
        <h1 style="color: white;text-align: center;">PREGUNTAS FRECUENTES</h1>
    </div>

    <!-- Bootstrap FAQ - START -->
    <div class="container">


        <div class="panel-group" id="accordion">
            <div class="faqHeader"></div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           style="font-weight: bold;">¿Existe en algún momento algún contacto físico con una segunda
                            persona?</a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
                        No, no hay contacto físico alguno, todo se desarrolla de manera virtual, a través de internet,
                        no habiendo en ningún caso relación de otro tipo con cliente alguno.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTen">Can I submit my own Bootstrap templates or themes?</a>
                    </h4>
                </div>
                <div id="collapseTen" class="panel-collapse collapse">
                    <div class="panel-body">
                        A lot of the content of the site has been submitted by the community. Whether it is a commercial
                        element/template/theme
                        or a free one, you are encouraged to contribute. All credits are published along with the
                        resources.
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseEleven">What is the currency used for all transactions?</a>
                    </h4>
                </div>
                <div id="collapseEleven" class="panel-collapse collapse">
                    <div class="panel-body">
                        All prices for themes, templates and other items, including each seller's or buyer's account
                        balance are in <strong>USD</strong>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion"
                           href="#collapseTwelve">What is the curregncy used for all transactions?</a>
                    </h4>
                </div>
                <div id="collapseTwelve" class="panel-collapse collapse">
                    <div class="panel-body">
                        All prices for themes, templates and other items, including each seller's or buyer's account
                        balance are in <strong>USD</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <style>
        .faqHeader {
            font-size: 27px;

        }

        .panel-heading [data-toggle="collapse"]:after {
            font-family: 'Glyphicons Halflings';
            content: "\e072"; /* "play" icon */
            float: right;
            color: #F58723;
            font-size: 18px;
            line-height: 22px;
            /* rotate "play" icon from > (right arrow) to down arrow */
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        .panel-heading [data-toggle="collapse"].collapsed:after {
            /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
            -webkit-transform: rotate(90deg);
            -moz-transform: rotate(90deg);
            -ms-transform: rotate(90deg);
            -o-transform: rotate(90deg);
            transform: rotate(90deg);
            color: #454444;
        }
    </style>

    <!-- Bootstrap FAQ - END -->

</div>
<?php
include('footer.php');
include('scripts.php')
?>
</body>
</html>