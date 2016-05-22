<?php

include 'Rotinas Netifes.php';
$filmes = abrecsv("filmes.csv");
$quant = estatisticas($filmes);
$totalfilmes = count($filmes);

echo"Percentual de filmes em cada gênero<br>";
for($i=0;$i<count($quant[1]);$i++){
	$aux=(($quant[0][$i]/$totalfilmes)*100);
	$aux=number_format($aux,2,",","");
	print_r ($quant[1][$i]);
	echo "-> $aux%<br>";
	
}

echo"<br>Total de visualizações<br>";
$total=0;
for($i=0;$i<count($quant[2]);$i++){
	$total=$total+$quant[2][$i];
}
echo"$total<br><br>";
echo"Total de visualizações por gênero<br>";
for($i=0;$i<count($quant[1]);$i++){
	print_r ($quant[1][$i]);
	echo"->";
	print_r ($quant[2][$i]);
	echo"<br>";
}
echo"<br>";
echo"Avaliação média por gênero<br>";
for($i=0;$i<count($quant[1]);$i++){
	if ($quant[0][$i]>0){
		$media=$quant[3][$i]/$quant[0][$i];
		$media=number_format($media,2,",",".");
	}
	else {
		$media=NULL;
	}
	
	print_r ($quant[1][$i]);
	if ($media!=NULL) echo"->$media<br>";
	else echo"-> Esse genero nao possui filmes<br>";
}	
	
?>