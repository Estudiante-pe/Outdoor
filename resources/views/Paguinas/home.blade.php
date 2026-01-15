<!-- resources/views/paguinas/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home')

@section('plantilla')

    <link rel="stylesheet" href="{{ asset('css/paquetes.css') }}">

    <!-- Sección Hero -->
    <section class="hero text-center">

        <h1 class="text-3xl font-bold sm:text-2xl md:text-4xl">
            Empieza a descubrir <span>La Libertad</span>
        </h1>
        <p>Tours Full Days todos los días</p>
    </section>

    <!-- Espaciador (opcional si hay más contenido abajo) -->
    <section class="bg-dark py-3">
        <div class="container d-flex justify-content-center"></div>
    </section>

    <!-- Sección informativa -->
    <section class="py-5">
        <div class="container">
            <!-- Fila con imagen y texto -->
            <div class="row align-items-center mb-5">
                <div class="col-md-5">
                    <img src="https://toursentrujillo.com/wp-content/uploads/2022/01/puenting.jpg" alt="Cascas Historia"
                        class="img-fluid rounded">
                </div>
                <div class="col-md-7">
                    <h2>¿Quiénes Somos?</h2>
                    <p class="fs-6">
                        Outdoor Expeditions es una Agencia de Viajes Tour Operadora con sede en la ciudad de Trujillo, Perú.
                        Desde nuestros inicios estuvimos vinculados a las comunidades más alejadas y a las montañas del ande
                        Liberteño. Descubriendo en ambas nuestra pasión por impulsar el desarrollo de un turismo más
                        sostenible y responsable que beneficie a las comunidades locales y preserve el medio ambiente.
                        Teniendo como pilar el ofrecer experiencias únicas y emocionantes que permitan a nuestros viajeros
                        conectar con la cultura y naturaleza de nuestros destinos.
                        <br>
                        Como emblema empresarial tenemos el ser los pioneros en operar rutas de trekking tales como Camino
                        Inca "Tramo Escalerilla" y organizar ascensos al Pico más alto de la región "Huaylillas 4750 msnm".
                        Además de liderar el posicionamiento y promoción de nuevos destinos y/o corredores turísticos, tales
                        como Salpo, Cachicadan, Santiago de Chuco, Mache, Canotaje en Jequetepeque, Motil y mucho más.
                    </p>
                </div>
            </div>

            <!-- Fila de bloques de imagen -->
            <div class="row gx-4 gy-3 reveal">
                @php
                    $bloques = [
                        [
                            'titulo' => 'Tours Full Day',
                            'imagenes' => $rutasAventura,
                            'ruta' => route('rutas.tipo', ['tipo' => 'Aventura']),
                        ],
                        [
                            'titulo' => 'Tours de Trekking',
                            'imagenes' => $rutasTrekking,
                            'ruta' => route('rutas.tipo', ['tipo' => 'Trekking']),
                        ],
                    ];
                @endphp
                @foreach ($bloques as $index => $bloque)
                    @php
                        $imagenes = $bloque['imagenes']
                            ->pluck('imagenes')
                            ->flatten()
                            ->pluck('url_imagen')
                            ->take(10)
                            ->toArray();
                    @endphp

                    <div class="col-md-6 mb-4">
                        <div class="bg-white bg-opacity-75 p-3 rounded shadow-sm h-100 text-center">
                            <h2 class="fw-bold mb-3">{{ $bloque['titulo'] }}</h2>

                            <div class="row g-2 justify-content-center" data-imgs='@json($imagenes)'
                                id="bloque-{{ $index }}">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="col-6">
                                        <div class="ratio ratio-4x3 rounded overflow-hidden img-slot"
                                            style="max-width: 245px; margin: 0 auto;">
                                            <img src="" class="w-100 h-100 object-fit-cover img-fluid"
                                                alt="Imagen">
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ $bloque['ruta'] }}" class="btn btn-success px-4 py-1">Ver más</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    @include('paguinas.paqueterutas')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const updateInterval = 5000; // 5 segundos

        document.querySelectorAll('[id^="bloque-"]').forEach(bloque => {
            const imagenes = JSON.parse(bloque.dataset.imgs);
            const slots = bloque.querySelectorAll('.img-slot');

            function getRandomImages(images, count) {
                return [...images].sort(() => 0.5 - Math.random()).slice(0, count);
            }

            // Reemplaza tu función updateImages dentro del script de home.blade.php con esta:
            function updateImages() {
                const randomImgs = getRandomImages(imagenes, 4);

                slots.forEach((slot, i) => {
                    const imgElement = slot.querySelector('img');

                    // 1. Aplicar clase de transición
                    imgElement.classList.add('img-changing');
                    imgElement.style.opacity = '0';

                    setTimeout(() => {
                        // 2. Cambiar la fuente mientras está invisible
                        imgElement.src = randomImgs[i];

                        // 3. Volver a mostrar con suavidad
                        imgElement.onload = () => {
                            imgElement.style.opacity = '1';
                            imgElement.classList.remove('img-changing');
                        };
                    }, 800); // Tiempo que dura el desvanecimiento
                });
            }
            updateImages();
            setInterval(updateImages, updateInterval);
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        const section = document.querySelector('.row.align-items-center.mb-5');
        const textElement = section.querySelector('.fs-6');
        const originalText = textElement.innerHTML; // Guardamos el texto con sus <br>

        // Preparamos el elemento de texto
        textElement.innerHTML = '';
        textElement.classList.add('typing-cursor');
        const isMobile = window.innerWidth < 768;
        const typingSpeed = isMobile ? 5 : 15
        const typewriter = (element, text) => {
            let i = 0;
            element.style.visibility = 'visible';

            // Función recursiva para escribir
            const type = () => {
                if (i < text.length) {
                    // Si detectamos un tag HTML (como <br>), lo saltamos para que no se rompa la lógica
                    if (text.charAt(i) === '<') {
                        i = text.indexOf('>', i) + 1;
                    } else {
                        i++;
                    }
                    element.innerHTML = text.substring(0, i);
                    setTimeout(type, typingSpeed); // Velocidad de escritura (ms)
                } else {
                    element.classList.remove('typing-cursor');
                    element.style.borderRight = 'none';
                }
            };
            type();
        };

        // Observer para disparar ambos efectos al hacer scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Activamos la imagen (CSS)
                    section.classList.add('reveal-active');

                    // Activamos el texto (JS)
                    typewriter(textElement, originalText);

                    // Dejamos de observar para que no se repita
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.3
        }); // Se activa cuando el 30% de la sección es visible

        observer.observe(section);
    });
</script>
