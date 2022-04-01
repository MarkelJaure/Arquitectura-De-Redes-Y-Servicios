## Sniffing


### Punto 2:

- ***a)*** En la foto adjunta "Punto 2a.png" se puede observar como el paquete enviado a la pagina insegura se encuentra en texto plano, haciendo visible los datos sensibles enviados al servidor tales como el usuario y la contraseña.
- ***b)*** Para este punto, en la aplicacion Wireshark no se puede encontrar el paquete. Esto debido a que, a pesar de que el sitio web "geonames.org" es inseguro, el paquete es enviado a un servidos con seguridad https, lo que hace que el paquete vaya encriptado. En la foto adjunta "Punto 2b.png" se puede como el formulario enviado es a un sitio web "HTTPS".

## Footprinting (Linux)


**R:**

- ***a)***
```
host -t ns google.com.ar
google.com.ar name server ns2.google.com.
google.com.ar name server ns3.google.com.
google.com.ar name server ns4.google.com.
google.com.ar name server ns1.google.com.
```
- ***b)***
```
host -t ns com.ar
com.ar name server a.dns.ar.
com.ar name server b.dns.ar.
com.ar name server c.dns.ar.
com.ar name server e.dns.ar.
com.ar name server f.dns.ar.
```
- ***c)***
```
host -t ns ar
ar name server c.dns.ar.
ar name server d.dns.ar.
ar name server e.dns.ar.
ar name server f.dns.ar.
ar name server ar.cctld.authdns.ripe.net.
ar name server a.dns.ar.
ar name server b.dns.ar.
```

```
host -t ns .
. name server k.root-servers.net.
. name server l.root-servers.net.
. name server m.root-servers.net.
. name server a.root-servers.net.
. name server b.root-servers.net.
. name server c.root-servers.net.
. name server d.root-servers.net.
. name server e.root-servers.net.
. name server f.root-servers.net.
. name server g.root-servers.net.
. name server h.root-servers.net.
. name server i.root-servers.net.
. name server j.root-servers.net.
```
- ***c)***
```
host -t mx google.com.ar
google.com.ar mail is handled by 0 smtp.google.com.
```
- ***d)***
```
host -t soa google.com.ar
google.com.ar has SOA record ns1.google.com. dns-admin.google.com. 438780121 900 900 1800 60
```

