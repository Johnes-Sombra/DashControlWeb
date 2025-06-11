# DashControlWeb

## Sobre o Projeto
DashControlWeb é um sistema de controle desenvolvido para gerenciar cooperativas de materiais recicláveis como a coletas de materiais recicláveis, cadastro de cooperados e cadastro de empresas parceiras. Ele oferece uma interface web para facilitar o gerenciamento e visualização dos dados.

## Como Executar o Projeto

### Pré-requisitos
- **XAMPP**: Certifique-se de ter o XAMPP instalado em seu computador. XAMPP é uma distribuição do Apache que inclui o servidor web Apache, o banco de dados MySQL, e intérpretes para scripts em PHP e Perl.

### Passos para Executar
1. **Inicie o XAMPP**: Abra o painel de controle do XAMPP e inicie o servidor Apache e MySQL.
2. **Copie o Projeto**: Coloque a pasta `DashControlWeb` dentro do diretório `htdocs` do XAMPP.
3. **Importe o Banco de Dados**: Use o phpMyAdmin para importar o arquivo `schema.sql` localizado na pasta `db` para criar as tabelas necessárias no MySQL.
4. **Acesse o Projeto**: Abra o navegador e acesse `http://localhost/DashControlWeb` para visualizar o sistema.

### Observações
- Certifique-se de que as configurações do banco de dados no arquivo `config/database.php` estão corretas para conectar ao MySQL.