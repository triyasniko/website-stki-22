<?php 
    function stem($word){
        // include composer autoloader
        require_once __DIR__ . '/vendor/autoload.php';
        $stemmerFactory = new \Sastrawi\Stemmer\StemmerFactory();
        $dictionary = $stemmerFactory->createStemmer();
        $stemmed = $dictionary->stem($word);
        return $stemmed;
    }
?>