# Desafio FIAP

## Tecnologias Utilizadas

* **Frontend**: [![Node.js](https://img.shields.io/badge/Node.js-22-53A244)](https://nodejs.org/pt/download) [![Node.js](https://img.shields.io/badge/Angular-20-AF3BFB)](https://angular.dev/overview)
* **Backend**: [![PHP](https://img.shields.io/badge/PHP-8.4-4E5B93)](https://www.php.net/downloads.php?version=8.4)
* **Banco de Dados**: [![MySQL](https://img.shields.io/badge/MySQL-8.4-0174A3)](https://dev.mysql.com/downloads/mysql/)
* **Orquestração**: [![Docker](https://img.shields.io/badge/Docker-0C49C2)](https://www.docker.com/get-started) [![Docker](https://img.shields.io/badge/Docker%20Compose-0C49C2)](https://docs.docker.com/compose/install/)

## Estrutura dos Serviços

* `frontend`: Aplicação Angular, acessível na porta `4200`.
* `backend`: API em PHP, acessível na porta `8080`.
* `db`: Servidor de banco de dados MySQL, acessível na porta `3306`.

---

## 🚀 Como Rodar o Projeto com Docker (Recomendado)

Siga os passos abaixo para executar toda a aplicação de forma simples e rápida.

### Pré-requisitos

* [Docker](https://www.docker.com/get-started) instalado.
* [Docker Compose](https://docs.docker.com/compose/install/) instalado.

### Passos para Execução

1.  **Clone o Repositório**
    ```bash
    git clone https://github.com/samirzedan/desafio-fiap.git
    cd desafio-fiap
    ```

2.  **Crie o Arquivo de Variáveis de Ambiente do Docker**
    Crie um arquivo chamado `.env` na raiz do projeto e adicione as seguintes variáveis. Substitua os valores após o `=` pelas suas credenciais desejadas.

    ```env
    # Variáveis do Banco de Dados MySQL
    MYSQL_DATABASE=db_fiap
    MYSQL_PORT=3306
    MYSQL_USER=fiap_user
    MYSQL_PASSWORD=fiap123
    MYSQL_ROOT_PASSWORD=root123
    ```

3.  **Crie o Arquivo de Variáveis de Ambiente da API PHP**
    Crie outro arquivo chamado `.env` dentro da pasta `backend` na raiz do projeto e adicione a seguinte variável. Substitua os valores após o `=` pelas suas credenciais desejadas.

    ```env
    # JWT
    JWT_SECRET=123
    ```

    ou (caso esteja rodando [sem Docker](#como-rodar-o-projeto-manualmente-sem-docker))
    ```env
    # Database
    DB_HOST=localhost
    DB_PORT=3306
    DB_DATABASE=db_fiap
    DB_USERNAME=fiap_user
    DB_PASSWORD=fiap123

    # JWT
    JWT_SECRET=123
    ```

    **Instalando Dependências**
    Ainda dentro da pasta `backend`, instale as dependências com o seguinte comando:

    ```bash
    composer install
    ```

4.  **Suba os Contêineres**
    Volte à raiz do projeto e execute o comando abaixo. O parâmetro `--build` garante que as imagens serão construídas a partir dos Dockerfiles, e o `-d` executa os contêineres em segundo plano.

    ```bash
    docker compose up -d --build
    ```

4.  **Acesse a Aplicação**
    Após a conclusão do comando, os serviços estarão disponíveis nos seguintes endereços:
    * **Frontend**: [http://localhost:4200](http://localhost:4200)
    * **Backend**: [http://localhost:8080](http://localhost:8080)
    * **Banco de Dados**: Conecte-se via `localhost:3306` com o seu cliente de banco de dados preferido.

### Comandos Úteis do Docker

* **Parar os contêineres**: `docker compose down`

---

## Como Rodar o Projeto Manualmente (Sem Docker)

Este método requer a instalação manual de todas as dependências no seu ambiente local.

### Pré-requisitos

* [Node.js v22 (LTS)](https://nodejs.org/pt/download)
* [PHP 8.4](https://www.php.net/downloads.php?version=8.4)
* Servidor Web com suporte a PHP ([Apache](https://httpd.apache.org/))
* [MySQL Server 8.4](https://dev.mysql.com/downloads/mysql/)

### 1. Configuração do Banco de Dados

1.  Instale e inicie o servidor MySQL na sua máquina.
2.  Acesse o cliente MySQL e crie o banco de dados e o usuário.

### 2. Clone o Repositório
Passo 1 de [Passos para Execução](#Passos-para-Execução) (Clone o Repositório)

### 3. Configuração do Backend (PHP)

1.  Certifique-se de que a extensão `pdo_mysql` do PHP está habilitada.
2.  Configure o seu servidor Apache para usar o diretório `backend` como `DocumentRoot` e porta `8080`.
3.  Navegue até a pasta `backend`.
4.  Passo 3 de [Passos para Execução](#Passos-para-Execução) (Crie o Arquivo de Variáveis de Ambiente da API PHP)
5.  Inicie o servidor Apache.

### 4. Configuração do Frontend (Angular)

1.  Abra um terminal e navegue até a pasta `frontend`.
2.  Instale as dependências do projeto:
    ```bash
    npm install
    ```
3.  Execute a aplicação:
    ```bash
    npm start
    ```

4.  **Acesse a Aplicação**
    Após a conclusão do comando, os serviços estarão disponíveis nos seguintes endereços:
    * **Frontend**: [http://localhost:4200](http://localhost:4200)
    * **Backend**: [http://localhost:8080](http://localhost:8080)
    * **Banco de Dados**: Conecte-se via `localhost:3306` com o seu cliente de banco de dados preferido.
