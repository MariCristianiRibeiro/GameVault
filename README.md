# GameVault

Sua biblioteca pessoal de jogos em um só lugar.

## O que é GameVault?

GameVault é uma aplicação web para você organizar, acompanhar e gerenciar sua coleção de jogos de forma fácil e intuitiva. Se você é gamer e quer ter um controle melhor sobre seus títulos, plataformas e progresso — esse é o projeto certo para você.

## Funcionalidades principais

- **Cadastro e Gerenciamento de Jogos**: Adicione seus jogos favoritos com título, gênero, plataforma e desenvolvedora
- **Organização por Status**: Controle quais jogos você está jogando, quer jogar (backlog) ou já finalizou
- **Filtros e Busca**: Encontre rapidamente qualquer jogo na sua coleção usando filtros inteligentes
- **Categorias**: Organize seus jogos por:
  - **Gênero** (RPG, Ação, Puzzle, etc.)
  - **Plataforma** (PC, PS5, Xbox, Nintendo, etc.)
  - **Desenvolvedora** (que estúdio criou o jogo)
- **Conta Pessoal**: Cada usuário tem sua própria biblioteca e dados protegidos
- **Interface Amigável**: Design moderno e responsivo para usar em qualquer dispositivo

## Tecnologias utilizadas

- **Backend**: Laravel 11 (framework PHP moderno)
- **Frontend**: Blade + Tailwind CSS (interface responsiva)
- **Banco de Dados**: SQLite (configurável para MySQL, PostgreSQL, etc.)
- **Build Tool**: Vite (bundler JavaScript rápido)

## Como começar

### Requisitos
- PHP 8.2+
- Composer
- Node.js + npm (ou yarn)

### Instalação

1. Clone o repositório:
```bash
git clone https://github.com/MariCristianiRibeiro/GameVault.git
cd GameVault
```

2. Instale as dependências PHP:
```bash
composer install
```

3. Copie o arquivo de configuração:
```bash
cp .env.example .env
```

4. Gere a chave da aplicação:
```bash
php artisan key:generate
```

5. Crie o banco de dados SQLite:
```bash
touch database/database.sqlite
```

6. Execute as migrações para criar as tabelas:
```bash
php artisan migrate
```

7. (Opcional) Popule com dados de teste:
```bash
php artisan db:seed
```

8. Instale as dependências frontend:
```bash
npm install
```

9. Inicie o servidor de desenvolvimento:
```bash
php artisan serve
```

10. Em outro terminal, compile os arquivos frontend:
```bash
npm run dev
```

11. Acesse a aplicação em: **http://127.0.0.1:8000**

## Estrutura do Projeto

```
GameVault/
├── app/
│   ├── Http/Controllers/        # Controladores da aplicação
│   └── Models/                  # Modelos (Jogo, Genero, Plataforma, etc.)
├── database/
│   ├── migrations/              # Definição das tabelas
│   ├── seeders/                 # Dados iniciais para teste
│   └── database.sqlite          # Arquivo do banco de dados
├── resources/
│   ├── views/                   # Templates Blade (HTML)
│   └── css/js/                  # Estilos e scripts
├── routes/
│   └── web.php                  # Definição das rotas
└── config/                      # Arquivos de configuração
```

## Como usar

1. **Crie uma conta** na página inicial (clique em "Criar conta")
2. **Faça login** com suas credenciais
3. **Acesse o dashboard** e comece a adicionar seus jogos
4. **Use os filtros** para encontrar rápido qualquer título
5. **Atualize o status** de seus jogos conforme progride

## Banco de Dados

Os dados estão salvos em `database/database.sqlite`. Para visualizar ou gerenciar:

- Use **DB Browser for SQLite** (aplicativo desktop) para explorar graficamente
- Use o comando `sqlite3 database/database.sqlite` no terminal
- Use **Adminer** (interface web dentro do Laravel) para gerenciar pelo navegador

## Licença

Este projeto está sob a licença MIT. Veja [LICENSE](LICENSE) para detalhes.
