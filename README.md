# LEEM (PHP)

## Rodar local (recomendado: servidor embutido do PHP)

1) Instale PHP 7.4+ (recomendado 8+) e habilite a extensão `mysqli`.

2) No PowerShell, dentro da pasta do projeto:

```powershell
cd C:\Users\mnsmferr\Downloads\app\app_leem
$env:LEEM_DISABLE_HTTPS_REDIRECT="1"
$env:LEEM_DB_HOST="127.0.0.1"
$env:LEEM_DB_PORT="3306"
$env:LEEM_DB_USER="root"
$env:LEEM_DB_PASS=""
$env:LEEM_DB_NAME="leem"
php -S localhost:8000 index.php
```

3) Abra no navegador:

http://localhost:8000/

## Rodar com Apache (XAMPP/WAMP)

- Aponte o DocumentRoot para a pasta do projeto (a mesma pasta do `index.php`).
- Garanta que `mod_rewrite` esteja habilitado e `AllowOverride All`.
- Use o `.htaccess` deste repositório (ele redireciona todas as rotas para `index.php`).
- Para evitar redirecionamento forçado para HTTPS em ambiente local, configure:

```
SetEnv LEEM_DISABLE_HTTPS_REDIRECT 1
```

## Banco de dados

O app lê as credenciais via variáveis de ambiente:

- `LEEM_DB_HOST`
- `LEEM_DB_PORT`
- `LEEM_DB_USER`
- `LEEM_DB_PASS`
- `LEEM_DB_NAME`

Se essas variáveis não forem definidas, ele usa defaults do ambiente de produção (ex.: host `leem_db`), o que normalmente falha no local.

## Deploy no HostGator (EasyPanel)

Checklist do que precisa estar certo para o app abrir:

1) **Versão do PHP**
- Use PHP 7.4+ (8+ recomendado).

2) **Rotas e arquivos estáticos**
- O app é “front controller” (tudo entra em `index.php`).
- Se o EasyPanel estiver usando Nginx + PHP-FPM, a regra equivalente a `.htaccess` precisa ser:

```
try_files $uri $uri/ /index.php?$query_string;
```

3) **Variáveis de ambiente**
- Configure no EasyPanel (Environment) pelo menos:
  - `LEEM_DB_HOST`
  - `LEEM_DB_PORT`
  - `LEEM_DB_USER`
  - `LEEM_DB_PASS`
  - `LEEM_DB_NAME`
- Se você estiver tendo loop/redirect estranho no HTTPS, set:
  - `LEEM_DISABLE_HTTPS_REDIRECT=1` (para testar)

4) **Como ver logs**
- No EasyPanel: abra o app/serviço e veja a aba **Logs**.
- Procure por `PHP Fatal error`, `mysqli`, `Undefined index`, `Headers already sent`.

## Endpoint de diagnóstico

Existe um endpoint que retorna JSON com informações do runtime e status do banco:

- `https://SEU_DOMINIO/__health`

Ele mostra: versão do PHP, cabeçalhos de proxy (x-forwarded-*) e se a conexão MySQL está OK.
