<?php
// specify the REST web service to interact with
$url = 'http://search.yahooapis.com/WebSearchService/V1/webSearch?appid=YahooDemo&query=sugarcrm';

// make the web services call; the results are returned in XML format
$resultsXml = file_get_contents($url);

// convert XML to a SimpleXML object
$xmlObject = simplexml_load_string($resultsXml);

// interate over the object to get the title of each search result
foreach ( $xmlObject->Result as $result )
    echo "{$result->Title}\n";
