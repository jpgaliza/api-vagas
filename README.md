# API de Vagas - AVP2 Back-End

## 📚 Sobre o Projeto

Esta API foi desenvolvida como **Atividade de Verificação Prática 2 (AVP2)** da disciplina de **Back-End** da **Faculdade Paraíso - UniFAP**.

A API tem como objetivo analisar candidaturas de emprego e ajudar recrutadores a identificar as pessoas mais adequadas para cada vaga através de um sistema de pontuação baseado em critérios de localização e nível de experiência.


## 🚀 Tecnologias Utilizadas

- **PHP 8.2+**
- **Slim Framework 4.0**
- **MySQL**
- **Composer**
- **XAMPP** (Ambiente de desenvolvimento)

## 📋 Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

- **XAMPP** (versão 8.0 ou superior) - [Download aqui](https://www.apachefriends.org/download.html)
- **Composer** - [Download aqui](https://getcomposer.org/download/)
- **Git** (opcional, para clonar o repositório)
- **Postman** (para testar a API) - [Download aqui](https://www.postman.com/downloads/)

## 🔧 Instalação e Configuração

### Passo 1: Preparar o Ambiente

1. **Instale e inicie o XAMPP:**

   - Baixe e instale o XAMPP
   - Abra o XAMPP Control Panel
   - Inicie os serviços **Apache** e **MySQL**

2. **Instale o Composer:**
   - Baixe e instale o Composer globalmente
   - Verifique a instalação executando no terminal: `composer --version`

### Passo 2: Obter o Código

1. **Clone o repositório** (ou baixe o ZIP):

```bash
git clone <url-do-repositorio>
cd api-vagas
```

**OU**

1. **Baixe o projeto** e extraia na pasta `c:\xampp\htdocs\api-vagas`

### Passo 3: Instalar Dependências

1. **Abra o terminal** na pasta do projeto
2. **Execute o comando:**

```bash
composer install
```

### Passo 4: Configurar o Banco de Dados

1. **Abra o phpMyAdmin** em: http://localhost/phpmyadmin
2. **Execute o script de criação** do banco:
   - Copie todo o conteúdo do arquivo `database.sql`
   - Cole e execute no phpMyAdmin
   - Isso criará o banco `api_vagas` e todas as tabelas necessárias

**OU via linha de comando:**

```powershell
# No PowerShell, execute:
& "C:\xampp\mysql\bin\mysql.exe" -u root < "c:\xampp\htdocs\api-vagas\database.sql"
```

### Passo 5: Iniciar o Servidor Local

1. **Abra o terminal** na pasta do projeto
2. **Execute o comando:**

```bash
php -S localhost:8000 -t public
```

3. **Confirme que o servidor está rodando:**
   - Você deve ver a mensagem: `PHP 8.x.x Development Server (http://localhost:8000) started`
   - A API estará disponível em: `http://localhost:8000`

## 🧪 Como Testar a API com Postman

### Passo 1: Importar a Collection

1. **Abra o Postman**
2. **Clique em "Import"** (botão no canto superior esquerdo)
3. **Selecione "Upload Files"**
4. **Escolha o arquivo** `postman_collection.json` na raiz do projeto
5. **Clique "Import"**
6. A collection **"API de Vagas - Teste Completo"** aparecerá na sua sidebar

### Passo 2: Executar os Testes

A collection contém **10 requisições** organizadas na sequência correta:

#### ✅ Testes de Criação (Devem retornar Status 201)

1. **Criar Vaga FAP** - Cria uma vaga de "Analista de Dados" na UniFAP
2. **Criar Davi** - Pessoa com nível 1, localização D
3. **Criar Nycolas** - Pessoa com nível 4, localização A
4. **Criar João Pedro** - Pessoa com nível 3, localização B
5. **Criar Candidatura Davi** - Candidatura do Davi para a vaga
6. **Criar Candidatura Nycolas** - Candidatura do Nycolas para a vaga
7. **Criar Candidatura João Pedro** - Candidatura do João Pedro para a vaga

#### 📊 Teste de Funcionalidade

8. **Ver Ranking de Candidaturas UniFAP** - Retorna o ranking ordenado por score

#### ❌ Testes de Validação (Devem retornar Status 422)

9. **Teste - Criar Vaga sem ID** - Deve falhar (validação funcionando)
10. **Teste - Criar Pessoa sem ID** - Deve falhar (validação funcionando)

### Passo 3: Executar Sequencialmente

⚠️ **IMPORTANTE:** Execute as requisições **NA ORDEM** para que os testes funcionem corretamente.

1. **Execute uma por vez** clicando no botão "Send"
2. **Verifique o status code** de cada resposta
3. **Para o ranking** (requisição 8), você verá um JSON com os candidatos ordenados por score

### Exemplo de Resposta do Ranking:

```json
[
  {
    "nome": "João Pedro Galiza",
    "profissao": "Analista de Dados",
    "localizacao": "B",
    "nivel": 3,
    "score": 100
  },
  {
    "nome": "Nycolas de Oliveira",
    "profissao": "Tech Lead",
    "localizacao": "A",
    "nivel": 4,
    "score": 87
  },
  {
    "nome": "Davi Reinaldo",
    "profissao": "Analista de Dados",
    "localizacao": "D",
    "nivel": 1,
    "score": 75
  }
]
```

## 🔄 Limpeza do Banco para Novos Testes

Se quiser executar os testes novamente, limpe o banco antes:

```powershell
# Execute no PowerShell:
& "C:\xampp\mysql\bin\mysql.exe" -u root -e "USE api_vagas; SET FOREIGN_KEY_CHECKS = 0; TRUNCATE TABLE candidaturas; TRUNCATE TABLE vagas; TRUNCATE TABLE pessoas; SET FOREIGN_KEY_CHECKS = 1;"
```

## 🏗️ Estrutura do Projeto

```
api-vagas/                          # 📁 Raiz do projeto
├── 📄 composer.json                # Dependências do projeto
├── 📄 composer.lock                # Lock das versões das dependências
├── 📄 database.sql                 # Script de criação do banco de dados
├── 📄 postman_collection.json      # Collection para testes no Postman
├── 📄 README.md                    # Este arquivo de documentação
├── 📁 config/
│   └── 📄 database.php             # Configurações de conexão com o banco
├── 📁 public/
│   ├── 📄 index.php                # Ponto de entrada da API (Front Controller)
│   └── 📄 .htaccess                # Configuração do Apache para URL amigáveis
├── 📁 src/                         # Código-fonte da aplicação
│   ├── 📁 Controllers/             # Controllers da API (MVC)
│   │   ├── 📄 VagaController.php        # Gerencia endpoints de vagas
│   │   ├── 📄 PessoaController.php      # Gerencia endpoints de pessoas
│   │   └── 📄 CandidaturaController.php # Gerencia endpoints de candidaturas
│   ├── 📁 Database/                # Camada de acesso ao banco
│   │   └── 📄 Database.php              # Singleton para conexão MySQL
│   ├── 📁 Models/                  # Models da aplicação (MVC)
│   │   ├── 📄 Vaga.php                  # Model para entidade Vaga
│   │   ├── 📄 Pessoa.php                # Model para entidade Pessoa
│   │   └── 📄 Candidatura.php           # Model para entidade Candidatura
│   └── 📁 Utils/                   # Utilitários e helpers
│       ├── 📄 Validator.php             # Validações (UUID, nível, localização)
│       └── 📄 ScoreCalculator.php       # Algoritmo de cálculo de pontuação
└── 📁 vendor/                      # Dependências do Composer (auto-gerada)
    └── 📄 autoload.php             # Autoloader do Composer
```

### 🎯 Padrões de Design Implementados

- **🔄 Singleton**: Classe `Database` para gerenciar conexão única com MySQL
- **🏛️ MVC**: Separação clara entre Models, Views (JSON) e Controllers
- **📦 Repository Pattern**: Models encapsulam lógica de acesso aos dados
- **🛡️ Validator Pattern**: Validações centralizadas na classe `Validator`
- **🧮 Strategy Pattern**: `ScoreCalculator` para algoritmos de pontuação

## 📡 Endpoints da API

### Base URL

```
http://localhost:8000
```

### 1. 📝 Criar Vaga

- **Método**: `POST`
- **URL**: `/vagas`
- **Content-Type**: `application/json`
- **Descrição**: Cria uma nova vaga de emprego

**Body da Requisição:**

```json
{
  "id": "c70fc483-4805-409f-919b-0e593d3feed7",
  "empresa": "UniFAP",
  "titulo": "Analista de Dados",
  "descricao": "Gerenciar os dados dos alunos da Faculdade",
  "localizacao": "B",
  "nivel": 2
}
```

**Respostas:**

- ✅ `201 Created`: Vaga criada com sucesso (sem body)
- ❌ `400 Bad Request`: JSON malformado
- ❌ `422 Unprocessable Entity`: Dados inválidos (ID duplicado, campos obrigatórios, etc.)

### 2. 👤 Criar Pessoa

- **Método**: `POST`
- **URL**: `/pessoas`
- **Content-Type**: `application/json`
- **Descrição**: Cadastra uma nova pessoa candidata

**Body da Requisição:**

```json
{
  "id": "d0f6d3c5-31b1-496d-b6a8-b45b30204366",
  "nome": "João Pedro Galiza",
  "profissao": "Analista de Dados",
  "localizacao": "B",
  "nivel": 3
}
```

**Respostas:**

- ✅ `201 Created`: Pessoa criada com sucesso (sem body)
- ❌ `400 Bad Request`: JSON malformado
- ❌ `422 Unprocessable Entity`: Dados inválidos

### 3. 🤝 Criar Candidatura

- **Método**: `POST`
- **URL**: `/candidaturas`
- **Content-Type**: `application/json`
- **Descrição**: Registra candidatura de uma pessoa para uma vaga

**Body da Requisição:**

```json
{
  "id": "3ef0413f-f040-459a-9e22-3e8b471e6668",
  "id_vaga": "c70fc483-4805-409f-919b-0e593d3feed7",
  "id_pessoa": "d0f6d3c5-31b1-496d-b6a8-b45b30204366"
}
```

**Respostas:**

- ✅ `201 Created`: Candidatura criada com sucesso (sem body)
- ❌ `400 Bad Request`: JSON malformado ou candidatura duplicada
- ❌ `404 Not Found`: Vaga ou pessoa não encontrada

### 4. 🏆 Ranking de Candidatos

- **Método**: `GET`
- **URL**: `/vagas/{id}/candidaturas/ranking`
- **Descrição**: Retorna ranking dos candidatos ordenado por score (maior para menor)

**Exemplo de URL:**

```
GET /vagas/c70fc483-4805-409f-919b-0e593d3feed7/candidaturas/ranking
```

**Resposta de Sucesso (200 OK):**

```json
[
  {
    "nome": "João Pedro Galiza",
    "profissao": "Analista de Dados",
    "localizacao": "B",
    "nivel": 3,
    "score": 100
  },
  {
    "nome": "Nycolas de Oliveira",
    "profissao": "Tech Lead",
    "localizacao": "A",
    "nivel": 4,
    "score": 87
  }
]
```

**Respostas:**

- ✅ `200 OK`: Lista de candidatos ordenada por score
- ❌ `404 Not Found`: Vaga não encontrada ou sem candidatos

## Especificações Técnicas

### Níveis de Experiência

- 1: Estagiário
- 2: Júnior
- 3: Pleno
- 4: Sênior
- 5: Especialista

### Localidades

Representadas pelas letras A, B, C, D, E, F com as seguintes distâncias:

- A ↔ B: 5
- B ↔ C: 5
- C ↔ D: 5
- D ↔ E: 5
- E ↔ F: 5

### Cálculo de Score

O score é calculado pela fórmula: `SCORE = (N + D) / 2`

Onde:

- `N = 100 - 25 × |NV - NC|`
  - NV = nível da vaga
  - NC = nível do candidato
- `D` baseado na distância:
  - 0-5: D = 100
  - 5-10: D = 75
  - 10-15: D = 50
  - 15-20: D = 25
  - > 20: D = 0

## Validações

- Todos os IDs devem seguir o padrão UUID
- Níveis devem estar entre 1 e 5
- Localizações devem ser A, B, C, D, E ou F
- Não é permitida duplicação de candidaturas
- Campos obrigatórios devem estar preenchidos

## Padrões de Design Utilizados

- **Singleton**: Para conexão com banco de dados
- **MVC**: Separação entre Models, Views e Controllers
- **Repository Pattern**: Encapsulamento da lógica de acesso aos dados

## Como Testar no Postman

### Pré-requisitos para Teste

1. Certifique-se de que o XAMPP está rodando (Apache e MySQL)
2. O banco de dados foi criado conforme instruções acima
3. Inicie o servidor PHP: `php -S localhost:8080` na pasta `public`

### Importar Collection no Postman

1. Abra o Postman
2. Clique em "Import"
3. Selecione o arquivo `postman_collection.json` na raiz do projeto
4. A collection "API de Vagas" será importada com todos os testes

### Sequência de Testes Recomendada

#### 1. Criar Vaga (POST /vagas)

- **URL**: `http://localhost:8080/vagas`
- **Method**: POST
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
  "id": "c70fc483-4805-409f-919b-0e593d3feed7",
  "empresa": "Teste Empresa",
  "titulo": "Desenvolvedor PHP",
  "descricao": "Desenvolvimento de APIs em PHP",
  "localizacao": "A",
  "nivel": 3
}
```

- **Resposta Esperada**: `201 Created`

#### 2. Criar Pessoa (POST /pessoas)

- **URL**: `http://localhost:8080/pessoas`
- **Method**: POST
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
  "id": "d0f6d3c5-31b1-496d-b6a8-b45b30204366",
  "nome": "João Silva",
  "profissao": "Desenvolvedor PHP",
  "localizacao": "C",
  "nivel": 2
}
```

- **Resposta Esperada**: `201 Created`


#### 4. Criar Primeira Candidatura (POST /candidaturas)

- **URL**: `http://localhost:8080/candidaturas`
- **Method**: POST
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
  "id": "3ef0413f-f040-459a-9e22-3e8b471e6668",
  "id_vaga": "c70fc483-4805-409f-919b-0e593d3feed7",
  "id_pessoa": "d0f6d3c5-31b1-496d-b6a8-b45b30204366"
}
```

- **Resposta Esperada**: `201 Created`


#### 6. Ver Ranking de Candidatos (GET /vagas/{id}/candidaturas/ranking)

- **URL**: `http://localhost:8080/vagas/c70fc483-4805-409f-919b-0e593d3feed7/candidaturas/ranking`
- **Method**: GET
- **Resposta Esperada**: `200 OK` com JSON:

```json
[
  {
    "nome": "João Silva",
    "profissao": "Desenvolvedor PHP",
    "localizacao": "C",
    "nivel": 2,
    "score": 62
  }
]
```

### Testes de Validação

#### Teste de Vaga Inválida

- Envie uma vaga sem campo obrigatório
- **Resposta Esperada**: `422 Unprocessable Entity`

#### Teste de JSON Inválido

- Envie um JSON malformado
- **Resposta Esperada**: `400 Bad Request`

#### Teste de Candidatura Duplicada

- Tente criar a mesma candidatura duas vezes
- **Resposta Esperada**: `400 Bad Request`

#### Teste de Vaga Inexistente no Ranking

- Acesse ranking de vaga que não existe
- **Resposta Esperada**: `404 Not Found`

### Cálculo do Score Explicado

Para a vaga (nível 3, localização A) e candidatos:

1. **João Silva** (nível 2, localização C):

   - N = 100 - 25 × |3-2| = 75
   - Distância A→C = 10, então D = 75
   - Score = (75 + 75) / 2 = 75


## Autores

- [**João Pedro**](https://github.com/jpgaliza)
- [**Nycolas**](https://github.com/Nycolasfap)
- [**Theo Natan**](https://github.com/theonatangoes)
- [**Davi Reinaldo**](https://github.com/davireinaldo)

  Desenvolvido seguindo as especificações técnicas fornecidas pelo Professor da Disciplina.
