maicka
======

Instalación.

- Crear directorio si no existe /var/www/share
- Copiar carpetas Bisna, Doctrine, Zend desde otro proyecto y pegar a /var/www/share

Ejecutar
- cd /var/www/dtz/library
- ln -s /var/www/share/Zend/ ../library/
- ln -s /var/www/share/Doctrine/ ../library/
- ln -s /var/www/share/Bisna/ ../library/