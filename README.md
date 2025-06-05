# API de Vagas

Uma API RESTful para gerenciamento de vagas de emprego e candidaturas, desenvolvida em PHP com MySQL.

## ✅ Status Atual

**API FUNCIONANDO CORRETAMENTE!**

- ✅ Todas as operações CRUD para vagas implementadas
- ✅ Sistema de candidaturas funcional
- ✅ Validação de dados corrigida
- ✅ Erros de referência PHP resolvidos
- ✅ Testes de POST/GET validados
- ✅ Interface de teste disponível

**Última atualização**: 05/06/2025 - Problemas de validação e referência PHP corrigidos

## 📋 Funcionalidades

- **Gerenciamento de Vagas**

  - Listar todas as vagas ativas
  - Buscar vaga por ID
  - Criar nova vaga
  - Atualizar vaga existente
  - Remover vaga (soft delete)

- **Sistema de Candidaturas**
  - Candidatar-se a uma vaga
  - Listar candidaturas por vaga
  - Listar todas as candidaturas
  - Prevenção de candidaturas duplicadas

## 🚀 Instalação e Configuração

### Pré-requisitos

- XAMPP (Apache + MySQL + PHP)
- PHP 7.4 ou superior
- MySQL 5.7 ou superior

### Passo a passo

1. **Clone ou copie os arquivos para a pasta do XAMPP**

   ```
   c:\xampp\htdocs\api-vagas\
   ```

2. **Inicie os serviços do XAMPP**

   - Apache
   - MySQL

3. **Crie o banco de dados**

   - Acesse o phpMyAdmin em `http://localhost/phpmyadmin`
   - Execute o script SQL em `database/schema.sql`

4. **Configure a conexão com o banco**
   - Verifique as configurações em `config/database.php`
   - Ajuste se necessário (usuário, senha, etc.)

## 📚 Endpoints da API

### Vagas

#### Listar todas as vagas

```http
GET http://localhost/api-vagas/vagas
```

#### Buscar vaga por ID

```http
GET http://localhost/api-vagas/vagas/{id}
```

#### Criar nova vaga

```http
POST http://localhost/api-vagas/vagas
Content-Type: application/json

{
    "titulo": "Desenvolvedor PHP",
    "descricao": "Desenvolvimento de aplicações web em PHP",
    "empresa": "Empresa XYZ",
    "localizacao": "São Paulo - SP",
    "salario": 7000.00,
    "tipo_contrato": "CLT",
    "requisitos": "PHP, MySQL, HTML, CSS, JavaScript",
    "beneficios": "Vale alimentação, Plano de saúde"
}
```

#### Atualizar vaga

```http
PUT http://localhost/api-vagas/vagas/{id}
Content-Type: application/json

{
    "titulo": "Desenvolvedor PHP Sênior",
    "descricao": "Desenvolvimento de aplicações web complexas em PHP",
    "empresa": "Empresa XYZ",
    "localizacao": "São Paulo - SP",
    "salario": 9000.00,
    "tipo_contrato": "CLT",
    "requisitos": "PHP avançado, MySQL, Laravel, Git",
    "beneficios": "Vale alimentação, Plano de saúde, Vale transporte"
}
```

#### Remover vaga

```http
DELETE http://localhost/api-vagas/vagas/{id}
```

### Candidaturas

#### Listar todas as candidaturas

```http
GET http://localhost/api-vagas/candidaturas
```

#### Listar candidaturas por vaga

```http
GET http://localhost/api-vagas/candidaturas/{vaga_id}
```

#### Candidatar-se a uma vaga

```http
POST http://localhost/api-vagas/candidaturas
Content-Type: application/json

{
    "vaga_id": 1,
    "nome_candidato": "João Silva",
    "email": "joao@email.com",
    "telefone": "(11) 99999-9999",
    "curriculo": "Experiência de 3 anos em desenvolvimento web..."
}
```

## 🗄️ Estrutura do Banco de Dados

### Tabela: vagas

- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `titulo` (VARCHAR(255), NOT NULL)
- `descricao` (TEXT, NOT NULL)
- `empresa` (VARCHAR(255), NOT NULL)
- `localizacao` (VARCHAR(255))
- `salario` (DECIMAL(10,2))
- `tipo_contrato` (ENUM: 'CLT', 'PJ', 'Estágio', 'Temporário', 'Freelance')
- `requisitos` (TEXT)
- `beneficios` (TEXT)
- `data_publicacao` (DATETIME, DEFAULT CURRENT_TIMESTAMP)
- `status` (ENUM: 'ativa', 'inativa', 'pausada', DEFAULT 'ativa')

### Tabela: candidaturas

- `id` (INT, PRIMARY KEY, AUTO_INCREMENT)
- `vaga_id` (INT, FOREIGN KEY)
- `nome_candidato` (VARCHAR(255), NOT NULL)
- `email` (VARCHAR(255), NOT NULL)
- `telefone` (VARCHAR(20))
- `curriculo` (TEXT)
- `data_candidatura` (DATETIME, DEFAULT CURRENT_TIMESTAMP)
- `status` (ENUM: 'pendente', 'em_analise', 'aprovado', 'rejeitado', DEFAULT 'pendente')

## 📁 Estrutura do Projeto

```
api-vagas/
├── index.php                  # Arquivo principal com roteamento
├── config/
│   └── database.php          # Configuração do banco de dados
├── classes/
│   ├── Vaga.php             # Classe para gerenciar vagas
│   └── Candidatura.php      # Classe para gerenciar candidaturas
├── database/
│   └── schema.sql           # Script SQL para criar o banco
└── README.md                # Documentação
```

## 🔧 Testando a API

Você pode testar a API usando ferramentas como:

- Postman
- Insomnia
- cURL
- Ou qualquer cliente HTTP

### Exemplo com cURL:

```bash
# Listar vagas
curl -X GET http://localhost/api-vagas/vagas

# Criar vaga
curl -X POST http://localhost/api-vagas/vagas \
  -H "Content-Type: application/json" \
  -d '{
    "titulo": "Desenvolvedor React",
    "descricao": "Desenvolvimento frontend com React",
    "empresa": "Tech Company"
  }'
```

## ⚠️ Validações Implementadas

- **Vagas**: Título, descrição e empresa são obrigatórios
- **Candidaturas**: Vaga ID, nome e email são obrigatórios
- **Duplicação**: Impede candidaturas duplicadas do mesmo email para a mesma vaga
- **Status**: Apenas vagas ativas aparecem na listagem pública

## 🛡️ Segurança

- Headers CORS configurados
- Validação de dados de entrada
- Prepared statements para prevenir SQL Injection
- Soft delete para vagas (não remove permanentemente)

## 📈 Possíveis Melhorias

- Autenticação e autorização
- Paginação nos endpoints de listagem
- Upload de arquivos para currículos
- Sistema de notificações por email
- Logs de auditoria
- Rate limiting
- Documentação com Swagger/OpenAPI
