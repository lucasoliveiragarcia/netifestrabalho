<?php
// constantes //


// constantes //

include ("Rotinas Netifes.php");
$lista = abrecsv("filmes.csv");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <div w3-include-html="html/head.html"></div>
</head>

<body>

    <!-- BARRA SUPERIOR -->
    <div w3-include-html="html/barrasuperior.html"></div>

    <div class="container">
        <div class="row">
			<!-- BARRA LATERAL -->
            <div w3-include-html="html/barralateral.html"></div>

            <div class="col-md-9">
				<!-- CAROUSEL -->
				<div w3-include-html="html/carousel.html"></div> 
				
				

                
                <!------------------------- CONTEÚDO (FILMES) -------------------------->

                <div class="row">
				
<?php
echo "."; // NÃO SEI PORQUE MAS QUANDO SE TIRA ESSA LINHA, AS VEZES, A IMPRESSÃO SAI FORA DA TABELA //	
// Busca simples
if (isset($_GET["busca"])) {
	$nome = $_GET["busca"];
	$ordem = $_GET["ordem"];
		//
		if ($ordem == "crescente") $ordem == True;
		if ($ordem == "") $ordem == False;
		//
	$criterio = $_GET["criterio"];
		//
		if ($criterio == "alfabetica") $param = 0;
		if ($criterio == "avaliacoes") $param = 12;
		if ($criterio == "visualizacoes") $param = 13;
		if ($criterio == "duracao") $param = 3;
		//
	if ($nome != "") $lista = busca ($lista, $nome);
	$lista = ordenar ($lista, $ordem, $param);
	}
// Busca simples

// Busca Avançada //
if (isset($_GET["visualizacao"])) {

	if (isset($_GET["genero"])) $lista = busca_avancada ($lista, $_GET["elenco"], $_GET["direcao"], $_GET["idioma"], $_GET["pais"], $_GET["duracao"], $_GET["ano"], $_GET["avaliacao"], $_GET["visualizacao"], $_GET["genero"]);
	else $lista = busca_avancada ($lista, $_GET["elenco"], $_GET["direcao"], $_GET["idioma"], $_GET["pais"], $_GET["duracao"], $_GET["ano"], $_GET["avaliacao"], $_GET["visualizacao"]);
//echo ".";
}
// Busca Avançada //

// CATEGORIA DE FILME DA BARRA LATERAL //
if (isset($_GET["genero"]) && !isset($_GET["duracao"])) {
	$genero = $_GET["genero"];
	if ($genero == "acao") $lista = busca ($lista, "Ação", GENERO);
	if ($genero == "aventura") $lista = busca ($lista, "Aventura", GENERO);
	if ($genero == "animacao") $lista = busca ($lista, "Animação", GENERO);
	if ($genero == "comedia") $lista = busca ($lista, "Comédia", GENERO);
	if ($genero == "documentario") $lista = busca ($lista, "Documentário", GENERO);
	if ($genero == "fantasia") $lista = busca ($lista, "Fantasia", GENERO);
	if ($genero == "ficcao") $lista = busca ($lista, "Ficção", GENERO);
	if ($genero == "musical") $lista = busca ($lista, "Musical", GENERO);
	if ($genero == "romance") $lista = busca ($lista, "Romance", GENERO);
	if ($genero == "suspense") $lista = busca ($lista, "Suspense", GENERO);
	if ($genero == "terror") $lista = busca ($lista, "Terror", GENERO);
}
// CATEGORIA DE FILME DA BARRA LATERAL //

// PARTE DA PAGINAÇÃO //
// linf refere-se à posição do primeiro filme a ser exibido na pagina em questão //
// lsup refere-se à posição do ultimo filme a ser exibido na pagina em questão //
if (!isset($_GET['linf'])) {
	$linf = 0;
	$lsup = 8;
	//echo count($lista);
	if (count($lista) < 8) $lsup = count($lista);
}
else {
	$linf = $_GET['linf'];
	$lsup = $_GET['lsup'];
	if ($_GET['lsup'] >= count($lista)) $lsup = count($lista);
}
// linf refere-se à posição do primeiro filme a ser exibido na pagina em questão //
// lsup refere-se à posição do ultimo filme a ser exibido na pagina em questão //
// PARTE DA PAGINAÇÃO //

// IMPRESSÃO DOS FILMES //
if (count($lista) == 0) echo "<p align ='center'><b><br>Não encontramos o que você estava procurando!</br></b></center>";
else {
	for ($i = $linf; $i < $lsup; $i++) {
			echo		"<!-- FILME -->";
            echo        "<div class='col-sm-3 col-lg-3 col-md-3'>";
            echo            "<div class='thumbnail'>";
            echo                "<img src='".$lista[$i][CAPA]."' />";
            echo                "<div class='caption'>";
            echo                    "<h4><a href='filme.php?titulo=".$lista[$i][TITULO]."&subt=".$lista[$i][SUBTITULO]."'>".$lista[$i][TITULO]."</a>";
            echo                    '</h4>';
            echo                    "<h5>".$lista[$i][SUBTITULO];
            echo                    '</h5>';
            echo                    "<p>".$lista[$i][DURACAO]."</p>";
                               
            echo                "</div>";
            // AVALIAÇÃO DO FILME (ESTRELAS) //
			echo                "<div class='ratings'>";
                                
            echo                    '<p>';
										for ($j = 1; $j <= $lista[$i][AVALIACAO]; $j++){
            echo                        "<span class='glyphicon glyphicon-star'></span>";
										}
            echo                    '</p>';
            echo                '</div>';
			// AVALIAÇÃO DO FILME (ESTRELAS) //
            echo            '</div>';
            echo        '</div>';
	
	}

}
// IMPRESSÃO DOS FILMES //
?>
                    
					
                </div>
                
                		
				
				
            </div>
<?php

// PAGINAÇÃO //            
echo			"<!--------- PAGINACAO -------->";
echo			"<div class='row' align='center'>";
echo				"<ul class='pagination' align='center'>";
for ($i = 1; $i < (count($lista)/8) + 1; $i++) {
	echo				  "<li><a href='".pega_url()."?".$i."&linf=".(($i - 1)*8)."&lsup=".($i*8)."'>".$i."</a></li>";
}
// linf refere-se à posição do primeiro filme a ser exibido na pagina em questão //
// lsup refere-se à posição do ultimo filme a ser exibido na pagina em questão //
echo				"</ul>";
echo			"</div>";
// PAGINAÇÃO //	

?>
        </div>

    </div>
    
	<!--------- RODAPÉ -------->
    <div w3-include-html="html/rodape.html"></div> 
    
    <!-- javascript -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/w3-include-HTML.js"></script>

</body>

</html>
