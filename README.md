# Dash Control Web - Sistema de Gestão Coopsul

## Sobre o Projeto
O Dash Control Web é um sistema de gestão desenvolvido para a Cooperativa Coopsul, focado no controle de coletas, gestão de cooperados e empresas parceiras.

## Tecnologias Utilizadas

- PHP 7.4+
- MySQL 5.7+
- HTML5
- CSS3
- JavaScript (ES6+)

## Requisitos do Sistema

- Servidor Web (Apache/Nginx)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Extensões PHP necessárias:
  - PDO
  - PDO_MySQL
  - OpenSSL

## Instalação

1. Clone o repositório
2. Configure o banco de dados:
   ```bash
   mysql -u root -p < db/schema.sql
   ```

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