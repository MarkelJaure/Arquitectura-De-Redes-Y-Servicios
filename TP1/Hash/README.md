## Respuestas Hash

1. Los algoritmos de hash (md5, sha-x, etc.) no se utilizan para cifrar mensajes. ¿Por qué?

MD5 (abreviatura de Message-Digest Algorithm 5, Algoritmo de Resumen del Mensaje 5)
MD5 no es un algoritmo de cifrado, sino un algoritmo de resumen
MD5 puede utilizarse como una función hash en el proceso de cifrado para garantizar la integridad del mensaje, pero necesitamos otro algoritmo Para garantizar la confidencialidad del mensaje
comprobar que un archivo no ha sido alterado

SHA - SECURE HASH ALGORITHM 
El SHA es similar en su forma de operación al MD-5, pero produce un resumen, de 160 bits, más largo que el éste y que el de cualquier otro algoritmo de autenticación de los usados con anterioridad.

La resistencia del algoritmo SHA-1 se ha visto comprometida a lo largo del año 2005. Después de que MD5, entre otros, quedara seriamente comprometido en el 2004 por parte de un equipo de investigadores chinos



2. Explique conceptualmente la utilidad de algoritmos de hash para:
a) Autenticación de usuarios
b) Comprobación de integridad de archivos.




3. ¿Qué es salt? ¿Para qué se utiliza?



4. Escriba un pequeño programa que almacene usuarios/contraseñas (MySQL, PostgreSQL,
etc.) y permita registrarse/autenticarse, utilizando algún algoritmo de hash. Tenga en cuenta la
utilización de salt.
El programa debe estar realizado en el lenguaje de programación PHP.

