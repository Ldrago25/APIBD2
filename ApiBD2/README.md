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
endpoint:/api/actualizar-estatus
Forma de envio:
{
    "from": 1,
    "to": 2,
    "amount": 1050,
    "transactionType": 1
}
Forma de respuesta:
{}

json:create user
endpoint:/api/transaction
Forma de envio:
{
    "name": "Carlos",
    "lastName": "Vergara",
    "indentification": "26031211",
    "email": "carlos96cav@gmail.com",
    "password": "Carlos96"
}
Forma de respuesta:
{}

json: estatus de transacion
endpoint:/api/checkingTransaction
Forma de envio:
{}
Forma de respuesta:
{}

json: estatus de transacion y limpiar base de datos
endpoint:/api/cleaner
Forma de envio:
{}
Forma de respuesta:
{}

json: activar o desactivar funcion para actualizar saldo de cuentas
endpoint:/api/actualizar-estatus
Forma de envio:
 {
  "estatus": true/false,
}
Forma de respuesta:
{}


json: crear trigger actualizar datos
endpoint:/api/transaction/CreateTrigger
Forma de envio:
{}
Forma de respuesta:
{}

json: eliminar trigger actualizar datos
endpoint:/api/transaction/DeleteTrigger
Forma de envio:
{}
Forma de respuesta:
{}