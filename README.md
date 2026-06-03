# 🎮 GameVault - Seu Gerenciador Pessoal de Jogos

![Laravel](https://img.shields.io/badge/Laravel-12.5.0-%23FF2D20?logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2-%23777BB4?logo=php)
![Database](https://img.shields.io/badge/Database-SQLite-%23003B57?logo=sqlite)
![License](https://img.shields.io/badge/License-MIT-%23green)

## 📋 Descrição do Projeto

**GameVault** é uma aplicação web desenvolvida em **Laravel 12** que permite aos usuários gerenciar sua biblioteca pessoal de videogames. A plataforma funciona como um catálogo privado onde você pode registrar todos os jogos que possui, acompanhar o progresso de conclusão, organizar por categorias e manter informações detalhadas sobre cada título.

É perfeito para:
- 🎯 Colecionadores de games que querem organizar sua biblioteca
- 📊 Gamers que desejam rastrear o progresso e anotações pessoais
- 🗂️ Usuários que gostam de organizar games por plataforma, gênero e desenvolvedora
- 📸 Pessoas que querem armazenar capas de jogo com imagens locais ou URLs

---

## ✨ Funcionalidades Principais

### 👤 Autenticação e Segurança
- **Registro de Usuários**: Crie uma conta com email e senha
- **Login Seguro**: Acesso protegido à sua biblioteca pessoal
- **Dados Isolados**: Cada usuário vê apenas seus próprios jogos

### 🎮 Gerenciamento de Jogos
- **Cadastro Completo**: Registre títulos com informações detalhadas:
  - Título do jogo
  - Descrição pessoal
  - Status (Jogando, Finalizado, Backlog)
  - Data de lançamento
  - Horas jogadas
  - Nota/Avaliação (0-10)
  - Imagem de capa

- **Upload de Imagens**: Duas opções flexíveis:
  - 📁 Carregar arquivo local (JPEG, PNG, WebP, GIF - até 5MB)
  - 🔗 Informar URL de imagem remota
  - ✅ Pré-visualização em miniatura em tempo real

- **Edição e Remoção**: Atualize ou delete qualquer jogo do seu acervo

### 🗂️ Organização e Categorização
- **Plataformas**: Organize jogos por console/plataforma (PS5, Xbox, PC, Nintendo, etc.)
- **Gêneros**: Categorize por tipo (RPG, FPS, Adventure, Indie, etc.)
- **Desenvolvedoras**: Agrupe por estúdio criador

- **Gerenciamento de Categorias**: 
  - Crie, edite e delete plataformas, gêneros e desenvolvedoras
  - Interface simples e intuitiva

### 🔍 Busca e Filtros
- **Pesquisa por Título**: Busque jogos pelo nome
- **Filtros Avançados**:
  - Por status (Jogando, Finalizado, Backlog)
  - Por plataforma
  - Por gênero
  - Por desenvolvedora
- **Ordenação**: Organize resultados por data recente, alfabética, etc.

### 📊 Dashboard
- Visualização rápida da sua biblioteca
- Estatísticas da sua coleção
- Acesso rápido às funcionalidades principais

---

## 🛠️ Como Funciona

### Fluxo Principal do Usuário

1. **Registro/Login**
   ```
   Acesse o site → Crie conta ou realize login → Acesso à biblioteca
   ```

2. **Configuração Inicial**
   ```
   Menu Setup → Crie suas plataformas favoritas → Crie gêneros → Crie desenvolvedoras
   ```

3. **Adicionar Jogos**
   ```
   Novo Jogo → Preencha informações → Selecione/importe capa → Salve
   ```

4. **Gerenciar Biblioteca**
   ```
   Visualize → Pesquise → Filtre → Edite → Delete
   ```

### Estrutura de Dados

```
┌─────────────┐
│   Usuário   │
└──────┬──────┘
       │
       └─→ ┌──────────┐
           │  Jogos   │──→ Título, Descrição, Horas, Nota, Imagem
           └──────────┘
                │
        ┌───────┼───────┐
        │       │       │
    ┌───▼──┐ ┌──▼───┐ ┌─▼─────────────┐
    │Plataf│ │Gênero│ │Desenvolvedora │
    └──────┘ └──────┘ └───────────────┘
```

---

## 🚀 Requisitos Técnicos

### Para Executar Localmente
- **PHP**: 8.2 ou superior
- **Composer**: Para gerenciar dependências PHP
- **Node.js**: 16+ (para assets frontend)
- **SQLite** ou **MySQL**: Banco de dados (padrão: SQLite)
- **Git**: Para clonar o repositório

### Dependências Principais
- **Laravel 12**: Framework PHP moderno
- **Tailwind CSS**: Estilização responsiva
- **Alpine.js**: Interatividade frontend leve
- **Vite**: Build tool para assets

---

## 📦 Instalação e Uso

### 1. Clonar o Repositório
```bash
git clone https://github.com/Involute42/Projeto-GameVault.git
cd Projeto-GameVault
```

### 2. Instalar Dependências
```bash
# Instalar dependências PHP
composer install

# Instalar dependências Node.js
npm install
```

### 3. Configuração do Ambiente
```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4. Configurar Banco de Dados
```bash
# Executar migrações para criar tabelas
php artisan migrate

# (Opcional) Popular com dados de teste
php artisan db:seed
```

### 5. Criar Link de Armazenamento
```bash
# Para permitir acesso a uploads de imagens
php artisan storage:link
```

### 6. Iniciar Servidor de Desenvolvimento
```bash
# Terminal 1: Laravel Development Server
php artisan serve

# Terminal 2: Build assets (em outro terminal)
npm run dev
```

A aplicação estará disponível em: **http://127.0.0.1:8000**

---

## 📁 Estrutura do Projeto

```
GameVault/
├── app/
│   ├── Http/Controllers/          # Controllers principais
│   │   ├── JogoController.php      # Gerenciamento de jogos
│   │   ├── GeneroController.php    # Gerenciamento de gêneros
│   │   ├── PlataformaController.php # Gerenciamento de plataformas
│   │   └── ...
│   ├── Models/                     # Modelos de dados
│   │   ├── Jogo.php               # Model de jogos
│   │   ├── User.php               # Model de usuário
│   │   ├── Genero.php             # Model de gênero
│   │   ├── Plataforma.php         # Model de plataforma
│   │   └── Desenvolvedora.php     # Model de desenvolvedora
│   └── Providers/                  # Service providers
│
├── database/
│   ├── migrations/                 # Migrações do banco
│   │   ├── create_users_table
│   │   ├── create_plataformas_table
│   │   ├── create_generos_table
│   │   ├── create_desenvolvedoras_table
│   │   └── create_jogos_table
│   ├── factories/                  # Factories para testes
│   └── seeders/                    # Seeders para dados iniciais
│
├── resources/
│   ├── views/                      # Arquivos Blade (templates)
│   │   ├── jogos/                 # Views relacionadas a jogos
│   │   ├── generos/               # Views relacionadas a gêneros
│   │   ├── plataformas/           # Views relacionadas a plataformas
│   │   ├── desenvolvedoras/       # Views relacionadas a desenvolvedoras
│   │   ├── layouts/               # Layouts base
│   │   └── auth/                  # Views de autenticação
│   ├── css/                        # Estilos CSS/Tailwind
│   └── js/                         # JavaScript
│
├── routes/
│   ├── web.php                     # Rotas web protegidas
│   └── console.php                 # Comandos artisan
│
├── public/
│   └── storage/ → storage/app/public    # Link para uploads
│
├── storage/
│   ├── app/public/jogos/          # Imagens de capas uploaded
│   ├── framework/                  # Cache, sessions, views
│   └── logs/                       # Logs da aplicação
│
├── config/
│   ├── app.php                     # Configurações da app
│   ├── database.php                # Configurações do BD
│   └── ...
│
├── tests/                          # Testes automatizados
├── composer.json                   # Dependências PHP
├── package.json                    # Dependências Node.js
└── vite.config.js                  # Configuração do Vite
```

---

## 🎯 Use Cases Comuns

### Cenário 1: Novo Usuário Criando Primeira Biblioteca
```
1. Acessa e faz cadastro
2. Configura suas plataformas (PS5, Xbox, PC)
3. Adiciona alguns gêneros (RPG, FPS, Adventure)
4. Começa a adicionar seus jogos favoritos
5. Para cada jogo: preenche info, seleciona capa, salva
```

### Cenário 2: Rastreando Progresso
```
1. Cadastra jogo com status "Jogando"
2. Periodicamente edita e atualiza "Horas Jogadas"
3. Quando termina, muda status para "Finalizado"
4. Deixa uma nota/avaliação pessoal
```

### Cenário 3: Pesquisando Biblioteca
```
1. Usa filtro por plataforma (Ex: PS5)
2. Filtra por gênero (Ex: RPG)
3. Visualiza resultados
4. Clica em jogo para ver detalhes
```

---

## 🔐 Segurança

- **Autenticação Laravel**: Middleware protegido em todas rotas
- **Dados Isolados**: SQL query filtra by user_id
- **Validação**: Regras strictas em todos inputs
- **Criptografia de Rotas**: IDs de recursos criptografados (Route Model Binding)
- **CSRF Protection**: Tokens CSRF em todos formulários
- **File Upload Validação**: Tipo, tamanho e extensão verificados

---

## 🎨 Interface e UX

- **Responsivo**: Funciona perfeitamente em desktop, tablet e mobile
- **Dark Mode Friendly**: Design neutro compatível com light/dark preferences
- **Acessível**: HTML semântico, labels, contraste adequado
- **Intuitivo**: Fluxos simples e diretos
- **Performance**: Assets otimizados com Vite

---

## 📞 Suporte e Contribuição

### Reportar Bugs
Abra uma [issue no GitHub](https://github.com/Involute42/Projeto-GameVault/issues) com:
- Descrição do problema
- Passos para reproduzir
- Versão PHP/Laravel
- Screenshot se aplicável

### Contribuir
1. Fork o repositório
2. Crie uma branch (`git checkout -b feature/MinhaFeature`)
3. Commit suas mudanças (`git commit -m 'Add MinhaFeature'`)
4. Push para a branch (`git push origin feature/MinhaFeature`)
5. Abra um Pull Request

---

## 📄 Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE para detalhes.

---

## 🙏 Créditos

- **Framework**: [Laravel](https://laravel.com)
- **UI Framework**: [Tailwind CSS](https://tailwindcss.com)
- **Interatividade**: [Alpine.js](https://alpinejs.dev)
- **Build Tool**: [Vite](https://vitejs.dev)

---

## 🎮 Versão Atual

**v1.0.0** - Versão inicial com funcionalidades principais

### ✅ Implementado
- ✅ Autenticação de usuários
- ✅ CRUD completo de jogos
- ✅ Gerenciamento de plataformas
- ✅ Gerenciamento de gêneros
- ✅ Gerenciamento de desenvolvedoras
- ✅ Upload e preview de imagens
- ✅ Sistema de busca e filtros
- ✅ Dashboard
- ✅ Validação de dados
- ✅ Interface responsiva

### 🚀 Futuras Melhorias Possíveis
- Compartilhamento de biblioteca com amigos
- Sistema de reviews/comentários
- Estatísticas avançadas
- Integração com APIs de games
- Sistema de badges/achievements
- Backup automático
- Sincronização em nuvem

---

**Desenvolvido com ❤️ usando Laravel e Tailwind CSS**

Para mais informações, acesse: https://github.com/Involute42/Projeto-GameVault
