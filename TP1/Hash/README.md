## Respuestas Hash

1. Los algoritmos de hash (md5, sha-x, etc.) no se utilizan para cifrar mensajes. ¿Por qué?

Los algoritmos mencionados no se utilizan para el cifrado de mensajes debido a que ambos estan pensados como "algoritmos de resumen". Estos algoritmos de resumen tienen como objetivo garantizar la integridad de un archivo/mensaje (que no ha sido modificado), pero no pueden garantizar la confidencialidad del mismo. La resistencia de ambos algoritmos de hash ya tienen historial de haber sido comprometidos por lo que no se pueden confiar para el cifrado de mensajes.

2. Explique conceptualmente la utilidad de algoritmos de hash para:
   a) Autenticación de usuarios
   b) Comprobación de integridad de archivos.

**a:** La utilidad para la Autenticacion de usuarios refiere al poder hashear y verificar claves de usuario de forma unidireccional. El poder cifrar una password y, sin descifrarla, comparar con la ingresada por el usuario para adimitir el inicio de sesion a alguna aplicacion.

**b:** En la Comprobación de integridad de archivos, el hasheo es util para verificar que un archivo/mensaje no ha sido alterado desde su hasheo, esto gracias a los checksum que realizan los algoritmos de resumen.

3. ¿Qué es salt? ¿Para qué se utiliza?

El "salt" en la criptografia, es un agregado de bits que se le hace a la clave para hacerla mas larga y compleja. Esto es util para agregarle una capa de seguridad al sistema ante posibles ataques, ya que cada clave estara concatenada con una cantidad de bits aleatorios que deberian ser separados en caso de querer descifrarla.

4. Escriba un pequeño programa que almacene usuarios/contraseñas (MySQL, PostgreSQL,
   etc.) y permita registrarse/autenticarse, utilizando algún algoritmo de hash. Tenga en cuenta la
   utilización de salt.
   El programa debe estar realizado en el lenguaje de programación PHP.

En el PhpMyAdmin crear una base de datos llamada "Arquitectura" (en caso de querer usar otra o ponerle otro nombre, modificar "lib/config.php"), dentro crear una tabla con las siguientes propiedades:

```sql
CREATE TABLE users (
id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
username VARCHAR(50) NOT NULL UNIQUE,
password VARCHAR(255) NOT NULL,
created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

### En la aplicacion se utilizan:

- password_hash() para hashear la clave
- password_verify() para comparar la clave ingresada con la almacenada

Password_hash() agrega por default un hash a la clave ingresada, password_verify() tiene en cuenta esto y como toda la informacion necesaria esta dentro de la clave hasheada puede ejecutarse sin problemas.
