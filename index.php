<?php
session_start();

if (isset($_SESSION['usuario'])) {
    //header("location:index.php");
    $user = $_SESSION['usuario'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/logos2.jpg">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/logos2.jpg">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Control de la uteq</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/gaia.css" rel="stylesheet" />

    <!--     Fonts and icons     -->
    <link href='https://fonts.googleapis.com/css?family=Cambo|Poppins:400,600' rel='stylesheet' type='text/css'>
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/fonts/pe-icon-7-stroke.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-inverse navbar-transparent navbar-fixed-top" color-on-scroll="200">
        
        <div class="container">
            <div class="navbar-header">
                <button id="menu-toggle" type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#example">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar bar1"></span>
                    <span class="icon-bar bar2"></span>
                    <span class="icon-bar bar3"></span>
                </button>
                <a href="#" class="navbar-brand"><small>INICIO</small></a>
                <!-- <a href="../integradora/sesion/inicio.php" class="navbar-brand"><small>INICIAR DE SESION</small></a> -->
                <?php if(!empty($user)): ?>
                    <!-- <br> Welcome. <?= $user; ?> -->
                    <a class="navbar-brand" href="sesion/logout.php">
                        Cerrar sesion
                    </a>
                    <?php else: ?>
                    <!-- <h1>Login</h1> -->
                    <a class="navbar-brand" href="sesion/login.php">Iniciar sesion</a>
                    <?php endif; ?>
            </div>
           
        </div>
    </nav>
   
    <div class="section section-header">
        <div class="parallax filter filter-color-Black">
            <div class="image" style="background-image: url('assets/img/uteq.png')">
            </div>
            <div class="container">
                <div class="content">
                    <div class="title-area">
                        <h3>Bienvenido a</h3>
                        <h1 class="title-modern">Control de la UTEQ</h1>
                        <div class="separator line-separator">✻</div>
                    </div>
                    <a target="_blannc" a>
                </div>
            </div>

        </div>
    </div>
    </div>




    <footer class="footer footer-big footer-color-black" data-color="black">
        <div class="container">
            <div class="row">
                <div class="col-md-3 co3-sm-3">
                    <div class="info">
                        <h5 class="title"> Ayuda y soporte</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://wa.me/524428672255">Contactanos</a>
                                </li>
                                <li>
                                    <a href="#">Como funciona</a>
                                </li>
                                <li>
                                    <a href="https://www.montacargaspsm.com/terminos-y-condiciones">Terminos &amp; Condiciones</a>
                                </li>
                                <li>
                                    <a href="https://www.ealde.es/tipos-politica-empresa/">Politica de la empresa</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                </li>
                <div class="col-md-4 col-md-offset-4 col-sm-4">
                    <div class="info">
                        <h5 class="title">Siguenos en nuestras redes sociales.</h5>
                        <nav>
                            <ul>
                                <li>
                                    <a href="https://www.facebook.com/Mitservice-107396134396904"
                                        class="btn btn-social btn-facebook btn-simple">
                                        <i class="fa fa-facebook-square"></i> Facebook
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="btn btn-social btn-instagram btn-simple">
                                        <i class="fa fa-instagram"></i> Instagram
                                    </a>
                                </li>
                                <li>
                                    <a href="https://www.google.com.mx " class="btn btn-social btn-reddit btn-simple">
                                        <i class="fa fa-google-plus-square"></i> Google+
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <hr>
            <div class="copyright">
                ©
                <script> document.write(new Date().getFullYear()) </script> NOVATECH-PAGINA DE JUGUETES.
            </div>
        </div>
    </footer>

</body>

<script src="assets/js/jquery.min.js" type="text/javascript"></script>
<script src="assets/js/bootstrap.js" type="text/javascript"></script>

<script type="text/javascript" src="assets/js/modernizr.js"></script>

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>

<script type="text/javascript" src="assets/js/gaia.js"></script>

</html>
