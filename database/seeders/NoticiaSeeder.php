<?php

namespace Database\Seeders;

use App\Models\Noticia;
use Illuminate\Database\Seeder;

class NoticiaSeeder extends Seeder
{
    public function run(): void
    {
        $noticias = [
            [
                'slug' => 'equipo-femenino-campeon-futsal',
                'titulo' => 'Equipo femenino se consagra campeón de futsal',
                'extracto' => 'El equipo femenino de futsal de la I.E.I. N.° 31756 Ricardo Palma logró un triunfo histórico al consagrarse campeón en la categoría “C”.',
                'contenido' => 'El equipo femenino de futsal de la I.E.I. N.° 31756 Ricardo Palma logró un triunfo histórico al consagrarse campeón en la categoría “C”. Con orgullo, dedicación y trabajo en equipo, nuestras estudiantes demostraron el espíritu ricardino dentro y fuera de las canchas, dejando en alto el nombre de nuestra querida institución educativa en Pasco.',
                'imagen' => 'images/galeria_2.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-09-09',
                'destacada' => true,
                'orden' => 1,
            ],
            [
                'slug' => 'campeones-distrital-futsal-varones',
                'titulo' => 'Campeones en la etapa distrital de futsal varones',
                'extracto' => 'Nuestros estudiantes obtuvieron el primer lugar en la etapa distrital de los Juegos Escolares Deportivos.',
                'contenido' => 'Con gran garra y entrega deportiva, el equipo de futsal varones de nuestra institución se coronó campeón en la etapa distrital de los Juegos Escolares Deportivos. Felicitamos a los jóvenes atletas y a su entrenador por este importante logro que motiva a toda la comunidad estudiantil.',
                'imagen' => 'images/galeria_3.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-08-02',
                'destacada' => false,
                'orden' => 2,
            ],
            [
                'slug' => 'reconocimiento-estudiante-ingreso-universidad',
                'titulo' => 'Reconocimiento a estudiante por ingreso a la universidad',
                'extracto' => 'Felicitamos a nuestra destacada alumna por su ingreso a la educación superior en los primeros puestos.',
                'contenido' => 'La comunidad de la I.E.I. N.° 31756 Ricardo Palma hace un merecido reconocimiento a nuestra talentosa estudiante por su ingreso a la universidad en los primeros puestos. Su disciplina, esfuerzo constante y pasión por el aprendizaje son un ejemplo inspirador para todos sus compañeros.',
                'imagen' => 'images/galeria_1.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-07-16',
                'destacada' => false,
                'orden' => 3,
            ],
            [
                'slug' => 'ceremonia-izamiento-pabellon-nacional',
                'titulo' => 'Ceremonia de izamiento del pabellón nacional',
                'extracto' => 'Nuestra escolta y delegación escolar participaron con gallardía en el izamiento dominical.',
                'contenido' => 'Con fervor patriótico y civismo, nuestra escolta y plana docente participaron solemnemente en la ceremonia de izamiento del pabellón nacional en la plaza principal de Chaupimarca, reafirmando los valores cívicos y la identidad cultural que promovemos diariamente.',
                'imagen' => 'images/ricardino_escolta.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-08-02',
                'destacada' => false,
                'orden' => 4,
            ],
            [
                'slug' => 'premiacion-estudiantes-destacados',
                'titulo' => 'Premiación a estudiantes destacados del primer semestre',
                'extracto' => 'Se llevó a cabo la ceremonia de reconocimiento al mérito académico y actitudinal.',
                'contenido' => 'En una emotiva ceremonia con la presencia de directivos y padres de familia, se premió el esfuerzo y rendimiento académico de los estudiantes que alcanzaron los primeros lugares en sus respectivos grados durante el primer semestre del año lectivo.',
                'imagen' => 'images/ricardinos_premiacion.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-07-19',
                'destacada' => false,
                'orden' => 5,
            ],
            [
                'slug' => 'docentes-participan-capacitacion-jec',
                'titulo' => 'Docentes participan en capacitación sobre la JEC',
                'extracto' => 'Nuestros profesores fortalecen competencias pedagógicas en el marco de la Jornada Escolar Completa.',
                'contenido' => 'Los docentes de los niveles Inicial, Primaria y Secundaria participaron activamente en las jornadas de actualización pedagógica sobre la implementación de la Jornada Escolar Completa (JEC), orientadas a la innovación metodológica y el uso formativo de tecnologías en el aula.',
                'imagen' => 'images/plana_docente.jpg',
                'autor' => 'Oficina de Comunicación y Imagen Institucional',
                'fecha_publicacion' => '2026-07-04',
                'destacada' => false,
                'orden' => 6,
            ],
        ];

        foreach ($noticias as $item) {
            Noticia::updateOrCreate(['slug' => $item['slug']], $item);
        }
    }
}
