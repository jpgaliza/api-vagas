# API de Vagas

API para análise de candidaturas de emprego, desenvolvida para ajudar recrutadores a identificar as pessoas mais adequadas para cada vaga.

## Tecnologias Utilizadas

- PHP 7.4+
- Slim Framework 4.0
- MySQL
- Composer

## Instalação

### Pré-requisitos

- XAMPP (PHP 7.4+ e MySQL)
- Composer

### Passos para instalação

1. Clone o repositório:

```bash
git clone <url-do-repositorio>
cd api-vagas
```

2. Instale as dependências:

```bash
composer install
```

3. Configure o banco de dados:

   - Inicie o XAMPP
   - Abra o phpMyAdmin
   - Execute o script `database.sql` para criar o banco e as tabelas

4. Configure o servidor web:
   - Certifique-se de que o Apache está rodando no XAMPP
   - A API estará disponível em: `http://localhost/api-vagas/public`

## Estrutura do Projeto

```
api-vagas/
├── config/
│   └── database.php          # Configurações do banco
├── public/
│   ├── index.php            # Ponto de entrada da API
│   └── .htaccess            # Configuração do Apache
├── src/
│   ├── Controllers/         # Controllers da API
│   ├── Database/           # Conexão com banco
│   ├── Models/             # Modelos de dados
│   └── Utils/              # Utilitários (validação, cálculos)
├── database.sql            # Script de criação do banco
└── composer.json           # Dependências do projeto
```

## API Endpoints

### 1. Criar Vaga

- **URL**: `POST /vagas`
- **Content-Type**: `application/json`
- **Body**:

```json
{
  "id": "c70fc483-4805-409f-919b-0e593d3feed7",
  "empresa": "Teste",
  "titulo": "Vaga teste",
  "descricao": "Criar os mais diferentes tipos de teste",
  "localizacao": "A",
  "nivel": 3
}
```

- **Respostas**:
  - `201 Created`: Vaga criada com sucesso
  - `400 Bad Request`: JSON inválido
  - `422 Unprocessable Entity`: Dados inválidos

### 2. Criar Pessoa

- **URL**: `POST /pessoas`
- **Content-Type**: `application/json`
- **Body**:

```json
{
  "id": "d0f6d3c5-31b1-496d-b6a8-b45b30204366",
  "nome": "John Doe",
  "profissao": "Engenheiro de Software",
  "localizacao": "C",
  "nivel": 2
}
```

- **Respostas**:
  - `201 Created`: Pessoa criada com sucesso
  - `400 Bad Request`: JSON inválido
  - `422 Unprocessable Entity`: Dados inválidos

### 3. Criar Candidatura

- **URL**: `POST /candidaturas`
- **Content-Type**: `application/json`
- **Body**:

```json
{
  "id": "3ef0413f-f040-459a-9e22-3e8b471e6668",
  "id_vaga": "c70fc483-4805-409f-919b-0e593d3feed7",
  "id_pessoa": "d0f6d3c5-31b1-496d-b6a8-b45b30204366"
}
```

- **Respostas**:
  - `201 Created`: Candidatura criada com sucesso
  - `400 Bad Request`: JSON inválido ou candidatura duplicada
  - `404 Not Found`: Vaga ou pessoa não encontrada

### 4. Ranking de Candidatos

- **URL**: `GET /vagas/{id}/candidaturas/ranking`
- **Resposta**:

```json
[
  {
    "nome": "Mary Jane",
    "profissao": "Engenheira de Software",
    "localizacao": "A",
    "nivel": 4,
    "score": 87
  },
  {
    "nome": "John Doe",
    "profissao": "Engenheiro de Software",
    "localizacao": "C",
    "nivel": 2,
    "score": 62
  }
]
```

- **Respostas**:
  - `200 OK`: Lista de candidatos ordenada por score
  - `404 Not Found`: Vaga não encontrada ou sem candidatos

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

#### 2. Criar Primeira Pessoa (POST /pessoas)

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

#### 3. Criar Segunda Pessoa (POST /pessoas)

- **URL**: `http://localhost:8080/pessoas`
- **Method**: POST
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
  "id": "e1f7e4d6-42c2-5a7e-c7b9-b56c40305477",
  "nome": "Maria Santos",
  "profissao": "Desenvolvedora Senior",
  "localizacao": "A",
  "nivel": 4
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

#### 5. Criar Segunda Candidatura (POST /candidaturas)

- **URL**: `http://localhost:8080/candidaturas`
- **Method**: POST
- **Headers**: `Content-Type: application/json`
- **Body**:

```json
{
  "id": "4fg0524g-g151-570b-a033-4f9c582f7779",
  "id_vaga": "c70fc483-4805-409f-919b-0e593d3feed7",
  "id_pessoa": "e1f7e4d6-42c2-5a7e-c7b9-b56c40305477"
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
    "nome": "Maria Santos",
    "profissao": "Desenvolvedora Senior",
    "localizacao": "A",
    "nivel": 4,
    "score": 87
  },
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

2. **Maria Santos** (nível 4, localização A):
   - N = 100 - 25 × |3-4| = 75
   - Distância A→A = 0, então D = 100
   - Score = (75 + 100) / 2 = 87

## Estrutura de Commits

O projeto possui 5 commits conforme solicitado:

1. Estrutura inicial do projeto e configuração do banco de dados
2. Endpoint POST /pessoas - Receber Pessoas implementado
3. Endpoint POST /candidaturas - Receber Candidaturas implementado
4. Endpoint GET /vagas/{id}/candidaturas/ranking - Ranking de candidatos implementado
5. Documentação e instruções finais do projeto

## Autor

Desenvolvido seguindo as especificações técnicas fornecidas.
