## Comandos de execução
```
docker run --rm -v $(pwd):/app prooph/composer:7.2 install
cp .env.example .env
docker-compose up -d
```

## Adicionar permissão de escrita nas pastas
```
storage
bootstrap/cache
```

## Testes
Dentro do docker executar o comando abaixo
```
vendor/bin/phpunit
```
Relatório de cobertura será gerado na pasta "report"

Endereço da aplicação:
```
GET http://localhost/api/quote/{from}/{to}
POST http://localhost/api/route
```

Endereço da documentação:

POST http://localhost/api/documentation