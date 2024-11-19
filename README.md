# TIM-API

## Deploy inicial ambiente docker

Obs: trata-se de um procedimento de deploy básico. O ideal é construir um ambiente automatizado.

Dado que o "Docker" e "Docker Compose" estão devidamente instalados no ambiente, siga os passos abaixo:

Clone o projeto:

```shell
cd pasta/raiz/projetos/docker

git clone https://github.com/Emerson1130/tim-back.git

cd tim-back
```
Duplique o arquivo ou o renomeie para:
```shelldocker-compose.yml.sample```

Suba o container:

```shell
docker compose up -d 
```
Descubra o nome da imagem:
```shell
docker ps
```

Entre no container:
```shell
docker exec -it tim-api bash
```

Execute o comando:
```shell
composer install
```
### Permissão na pasta upload

Na primeira instalação, permita que o usuário www-data ou apache tenha acesso de escrita na storage (isso dará permissão
no volume compartilhado).

```shell
chown -R www-data:www-data \
    /var/www/html/vendor \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache
```

### Agora o projeto está rodando na porta 8802.

Teste no navegador:
```shell
http://localhost:8802/api/consultar-cep?cep=70701050
```

### Gerando um APP_KEY CASO NÃO TENHA

Caso não tenha uma chave para colocar no .env (APP_ENV), siga o passo abaixo:

Gere a chave:

```shell
docker exec -it tim-back php artisan key:generate
```

Copie o valor da chave "APP_KEY" do .env que está no container:

```shell
docker exec -it tim-back cat .env | grep APP_KEY=
```



