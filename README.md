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
  - >20: D = 0

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

## Autor

Desenvolvido seguindo as especificações técnicas fornecidas.
