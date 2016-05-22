<?php
// Esta linha muda a codificação do arquivo para utf-8 //
ini_set('default_charset', 'utf-8'); 
// Esta linha muda a codificação do arquivo para utf-8 // 

// CONSTANTES //
define ("TITULO", 0);
define ("SUBTITULO", 1);
define ("SINOPSE", 2);
define ("DURACAO", 3);
define ("ANO", 4);
define ("CAPA", 5);
define ("VIDEO", 6);
define ("GENERO", 7);
define ("ELENCO", 8);
define ("DIRECAO", 9);
define ("IDIOMA", 10);
define ("PAIS", 11);
define ("AVALIACAO", 12);
define ("VISUALIZACAO", 13);
// CONSTANTES //

// ROTINAS //

function abrecsv ($nome_arq) {
		$arquivo = fopen($nome_arq, "r");
		$linhas = array();
		$l = fgetcsv ($arquivo);
		while (!feof($arquivo)) {
			$l = fgetcsv($arquivo);
			$linhas[] = $l;
		}
	fclose($arquivo);
	return $linhas;
}
//abrecsv

function ordenar ($lista,$ordem = 1,$param = TITULO) {
	for ($i = 0; $i < count($lista) - 1; $i++) {
		$indiceMenor = $i;
		$k = $i + 1;
		while ($k < count($lista)) {
			if ($lista[$k][$param] < $lista[$indiceMenor][$param] == $ordem) {
				$indiceMenor = $k;
			}
			$k += 1;
		}
		$aux = $lista[$indiceMenor];
		$lista[$indiceMenor] = $lista[$i];
		$lista[$i] = $aux;
	}
	return $lista;
}
// ordenar // FOI USADO O SELECTION SORT //

function filtrar_c_limites($lista, $param, $limite_inf, $limite_sup) {
	$resultado = array();
	foreach ($lista as $filme) {
		//superior
		if ($limite_inf == NULL) {
			if ($filme[$param] <= $limite_sup) {
				$resultado[] = $filme;
			}
		}
		//inferior e superior
		else if ($limite_sup != NULL){
			if ($filme[$param]>= $limite_inf && $filme[$param] <= $limite_sup) {
				$resultado[] = $filme;
			}
		}
		//só tem limite inferior
		else {
			if ($filme[$param]>= $limite_inf) {
				$resultado[] = $filme;
			}
		}
	}
	
	return $resultado;
}
function busca ($lista,$nome,$criterio = TITULO) {
	$resultado_busca = array();
	foreach ($lista as $filme) {
		if (substr_count( mb_strtolower($filme[$criterio]), mb_strtolower($nome)) > 0) {
			$resultado_busca[] = $filme;
		}
	}
	return $resultado_busca;
}
// busca

function selecionar_elementos_c_limites ($lista, $lim_inf, $lim_sup) {
	$selecionados = array();
	// TRATANDO POSSÍBILIDADES DE ERROS //
	if ($lim_sup < 1) $lim_sup = 1;
	// TRATANDO POSSÍBILIDADES DE ERROS //
	for ($i = $lim_inf; $i < $lim_sup; $i++) {
		$selecionados[] = $lista[$i];
	}
	return $selecionados;
}
function busca_avancada($lista, $elenco, $direcao, $idioma, $pais, $duracao, $ano, $avaliacao, $visual, $genero = NULL) {
	$resultado = $lista;
	// GENERO //
		if ($genero != NULL) $resultado = busca ($resultado, $genero, GENERO);
		else $resultado = $lista;
	// GENERO //
	
	// DURACAO //
		if ($duracao == "Todos") $resultado = $resultado;
		if ($duracao == "curto") $resultado = filtrar_c_limites ($resultado, DURACAO, 0, 30);
		if ($duracao == "medio") $resultado = filtrar_c_limites ($resultado, DURACAO, 31, 120);
		if ($duracao == "longo") $resultado = filtrar_c_limites ($resultado, DURACAO, 121, NULL);
	// DURACAO //
	
	// ANO //
		if ($ano == "Todos") $resultado = $resultado;
		if ($ano == "antigo") $resultado = filtrar_c_limites($resultado, ANO, NULL, 1975);
		if ($ano == "medio") $resultado = filtrar_c_limites($resultado, ANO, 1976, 1999);
		if ($ano == "recente") $resultado = filtrar_c_limites($resultado, ANO, 2000, NULL);
	// ANO //
	
	// AVALIACAO //
		if ($avaliacao == "Todos") $resultado = $resultado;
		if ($avaliacao == "ruins") $resultado = filtrar_c_limites($resultado, AVALIACAO, 0, 1);
		if ($avaliacao == "medios") $resultado = filtrar_c_limites($resultado, AVALIACAO, 2, 3);
		if ($avaliacao == "melhores") $resultado = filtrar_c_limites($resultado, AVALIACAO, 4, 5);
	// AVALIACAO //
	
	// VISUALIZACAO //
		$resultado = ordenar ($resultado, True, VISUALIZACAO);
		if ($visual == "Todos") $resultado = $resultado;
		if ($visual == "50mais") $resultado = selecionar_elementos_c_limites ($resultado, 0, 0.5*count($resultado));
		if ($visual == "20mais") $resultado = selecionar_elementos_c_limites ($resultado, 0, 0.2*count($resultado));
		if ($visual == "5mais") $resultado = selecionar_elementos_c_limites ($resultado, 0, 0.05*count($resultado));
	// VISUALIZACAO //
	
	// OUTROS //
	
	if ($elenco != "") $resultado = busca ($resultado, $elenco, ELENCO);
	if ($direcao != "") $resultado = busca ($resultado, $direcao, DIRECAO);
	if ($idioma != "") $resultado = busca ($resultado, $idioma, IDIOMA);
	if ($pais != "") $resultado = busca ($resultado, $pais, PAIS);
	
	// OUTROS //
	
	return $resultado;
}
// busca_avancada

// função que pega a url da página atual //
function pega_url() {
	$dominio = $_SERVER['HTTP_HOST'];
	$url = "http://".$dominio.$_SERVER['REQUEST_URI'];
	return $url;
}
// pega_url

function estatisticas($lista){ 
	$genero = array("Ação","Aventura","Animação","Comédia","Documentário","Fantasia","Ficção Científica","Musical","Romance","Suspense","Terror");
	$quantfilmesgenero = array();
	$views = array();
	$avaliacao = array();
	foreach($genero as $g){ 
		$somafilmesgenero = 0;
		$somaviewsgenero = 0; 
		$somaavaliacaogenero = 0; 
		foreach($lista as $p){ 
			if ($p[GENERO] == $g){ 
				$somafilmesgenero = $somafilmesgenero+1; 
				$somaviewsgenero = $somaviewsgenero+$p[VISUALIZACAO]; 
				$somaavaliacaogenero = $somaavaliacaogenero+$p[AVALIACAO]; 
			} 
		} 
	$quantfilmesgenero[] = $somafilmesgenero; 
	$views[] = $somaviewsgenero; 
	$avaliacao[] = $somaavaliacaogenero; 
	} 
	return array($quantfilmesgenero,$genero,$views,$avaliacao); 
}
// estatisticas

// ROTINAS //


// TESTE //
 //
// TESTE //

?>