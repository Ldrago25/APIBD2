Comandos para instalar el proyectos 

1) git clone https://github.com/Ldrago25/APIBD2.git
2) composer install
3) php artisan migrate --seed
4) php artisan key:generate
5) php artisan server

transactionType:
1 = deposito
2 = retiro
3 = transferencia

json:create transaction
{
    "from": 1,
    "to": 2,
    "amount": 450,
    "transactionType": 3
}

json:create user
{
    "name": "Carlos",
    "lastName": "Vergara",
    "indentification": "26031211",
    "email": "carlos96cav@gmail.com",
    "password": "Carlos96"
}