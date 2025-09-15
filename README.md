🦕 Draftosaurus – Entrega 2

Este proyecto es parte de la segunda entrega de Programación del Bachillerato Tecnológico de Informática (UTU).
La idea fue digitalizar el juego de mesa Draftosaurus, permitiendo jugar en computadora con reglas adaptadas.



Integrantes (SydneyCorp)

Juan Fantoni (Coordinador)
Lázaro Fernández (Subcoordinador)
Franco Di Pietro (Integrante 1)
Lucía Ramírez (Integrante 2)

⚙️Tecnologías usadas:
Frontend: HTML, CSS, Bootstrap 5, JavaScript
Backend: PHP (XAMPP)
Base de datos: MySQL (phpMyAdmin)
Control de versiones: Git / GitHub



🚀Funcionalidades principales:

Registro y login de usuarios (con sesiones PHP).

Creación de partida (modo solitario o multijugador de 2 a 5 jugadores).

Tablero digital con recintos y dado que define restricciones.

Dinosaurios arrastrables (drag & drop).

Reglas básicas implementadas:

Solo un dinosaurio por recinto.

El T-Rex solo en su recinto.

Si no se puede colocar, va al Río.

Dinosaurios se reparten y rotan entre jugadores en cada turno.


🛠️ Cómo instalar y correr

Descargar XAMPP
.

Clonar este repositorio dentro de la carpeta htdocs/ de XAMPP:

git clone https://github.com/sydnecorp/Draftosaurus-entrega-2.git


Crear la base de datos en phpMyAdmin con el archivo sql/draftosaurus.sql.

Levantar Apache y MySQL desde XAMPP.

Entrar en el navegador a:

http://localhost/draftosaurus/index.php
