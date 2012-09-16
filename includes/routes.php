<?php 

$route_apps = array(
                "dashboard",
                "dashboard/users",
                "session" => array( "remove" => array( "index", "new", "edit", "alter", "show" )),
                "modules",
                "modules/portfolios",
                "modules/portfolios:id/portfolio_images" ,
                "modules/employees",
                );


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
 * $route_apps = array('users','groups');
 * 
 *  *** Rotas Aninhadas ***
 * Módulos podem conter relação com outros módulos e por isso precisam passar a sua hierarquiedade na url, ou seja, o seu parentesco.
 * Dessa forma, voce pode relacionar um módulo pai com o seu filho na seguinte forma.
 * example/foo
 * isso quer dizer que o múdolo a ser acessado deve ser o foo, que por sua vez, se relaciona com example diretamente.
 * mais exemplos:
 * classroom/students, folder/files, device/resource
 * 
 * A definicao das rotas pode ser do tipo
 * example/foo
 * example:id/foo
 * example:id/foo/bar
 * example:id/foo:id/bar
 * 
 * As variávies da URL devem começar com ":", precisam ter nome único, excetuando o nome "id",
 * podem ser do tipo integer ou string e devem ser declaradas após passar o nome do controller ao qual ela pertece.
 * ex:
 * example:id(integer)/foo
 * example:name(string)/foo
 *
 * Quando a variável for do tipo integer, a declarção do tipo pode ser omitida.
 *
 * OBS!!
 * O controller mais à direita nao deve possir variáveis pois o sistema gera automaticamente.
 * 
 * 
 *  *** Adicionando Acoes às Rotas ***
 * 
 * As ações poderam ser adicionadas de modo simples através de uma simples declaração ou por expressão regular.
 * Adicionando de modo simples, será criada apenas uma ação simples onde não há a possibilidade de pegar argumentos, por exemplo 
 * (id de algum cadastro).
 * 
 * $route_apps = array('users'=>array('add'=>'action'));
 * $route_apps = array('users'=>array('add'=> array('action','another_action')));
 * 
 * Nos exemplos acima, está exibindo os únicos modos suportados, quando se deseja criar uma ou mais ações atráves da key "add".
 * 
 * 
 * *** Removendo Acoes das Rotas ***
 * 
 * Acoes nao desejadas podem ser removidos para evitar a nao integridade do sistema. Essas acoes nao mapeadas serao ignoradas pelo sistema
 * e será enviado para o usuário a mensagem 404.
 * 
 * $route_apps = array('users'=>array('remove'=>'new'))
 * $route_apps = array('users'=>array('remove'=> array('new','create')))
 * 
 */