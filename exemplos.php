<?php
include 'MicrosoftTranslator.php';

/**
 * Exemplo de uso para tradução
 */
$from = 'en';
$to   = 'pt';
$txt  = 'How can I use the Microsoft Translator?';

$txtTraduzido = MicrosoftTranslator::translate($from, $to, $txt);
print_r($txtTraduzido);


/**
 * Exemplo de uso para detecção da linguagem usada em algum texto
 */
$detectar = MicrosoftTranslator::detectLanguage('Some text here');
print_r($detectar);


/**
 * Exemplo de uso para busca por linguagens para tradução
 */
$linguagens = MicrosoftTranslator::getLanguages();
print_r($linguagens);