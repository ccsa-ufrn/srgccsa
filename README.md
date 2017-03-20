# Sistema de Relatório de Gestão - CCSA
Plugin Wordpress para registro de atividades de gestão acadêmica da UFRN.

### Como instalar o plugin? ###
Você pode instalar através do serviço de plugins da wordpress.org, pelo link:
[https://wordpress.org/plugins/sistema-de-relatorio-de-gestao-ccsa/](https://wordpress.org/plugins/sistema-de-relatorio-de-gestao-ccsa/). Ou instalar manualmente.

Para instalar o SRGCCSA manualmente você deve seguir os seguintes passos:

* Copie o diretório **/sgrccsa** para o diretório **/wp-content/plugins/**
* Altere o arquivo **db_config.php** do diretório **/srgccsa/modules/rb** com as seguintes informações
```
define("SRG_DB_HOST", "Seu hospedeiro");
define("SRG_DB_NAME", "Nome do banco de dados");
define("SRG_DB_USER", "Usuário do banco de dados");
define("SRG_DB_PASS", "Senha do usuário");
```
* No painel de administração do Wordpress acesse o menu **Plugins** e clique em **Activate** no plugin **Sistema de Relatório de Gestão do CCSA (SRGCCSA)**

### Problemas com o plugin? ###
Entre em contato com o desenvolvedor

* me@mrmorais.com.br
