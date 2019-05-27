<!-- Alan Alencar, 2019 -->
<!doctype html>
<html lang="pt-br">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="Página que lê um arquivo jSon em disco e exibe informações consultadas em IP-Api.">
    <meta name="keywords" content="HTML, PHP, CSS, jSON">
    <meta name="author" content="Alan Alencar">

    <link rel="stylesheet" type="text/css" href="ipStyle.css" media="screen" />

    <title>Reading jSON File</title>
  </head>
  <body>
    <h1>Open: ips.json on disk.</h1>

    <!-- PHP Code for load file on disk -->
    <?php
        // Constants.
        const _RESULT_FORMAT_IP = "<p><spam class='destaque'>IP:</spam> %s | <spam class='destaque'>Country:</spam> %s | <spam class='destaque'>Region:</spam> %s | <spam class='destaque'>City:</spam> %s <spam class='destaque'>RegionName:</spam> %s</p>";
        /*
         * load file.
         */
        $jSONFile = file_get_contents("ips.json");
        $ipsObj = json_decode($jSONFile);
    ?>

    <!-- Vertical nav com a lista de IPs a pesquisar. -->
    <nav> 
        <h3>Lista de IPs:</h3>
        <ul>
            <?php 
                /*
                 * list IPs.
                 */
                foreach($ipsObj->ips as $listIPs) {
                    echo '<li>' . $listIPs->ip . '</li>';
                }
            ?>
        </ul>
    </nav>

    <!-- Efetuar a busca de informações usando a API do IP-Api. -->
    <section>
        <h3>Informações do IP:</h3>
        <?php 
            /*
             * Efetuar a busca de informações dos IPs com a IP-API. 
             */
            foreach($ipsObj->ips as $listIPs) {
                $content = file_get_contents('http://ip-api.com/json/'.$listIPs->ip.'?fields=country,region,regionName,city');
                $jSonObj = json_decode($content);
                if (json_last_error() != 0) {
                    printf("<p>Error: %s</p>",json_last_error());
                } else {
                    printf(_RESULT_FORMAT_IP,$listIPs->ip,
                                             $jSonObj->country,
                                             $jSonObj->region,
                                             $jSonObj->city,
                                             $jSonObj->regionName);
                }
            }
        ?>
    </section>

    <footer>
        Alan Alencar, 2019 - Stay hungry, stay foolish
    </footer>

  </body>
</html>
