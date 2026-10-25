# Guía de Imágenes Estáticas - I.E.I. N° 31756 Ricardo Palma

Esta carpeta (`public/images/`) está organizada en subcarpetas para que sea rápido y sencillo cambiar cualquier imagen o banner directamente desde el **Administrador de Archivos de cPanel** sin tener que tocar código.

---

## 📁 Estructura de Carpetas

### 1. `banners/` (Banners principales y portadas)
Imágenes que se usan como fondos de cabecera y sliders en las páginas públicas:
- **`fachada_colegio.jpg`**: Portada principal del colegio (Hero 1 en la página de inicio).
- **`hero_2.jpg`**: Segunda imagen del slider principal en la página de inicio.
- **`plana_docente.jpg`**: Tercera imagen del slider de inicio y banner principal de la página `/docentes`.
- **`ricardino_aula.jpg`**: Banner principal de la cabecera en la sección `/noticias`.

> **💡 Para cambiar un banner:** Simplemente sube tu nueva imagen con el mismo nombre y formato (ej. `fachada_colegio.jpg`) a esta carpeta `banners/`.

---

### 2. `branding/` (Logotipos e Identidad Institucional)
Logos oficiales del colegio:
- **`logo_color.png`**: Escudo/logotipo institucional a color (usado en el navbar, favicon y encabezados).
- **`logo_blanco.png`**: Versión blanca para contrastar en fondos oscuros.
- **`logo_original_blanco.png`**: Logotipo institucional original usado en el pie de página (footer).

---

### 3. `niveles/` (Insignias de Niveles Educativos)
Imágenes que identifican los tres niveles en la página de inicio:
- **`nivel_inicial.png`**: Insignia representativa del nivel inicial.
- **`nivel_primaria.png`**: Insignia representativa del nivel primaria.
- **`nivel_secundaria.png`**: Insignia representativa del nivel secundaria.

---

### 4. `institucional/` (Fotos y Gráficos Informativos)
Fotografías de logros, estudiantes y secciones fijas:
- **`quienes_somos.jpg`**: Fotografía en la página `/nosotros` (sección Quiénes Somos).
- **`alumna_destacada.png`**: Foto destacada en el bloque de logros.
- **`ricardino_campeon.jpg`**: Foto de campeonato deportivo escolar.
- **`ricardino_libros.jpg`**: Foto de biblioteca / comprensión lectora.
- **`ricardino_escolta.jpg`**: Foto de la escolta institucional.
- **`ricardinos_premiacion.jpg`**: Foto de premiación académica.
- **`ricardinos_formados.jpg`**: Foto de formación cívica y disciplina.
- **`octagono_docente.png`**: Gráfico del octágono de ejes pedagógicos en `/docentes`.
- **`padre.png`**: Ilustración de padre/familia en la sección de valores.

---

### 5. `equipo/` (Plana Directiva y Jerárquica)
Fotografías de los directivos y coordinadores que aparecen en `/nosotros`:
- `walter_porras.png` (Director)
- `nicolas_espinoza.png` (Subdirector)
- `adrian_tamara.png` (Coordinador)
- `rayda_rivas.png`, `carmen_romero.png`, `luz_pardave.png`, `catering_campos.png`, `jean_rajo.png`

---

### 6. `iconos/` (Logos de Redes Sociales)
Iconografía vectorial usada en enlaces de contacto:
- `facebook.svg`
- `whatsapp.svg`
- `youtube.svg`

---

### 7. `uploads/` (Imágenes subidas desde el Panel Admin)
Carpeta reservada para las nuevas fotos y noticias que el personal suba desde el panel administrativo (`/admin`).

---

## 📌 Compatibilidad y Buenas Prácticas
1. **Dimensiones recomendadas para Banners:** 1920x1080 px o 1600x900 px (calidad 80-85% en JPG o WEBP) para mantener carga rápida.
2. **Nombres de archivo:** Si reemplazas un archivo manteniendo el mismo nombre exacto, la web lo actualizará automáticamente sin modificar ninguna vista en PHP.
