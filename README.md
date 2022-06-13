## Test Kontiki

Dado el proyecto actual, es necesario generar una solución que resuelva la siguiente problemática:

Se debe generar una API segura (OAuth2) con los siguientes endpoints:

*POST /api/sale*

```json
{
    "name": string(required),
    "email": string(required),
    "description": string(optional)
}
```

La información enviada se debe guardar en la base de datos, en un model `Person` considerando los siguientes campos adicionales:

* ID autogenerado
* UserID extraido del token usado en la base de datos
* Es necesario considerar los migration

*GET /api/sale*

Este endpoint debe obtener los elementos de `Person` correspondientes al usuario ligado al token de seguridad.


## Proceso adicional

Una vez registrado un elemento de `Person` se debe disparar un evento `PersonCreated` que debe ser escuchado a través de `PersonCreatedListener` el cual debe generar una
entrada en el log informando que el elemento ha sido generado.

