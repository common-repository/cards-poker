<?php
/*
Plugin Name: Cards_Poker
Plugin URI: http://www.blog-du-joueur.com/category/plugins-wp/
Description: Change les balises du style [9s 10c Td] ou [As Ac] par son équivalent graphique
Version: 1.3.5
Author: Hesiode
Author URI: http://www.blog-du-joueur.com

$Revision$

Copyright (C) 2010 Hesiode

Hesiode
Hesiode@replay-fr.com

Tested with PHP 4.3.8, WordPress 2.0.5 & 2.2 & 3.0 & 3.6
*/

function affiche_poker($text) {
	$content2="";
	$lignes = explode("\n",$text);
	for($i=0;$i<count($lignes);$i++){
		$ligne = $lignes[$i];
		$ligne = transforme_carte_pokerstars($ligne);
		$ligne = affiche_carte($ligne);
		$content2.=$ligne;
	}
	return $content2;
}

function transforme_carte_pokerstars($texte){
	$return = $texte;
	$pos = strpos($texte, "[");
	while($pos<>false){
		$debut = $pos;
		$fin = strpos($texte,"]",$pos);
		$chaine = substr($texte,$debut+1,$fin-$debut-1);
		$chaine_ori = substr($texte,$debut,$fin-$debut+1);
		$split = explode(" ",trim($chaine));
		$occ = "";
		for($i=0;$i<count($split);$i++){
			$occ.="[".trim($split[$i])."]";
		}
		$return = str_replace($chaine_ori,$occ,$return);
		$pos = strpos($texte, "[",$fin+1);
	}

	return $return;
}

function affiche_carte($texte){
	$motif ='`\[([akqbjtBAKQJT2-9]|10)([scdhDSCH])\]`e';
	$chaine = "'<IMG SRC=\"".WP_PLUGIN_URL."/cards-poker/cartes/'.(strtoupper($1)).(strtolower($2)).'.gif\" alt=\"$1$2\" border=\"0\">'";
	$chain  = preg_replace($motif,$chaine,$texte);

	$motif='`\[\:([akbqjtABKQJT2-9]|10)([scdhDSCH])\]`';
	$chaine = "[$1$2]";
	$chain  = preg_replace($motif,$chaine,$chain);

	return $chain;
}

add_filter('the_content',affiche_poker);
add_filter('the_excerpt', affiche_poker);
add_filter('comment_text', affiche_poker);

?>