**Для запуска проекта должен быть установлен docker и docker-compose**

**Клонируем проект**

`git clone https://github.com/NikitaPilez/systemeio.git`

**Переходим в директорию**

`cd systemeio`

**Билд докера**

`docker-compose build`

**Поднимаем сервисы**

`docker-compose up -d` (либо можно использовать без флага -d, тогда в консоли можно будет увидеть логи, а последующие команды выполнять в отдельной консоли)

**Устанавливаем зависимости**

`docker exec -it systemeio_php composer i`

**Накатываем миграции**

`docker exec -it systemeio_php php bin/console doctrine:migrations:migrate`

**Накатываем sql скрипт для наполнения первоначальными данными в проект**
`docker exec -it systemeio_pg psql -U admin -d systemeio -f ./docker-entrypoint-initdb.d/init.sql`

**Для того чтоб остановить работу с контейнерами следует выполнить**

`docker-compose down`

## **Тестирование**

Запрос на расчет цены товара который стоит 100$, с налогом в Италии 22%, и промокодом 8mar на скидку 10% от суммы товара

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "IT45656", "coupon_code": "8mar"}' http://localhost:8080/calculate-price`

Запрос на расчет цены товара который стоит 100$, с налогом в Италии 22%, и промокодом bir на скидку 5$ от суммы товара

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "IT45656", "coupon_code": "bir"}' http://localhost:8080/calculate-price`

Запрос на расчет цены товара который стоит 100$, с налогом в Франции 20% без промокода

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "FRGH465"}' http://localhost:8080/calculate-price`

Запрос на расчет цены товара с неверным ID товара

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 123, "tax_number": "FRGH465"}' http://localhost:8080/calculate-price`

Запрос на оплату товара через paypal

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "FRGH465", "coupon_code": "8mar", "paymentProcessor": "paypal"}' http://localhost:8080/pay`

Запрос на оплату товара с несуществующей платежкой

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "FRGH465", "coupon_code": "8mar", "paymentProcessor": "visa"}' http://localhost:8080/pay`

Запрос на оплату товара через stripe

`curl -X POST -H "Content-Type: application/json" -d '{"product_id": 1, "tax_number": "FRGH465", "coupon_code": "8mar", "paymentProcessor": "stripe"}' http://localhost:8080/pay`
