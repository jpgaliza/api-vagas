# API de Vagas - Guia de Uso Atualizado

## 🚀 Como Testar a API

### 1. Primeiro, teste a conexão com o banco de dados:

```
http://localhost/api-vagas/test-db.php
```

### 2. Teste básico da API:

```
http://localhost/api-vagas/test.php
```

### 3. **URLs CORRETAS para usar:**

#### **Vagas** - Use: `vagas.php`

- **Listar todas as vagas:**

  ```
  GET http://localhost/api-vagas/vagas.php
  ```

- **Buscar vaga por ID:**

  ```
  GET http://localhost/api-vagas/vagas.php?id=1
  ```

- **Criar nova vaga:**

  ```
  POST http://localhost/api-vagas/vagas.php
  Content-Type: application/json

  {
      "titulo": "Desenvolvedor PHP",
      "descricao": "Desenvolvimento de aplicações web em PHP",
      "empresa": "Empresa XYZ"
  }
  ```

- **Atualizar vaga:**

  ```
  PUT http://localhost/api-vagas/vagas.php?id=1
  Content-Type: application/json

  {
      "titulo": "Desenvolvedor PHP Sênior",
      "descricao": "Desenvolvimento avançado em PHP",
      "empresa": "Empresa XYZ"
  }
  ```

- **Deletar vaga:**
  ```
  DELETE http://localhost/api-vagas/vagas.php?id=1
  ```

#### **Candidaturas** - Use: `candidaturas.php`

- **Listar todas as candidaturas:**

  ```
  GET http://localhost/api-vagas/candidaturas.php
  ```

- **Candidatar-se a uma vaga:**

  ```
  POST http://localhost/api-vagas/candidaturas.php
  Content-Type: application/json

  {
      "vaga_id": 4,
      "nome_candidato": "João Silva",
      "email": "joao@email.com",
      "telefone": "(11) 99999-9999",
      "curriculo": "Desenvolvedor Front-End com 2 anos de experiência"
  }
  ```

## 📋 Checklist para Configuração:

1. ✅ **XAMPP rodando** (Apache + MySQL)
2. ✅ **Banco criado** - Execute o SQL em `database/schema.sql`
3. ✅ **Teste conexão** - Acesse: `http://localhost/api-vagas/test-db.php`
4. ✅ **Teste API** - Acesse: `http://localhost/api-vagas/vagas.php`

## 🔧 Testando no Navegador:

1. **Teste simples:** `http://localhost/api-vagas/vagas.php`
2. **Buscar vaga:** `http://localhost/api-vagas/vagas.php?id=1`
3. **Teste conexão DB:** `http://localhost/api-vagas/test-db.php`

## 💡 Se ainda não funcionar:

1. Verifique se o Apache está rodando
2. Verifique se o MySQL está rodando
3. Execute o script SQL para criar o banco
4. Teste a conexão com `test-db.php`
