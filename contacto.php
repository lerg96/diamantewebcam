<!DOCTYPE html>
<html lang="en">
<?php
include('head.php')
?>
<body>
<!--==============================header=================================-->
<header id="header">
    <div class="container">
        <h1 class=""><a href="index.html"><img alt="Grill point" src="img/diamante.png" ></a></h1>
        <h2 class="mia" style="font-weight: bold;<">DIAMANTE</h2>
        <br>
        <h2 class="mia" style="font-weight: bold;">WEBCAM</h2>
    </div>
    <div class="menuheader">
        <div class="container">
            <nav class="navbar navbar-default navbar-static-top tm_navbar" role="navigation">
                <ul class="nav sf-menu">
                    <li><a href="index.html">INICIO</a></li>
                    <li><a href="acerca.html">NOSOTROS</a>

                    </li>

                    <li><a href="unete.html">UNETE</a></li>
                    <li><a href="habitaciones.html">HABITACIONES</a></li>
                    <li><a href="faq.html">FAQ</a></li>
                    <li class="active"><a href="contacto.html">CONTACTO</a></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!--==============================content=================================-->
<div id="content">
    <!--==============================row8=================================-->
    <div class="row_8">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 gmap">
                    <div class="map">

                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1179.1142075055611!2d-75.59881187822472!3d6.256927801953662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses-419!2sco!4v1523113799611" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>



                    </div>
                </div>
            </div>

            <div class="col-lg-8 col-md-8 col-sm-8 address">
                <h2>Contacto</h2>
                <form id="contact-form" class="contact-form">
                    <div class="success"> Contact form submitted! <strong>We will be in touch soon.</strong> </div>
                    <fieldset>
                        <div class="coll-1">
                            <div class="txt-form">Name<span>*</span></div>
                            <label class="name">
                                <input type="text" value="Nombre*:"><br>
                                <span class="error">*Nombre invalido.</span> <span class="empty">*Campo requerido.</span> </label>
                        </div>
                        <div class="coll-2">
                            <div class="txt-form">Email<span>:</span></div>
                            <label class="email">
                                <input type="email" value="E-mail*:"><br>
                                <span class="error">*E-mail invalido.</span> <span class="empty">*Campo requerido.</span> </label>
                        </div>
                        <div class="coll-3">
                            <div class="txt-form">phone:</div>
                            <label class="phone notRequired">
                                <input type="tel" value="Teléfono:"><br>
                                <span class="error">*Número de teléfono invalido.</span> <span class="empty">*Campo requerido.</span> </label>
                        </div>
                        <div class="clear"></div>
                        <div>
                            <div class="txt-form">Comment<span>*</span></div>
                            <label class="message">
                                <textarea>Mensaje*:</textarea><br>
                                <span class="error">*Mensaje muy corto.</span> <span class="empty">*Campo requerido.</span> </label>
                        </div>
                        <div class="clear"></div>
                    </fieldset>
                    <div class="buttons-wrapper clearfix"><a href="#" class="btn-link btn-link2" data-type="submit">Enviar<span></span></a><strong>*Campo requerido</strong></div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<?php
include('footer.php');
include('scripts.php')
?>
</body>
</html>