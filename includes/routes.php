<?php 

$routes = array("example");


/**
 * As rotas do sistema devem ser definidas nesse arquivo.
 * Rotas possuem formato padrão, onde cada módulo definido mais acima conterá oito ações (index, list, show, new
 * create, edit, update e delete) padrões no sistema. Na definição de novas rotas, é possível remover as ações que não sejam
 * necessárias, assim como, definir novas ações.
 * Uma vez que a rota nõa esteja definida, o usuário será submetido à pagina 404(page not found).
 * 
 *  *** Novas Rotas ***
 * Cada módulo novo deve ser inserido, único e exclusivamente, na variável acima.
 * ex:
 * $routes = array('users','groups');
 * 
 * 
 *  *** Adicionando Acoes às Rotas ***
 * 
 * As ações poderam ser adicionadas de modo simples através de uma simples declaração ou por expressão regular.
 * Adicionando de modo simples, será criada apenas uma ação simples onde não há a possibilidade de pegar argumentos, por exemplo 
 * (id de algum cadastro).
 * 
 * $routes = array('users'=>array('add'=>'action'));
 * $routes = array('users'=>array('add'=> array('action','another_action')));
 * 
 * Nos exemplos acima, está exibindo os únicos modos suportados, quando se deseja criar uma ou mais ações atráves da key "add".
 * 
 * 
 * *** Removendo Acoes das Rotas ***
 * 
 * Acoes nao desejadas podem ser removidos para evitar a nao integridade do sistema. Essas acoes nao mapeadas serao ignoradas pelo sistema
 * e será enviado para o usuário a mensagem 404.
 * 
 * $routes = array('users'=>array('remove'=>'new'))
 * $routes = array('users'=>array('remove'=> array('new','create')))
 * 
 */