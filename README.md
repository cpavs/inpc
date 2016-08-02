
# Scraper INPC

Obtiene los inpc en un rango de años desde la pagina de gobierno.

## Instalacion por composer

```
composer require cpavs/inpc
```

## Ejemplo de uso

```
require "vendor/autoload.php";

use Cpavs\Scraping\Inpc;

$inpcs = (new Inpc)
->setYears(range(2000,2010))
->execute()
->get();

foreach($inpcs as $ejercicio => $values)
{
    foreach($values as $mes => $inpc)
    {
        $ejercicio //$ejercicio
        $mes //mes
        $inpc //inpc
    }
}

```