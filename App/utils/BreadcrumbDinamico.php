<?php

//array_filter
//Filtra elementos de um array utilizando uma função callback
//Itera sobre cada valor de array passando-os para a função callback. Se a função callback retornar true, o valor atual de array é retornado na array resultado. As chaves do array são preservadas.
//Retorna o array filtrado.

//explode
//Divide uma string em strings
//Retorna uma array de strings, cada uma como substring de string formada pela divisão dela a partir do delimiter. 

//'REQUEST_URI' : O URI fornecido para acessar a página atual, por exemplo, '/index.html'.

//parse_url
//Interpreta uma URL e retorna os seus componentes
//Esta função retorna uma matriz associativa retornando os vários componentes que estão presentes em uma url. Se um dos elementos não estiver presente, não será criada uma entrada para ele. Os valores dos elementos do array não são codificados.
//PHP_URL_PATH: para retornar um componente específico da URL como uma string, nesse caso o caminho

//'HTTPS' : Define para um valor não vazio se o script foi requisitado através do protocolo HTTPS.

//'HTTP_HOST' : O conteúdo do header Host: da requisição atual, se houver.

//end — Faz o ponteiro interno de um array apontar para o seu último elemento
//end() avança o ponteiro interno de array até o seu último elemento, e retorna-o.
//Retorna o valor do último elemento.

//array_keys — Retorna todas as chaves ou uma parte das chaves de um array
//Retorna um array de todas as chaves em array.

//ucwords — Converte para maiúsculas o primeiro caractere de cada palavra
//Retorna uma string com o primeiro caractere de cada palavra em str em maiúscula, se este caractere fizer parte do alfabeto.

//str_replace — Substitui todas as ocorrências da string de procura com a string de substituição
//Esta função retorna uma string ou um array com todas as ocorrências de search em subject substituídas com o valor dado para replace.
//Esta função retorna uma string ou um array com os valores modificados.
//search : O valor que está sendo pesquisado, também conhecido como agulha . Uma matriz pode ser usada para designar várias agulhas.
//replace: O valor de substituição que substitui os search valores encontrados . Uma matriz pode ser usada para designar várias substituições.
//subject: A string ou matriz que está sendo pesquisada e substituída, também conhecida como palheiro . Se subjectfor uma matriz, a pesquisa e a substituição serão realizadas com cada entrada de subjecte o valor de retorno também será uma matriz.

//implode — Junta elementos de uma array em uma string
//Retorna uma array contendo os elementos da array na mesma ordem com uma ligação entre cada elemento.

function breadcrumbs($separador = '&#47;', $home = 'Index') {
    //Isso obtém REQUEST_URI (/path/to/file.php), divide a string (usando '/') em uma array e, em seguida, filtra quaisquer valores vazios
    $caminho = array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));
    //construi a url base como: http://localhost/ 
    $base = /*($_SERVER['HTTPS'] ? 'https' :*/ 'http' . '://' . $_SERVER['HTTP_HOST'] . '/';
    //Inicializa um array temporário com nossos breadcrumbs. (começando com nossa página inicial, que presumo que seja o URL base)
    $breadcrumbs = array("<a href=\"$base\">$home</a>");
    //Inicializar migalhas para rastrear o caminho para o link adequado
    $crumbs = '';
    //descubra o indice para o último valor em nossa array caminho
    $ultimo = end(array_keys($caminho));
    //constroi o resto das migalhas de pão
    foreach($caminho as $x => $crumb) {
        //Nosso "título é o texto que será exibido (retire .php e transforme '_' em um espaço);
        $titulo =  ucwords(str_replace(array('.php', '_', '%20'), array('', ' ', ' '), $crumb));  
        //se não estivermos no último índice, eibir uma tag <a>
        if($x != $ultimo) {
            $breadcrumbs[] = "<a href=\"$base$crumbs$crumb\">$titulo</a>";
            $crumbs = $crumbs . '/';
        }//Caso contrário, apenas exiba o título (menos)
        else{
            $breadcrumbs[] = $titulo;
        }
    }

    //construa noss array temporário(pedações de pão) em uma grande string:)
    return implode($separador, $breadcrumbs);
}

echo breadcrumbs();

?>