1. Instalar en el browser la extensión Mailvelope. Generar el par de llaves pública/privada para
la dirección de correo de Gmail. Revisar la casilla de entrada y verificar la cuenta desde el mail
que envía el servidor de Mailvelope. Coordinar con el docente: cuando todos hayan generado
el par de llaves, enviar un mail encriptado a cada uno. Leer los mails recibidos de los
compañeros en el browser que tiene la extensión Mailvelope instalada, y desde otro browser
que no la tenga.

   **R:** Para la prueba de este ejercicio se realizaron 3 envíos de mails con diferentes configuraciones de claves para testear la aplicación (envío de mail desde un remitente "a" a un receptor "b")


   - ***a)*** Envío de mail encriptado con clave privada de **"a"**: Esto concluye en que el receptor **"b"** recibirá un mail a desencriptar con la clave publica de **"a"**, con lo que sirve para verificar que el mail efectivamente fue escrito por **"a"**. Este mail puede ser leído por cualquier persona que tenga la clave publica de **"a"**
    
   - ***b)*** Envío de mail encriptado con clave publica de **"b"**: Esto concluye en que el mail solo puede ser leído por **"b"**. pero no se puede verificar por quien ha sido escrito.
    
   - ***c)*** Envió de mail encriptado con clave privada de **"a"** y clave publica de **"b"**: Esto concluye en que **"b"** puede confirmar que el mail fue enviado por **"a"** y ademas solo puede ser leído por **"b"**. Por lo que ningun otro receptor no podría desencriptarlo.


2. Entorno Linux. Escribir un script de shell que copie el contenido de un directorio de nuestro
home, en el home de un usuario de otra computadora. El script no debe revelar ninguna
contraseña. Utilizar el anexo.

   **R:** Se adjunta en el directorio TP2 el archivo copyfile.sh que contiene el script shell para copiar un archivo local a una computadora externa mediante SSH, sin revelar ninguna clave.

3. Investigue qué es DKIM y explique cómo funciona y para qué se utiliza.
  
     **R:** ***DKIM*** es el acrónimo de DomainKeys Identified Mail, un mecanismo diseñado para evitar la manipulación de los encabezados de los mails a través de una firma digital. El objetivo es evitar que los encabezados como el "From" de un mail y el contenido puedan ser modificados en el proceso de envío o manipulados intencionalmente por el remitente para hacerse pasar por otro.

    Este funciona a través del hasheo del mail y la codificación asimétrica (Clave publica y clave privada) para asegurar la validez del correo.

  - Hash: Al correo se le agrega en el encabezado un hasheo del contenido, si el receptor obtiene el mismo hash con el contenido del correo podría asegurar de que el contenido no fue modificado.
  
  - Codificación asimétrica: El remitente codifica con su firma privada el hash del correo, el receptor debe solicitar al servidor la clave pública del remitente e intentar decodificar el hasheo, si el valor obtenido coincide con el descifrado puede verificar la autenticidad del remitente.


