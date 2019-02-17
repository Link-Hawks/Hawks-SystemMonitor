# Hawks-SystemMonitor
Sistema de monitoramento por comandos shell. 
Este sistema também pode ser utilizado em conjunto aos executaveis de check do Nagios.

Por utilizar comandos do sistema diretamento do servidor, por questões de segurança esse sistema DEVE utilizar autenticação para poder acessar qualquer serviço. Desta forma o header das páginas está definido como Basic Authentication e as senhas criptografadas com chave MD5. O usuário e senha padrão estão respectivamente como: hawks, 123.

Neste sistema você só precisa definir no array de servicos a chave sendo o nome do serviço e o valor como o comando a ser executado.
No array de Hosts é preciso definir como chave o nome do servidor e como valor o ip do servidor.

Todos os serviços utilizam ajax, para acessar as respostas de forma assíncrona e atualizar o status dos serviços a cada 3 minutos(180000 milissegundos) fazendo uma nova requisição. 

Na apresentação será distribuido em divs os status dos comandos e nomes para cada servidor. O posicionamento destas divs se dará inicialmente de forma horizontal e sequencial, porém as posições podem ser alteradas ao arrastar a div com o mouse. A posição sera salva como um json e armazenada no LocalStorage do navegador, dessa forma persistindo a posição customizada. 

O sistema de busca utiliza uma RegExp para verificar a expressão, e mostra os resultados que passarem pela RegExp e esconde os que não passaram. Caso nada esteja escrito, todos são mostrados.

