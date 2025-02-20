# Banco de Dados - Estrutura de Tabelas

Este documento descreve a estrutura das tabelas que devem ser cadastradas no banco de dados.

## Tabelas

### 1. Tabela `usuarios`
Armazena informações dos usuários do sistema.

| Campo   | Tipo           | Restrições                                |
|---------|----------------|-------------------------------------------|
| id      | INT            | AUTO_INCREMENT, PRIMARY KEY               |
| nome    | VARCHAR(100)   | NOT NULL                                  |
| email   | VARCHAR(100)   | NOT NULL, UNIQUE                          |
| senha   | VARCHAR(255)   | NOT NULL                                  |
| perfil  | ENUM           | ('admin', 'editor') DEFAULT 'editor'      |

#### SQL para criação:
```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'editor') DEFAULT 'editor'
);
```

---

### 2. Tabela `grupos`
Armazena categorias ou grupos de produtos.

| Campo   | Tipo          | Restrições                   |
|---------|---------------|------------------------------|
| id      | INT           | AUTO_INCREMENT, PRIMARY KEY  |
| nome    | VARCHAR(100)  | NOT NULL                     |

#### SQL para criação:
```sql
CREATE TABLE grupos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);
```

---

### 3. Tabela `produtos`
Armazena informações dos produtos.

| Campo     | Tipo         | Restrições                          |
|-----------|--------------|-------------------------------------|
| id        | INT          | AUTO_INCREMENT, PRIMARY KEY         |
| nome      | VARCHAR(100) | NOT NULL                            |
| descricao | TEXT         |                                     |
| preco     | DECIMAL(10,2)| NOT NULL                            |
| grupo_id  | INT          | FOREIGN KEY REFERENCES grupos(id)   |

#### SQL para criação:
```sql
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    grupo_id INT,
    FOREIGN KEY (grupo_id) REFERENCES grupos(id)
);
```