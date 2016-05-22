<?php
include ("Rotinas Netifes.php");
$lista = abrecsv("filmes.csv");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NETIFES - Filmes e Vídeos</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/portfolio-item.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">NETIFES</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="#">Sobre</a>
                    </li>
                    <li>
                        <a href="#">Serviços</a>
                    </li>
                    <li>
                        <a href="#">Contatos</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">
<?php

// IMPRESSÃO DO TITULO E SUBTITULO DO FILME //
echo        "<!-- Portfolio Item Heading -->";
echo        "<div class='row'>";
echo            "<div class='col-lg-12'>";
echo                "<h1 class='page-header'>".$_GET["titulo"];
echo                    "<small> ".$_GET["subt"]."</small>";
echo                "</h1>";
echo            "</div>";
echo        "</div>";
echo        "<!-- /.row -->";
// IMPRESSÃO DO TITULO E SUBTITULO DO FILME //

?>
        <!-- Portfolio Item Row -->
        <div class="row">
<?php
// SELECIONANDO O FILME PARA A VISUALIZAÇÃO //
$filme = busca ($lista, $_GET["titulo"], TITULO);
$filme = busca ($filme, $_GET["subt"], SUBTITULO);
// SELECIONANDO O FILME PARA A VISUALIZAÇÃO //

// EXIBIÇÃO DO FILME //
echo            "<div class='col-md-8'>";
echo                "<!--img class='img-responsive' src='http://placehold.it/750x500' -->";
echo				"<iframe width='750' height='500'";
echo					"src='".$filme[0][VIDEO]."'>";
echo				"</iframe>";
echo				"<p><b>".$filme[0][VISUALIZACAO]."</b> visualizações</p>";
echo            "</div>";
// EXIBIÇÃO DO FILME //
?>

<?php

// DADOS DO FILME //
echo            "<div class='col-md-4'>";
echo                "<h4>".$filme[0][TITULO]." : ".$filme[0][SUBTITULO]."</h4>";
echo				"<p>";
						for ($i = 1; $i <= $filme[0][AVALIACAO]; $i++) {
echo					"<span class='glyphicon glyphicon-star'></span>";
						}
echo				"</p>";
echo                "<p><b>Sinopse:</b> ".$filme[0][SINOPSE]."</p>";
echo                "<p><b>Elenco:</b> ".$filme[0][ELENCO]."</p>";
echo				"<h4>Detalhes</h4>";
echo                "<ul>";
echo                    "<li><b>Duração:</b> ".$filme[0][DURACAO]." min</li>";
echo                    "<li><b>Ano:</b> ".$filme[0][ANO]."</li>";
echo                    "<li><b>Gênero:</b> ".$filme[0][GENERO]."</li>";
echo                    "<li><b>Direção:</b> ".$filme[0][DIRECAO]."</li>";
echo					"<li><b>País:</b> ".$filme[0][PAIS]."</li>";
echo					"<li><b>Língua:</b> ".$filme[0][IDIOMA]."</li>";
echo                "</ul>";
echo            "</div>";

echo        "</div>";
echo        "<!-- /.row -->";
// DADOS DO FILME //

?>

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; NETIFES LTDA.</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
