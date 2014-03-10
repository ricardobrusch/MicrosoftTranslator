<?php

/** 
 * Classe para auxiliar a tradução de textos utilizando a API da Microsoft
 *  
 * @author Ricardo Brusch <brusch.ricardo@gmail.com>
 * @link <https://www.github.com/ricardobrusch>
 * 
 */
class  MicrosoftTranslator 
{    
    /**
     *
     * @var type string Coloque o valor de "Primary Account Key"
     * Valor encontrado na sua conta da Azure MarketPlace 
     * @link <https://datamarket.azure.com>
     */
    private static $key = 'SUA_CHAVE_PRIMARIA';
    
    /**
     * 
     * @param type string $from linguagem do texto original
     * @param type string $to linguagem para tradução
     * @param type string $txt texto a ser traduzido
     * 
     * @return Texto já traduzido pela API
     */
    public static function translate($from, $to, $txt)
    {
        $txt = urlencode($txt);
        $url = 'https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate?Text=%27'.$txt.'%27&From=%27'.$from.'%27&To=%27'.$to.'%27';
        
        $resultado = self::requestCurl($url);
        
        // Trabalhando no XML do retorno
        $xml = simplexml_load_string($resultado);
        $traducao = $xml->entry->content->children('m', TRUE)->properties->children('d', TRUE)->Text;
        
        return $traducao[0];
    }
    
    /**
     *  Para ver a lista completa dos códigos das linguagens, acesse
     *  http://msdn.microsoft.com/en-us/library/hh456380.aspx
     * 
     *  @return Array com todas as linguagens disponíveis para tradução
     */
    public static function getLanguages()
    {
        $linguagens = array();
        $url = "https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/GetLanguagesForTranslation";
        
        $resultado = self::requestCurl($url);
        
        $xml = simplexml_load_string($resultado);
        foreach ($xml->entry as $key => $codigo) {
            $code = $codigo->content->children('m', TRUE)->properties->children('d', TRUE)->Code;
            $linguagens[] = $code[0];
        }
        
        return $linguagens;
    }
    
    /**
     * 
     * @param type string $txt Texto que terá a linguagem detectada pela API
     * @return Código da linguagem em que está o texto passado
     */
    public static function detectLanguage($txt)
    {
        $txt = urlencode($txt);
        $url = "https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Detect?Text=%27".$txt."%27";
        
        $resultado = self::requestCurl($url);
        
        // Trabalhando no XML do retorno
        $xml = simplexml_load_string($resultado);
        $codigoLinguagem = $xml->entry->content->children('m', TRUE)->properties->children('d', TRUE)->Code;
        
        return $codigoLinguagem[0];
    }
    
    public static function requestCurl($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_USERPWD, self::$key.':'.self::$key);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $resultado = curl_exec($ch);
        curl_close($ch);
        
        return $resultado;
    }
}
