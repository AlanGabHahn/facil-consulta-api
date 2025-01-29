# API - Sistema de Gestão Médica

## 📌 Introdução

Esta API foi desenvolvida como parte de um teste técnico para a vaga de **Desenvolvedora Back-end Plena**. O objetivo é criar um sistema de gestão de médicos, pacientes e consultas, permitindo a listagem e manipulação de dados seguindo regras específicas.

---

## 🚀 Tecnologias Utilizadas

- **Laravel 11+**
- **Laravel Sail** (para ambiente Docker)
- **MySQL**
- **JWT (JSON Web Token)** para autenticação
- **Postman** (para testar os endpoints)

---

## 📎 Instalação e Configuração

### 🏰️ Passo 1: Clonar o repositório

```bash
git clone https://github.com/AlanGabHahn/facil-consulta-api.git
cd facil-consulta-api
```

## 🐋 Passo 2: Subir os containers com Laravel Sail

```bash
./vendor/bin/sail up -d
```

> Nota: Certifique-se de que o Docker está rodando antes de executar este comando.

### 🔧 Passo 3: Configurar o arquivo `.env`

Copie o arquivo `.env.example` e configure as variáveis de ambiente:

```bash
cp .env.example .env
```

Edite o `.env` e configure a conexão com o banco de dados:

```makefile
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=root
DB_PASSWORD=root
```

### 📦 Passo 4: Instalar as dependências

```bash
./vendor/bin/sail composer install
```

### 🛠️ Passo 5: Criar as tabelas e popular o banco de dados

```bash
./vendor/bin/sail artisan migrate --seed
```

Isso criará as tabelas e inserirá os dados iniciais para testes, incluindo um usuário padrão para autenticação.

---

## 🔑 Autenticação (JWT)

Para acessar rotas protegidas, é necessário autenticar-se primeiro.

### 📌 Usuário Padrão Criado pelo Seeder

Após rodar `migrate --seed`, o usuário abaixo estará disponível:

- **E-mail:** admin@email.com
- **Senha:** 123456

### 📌 Obter o Token de Autenticação

Faça uma requisição `POST` para `/api/auth/login` com os dados do usuário:

```json
{
  "email": "admin@email.com",
  "password": "123456"
}
```

#### Resposta esperada:

```json
{
  "token": "seu_token_aqui",
}
```

Utilize esse token para acessar as rotas protegidas, adicionando o cabeçalho:

```makefile
Authorization: Bearer seu_token_aqui
```

---

## 📡 Endpoints da API

### 📍 Cidades

| Método | Endpoint | Autenticação | Descrição |
|---------|----------|-----------------|-------------|
| GET | `/api/cidades` | ❌ Não | Lista todas as cidades cadastradas |
| GET | `/api/cidades?nome=São Paulo` | ❌ Não | Busca cidades por nome |

### 📍 Médicos

| Método | Endpoint | Autenticação | Descrição |
|---------|----------|-----------------|-------------|
| GET | `/api/medicos` | ❌ Não | Lista todos os médicos |
| GET | `/api/cidades/{id_cidade}/medicos` | ❌ Não | Lista médicos por cidade |
| POST | `/api/medicos` | ✅ Sim | Cadastra um médico |

#### Exemplo de `POST /api/medicos`

```json
{
  "nome": "Dra. Juliana Oliveira",
  "especialidade": "Cardiologia",
  "cidade_id": 1
}
```

### 📍 Consultas

| Método | Endpoint | Autenticação | Descrição |
|---------|----------|-----------------|-------------|
| POST | `/api/medicos/consulta` | ✅ Sim | Agenda uma nova consulta |

#### Exemplo de `POST /api/medicos/consulta`

```json
{
  "medico_id": 1,
  "paciente_id": 3,
  "data": "2025-02-01 10:00:00"
}
```

### 📍 Pacientes

| Método | Endpoint | Autenticação | Descrição |
|---------|----------|-----------------|-------------|
| GET | `/api/medicos/{id_medico}/pacientes` | ✅ Sim | Lista pacientes de um médico |
| POST | `/api/pacientes/{id_paciente}` | ✅ Sim | Atualiza nome e celular de um paciente |
| POST | `/api/pacientes` | ✅ Sim | Adiciona um novo paciente |

#### Exemplo de `POST /api/pacientes`

```json
{
  "nome": "Carlos Souza",
  "cpf": "12345678901",
  "celular": "(11) 99999-8888"
}
```

---

## 🛠️ Testando a API no Postman

- Importe a collection do Postman (disponível no repositório).
- Utilize os exemplos prontos para testar os endpoints.
- Gere um token de autenticação antes de testar rotas protegidas.

---

## 📚 Conclusão

Esta API fornece os recursos necessários para listar, cadastrar e gerenciar médicos, pacientes e consultas, utilizando autenticação JWT e um ambiente Dockerizado com Laravel Sail.

Caso tenha dúvidas ou precise de suporte, entre em contato. 🚀

