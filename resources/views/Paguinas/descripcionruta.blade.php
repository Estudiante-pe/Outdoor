<!-- resources/views/paguinas/descripcionruta.blade.php -->
@extends('layouts.app')

@section('title', 'descripcionruta de rutas')

@section('plantilla')
    <link rel="stylesheet" href="{{ asset('css/paquetes.css') }}">
    <link rel="stylesheet" href="{{asset('css/descripcion.css')}}">

    <section class="hero">
        <h1 class="text-3xl font-bold sm:text-2xl md:text-4xl">rutas <span class="hero-highligh" >{{ $ruta->nombre_ruta }}</span>
        </h1>
        <p>{{ $ruta->descripcion_general }}</p>
    </section>

    <section class="nav-info-bar py-3 sticky-top bg-black">
        <div class="container">
            <ul class="nav justify-content-center d-flex flex-nowrap overflow-auto text-nowrap">
                <li class="nav-item">
                    <span class="nav-link text-white nav-link-custom">
                        <i class="fas fa-file-alt text-warning me-2"></i> Descripción
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white nav-link-custom">
                        <i class="fas fa-map-marker-alt text-warning me-2"></i> Lugares
                    </span>
                </li>
                <li class="nav-item">
                    <span class="nav-link text-white nav-link-custom">
                        <i class="fas fa-concierge-bell text-warning me-2"></i> Servicios
                    </span>
                </li>
            </ul>
        </div>
    </section>


    <section class="container my-5 text-white">
        <div class="row g-4">
            <div class="col-md-7 mb-4">
                <div class="info-card p-4 rounded shadow-lg mb-4">
                    <h2 class="h4 adventure-title mb-4"><i class="fas fa-info-circle me-2 text-warning"></i>Detalles de la
                        aventura</h2>

                    <div class="mb-4">
                        <h5 class="text-warning fw-bold small text-uppercase">La experiencia:</h5>
                        @foreach ($ruta->detalles as $detalle)
                            <p class="opacity-75">{{ $detalle->descripcion }}</p>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-4">
                            <h5 class="text-warning fw-bold small text-uppercase">📍 Lugares a visitar:</h5>
                            <ul class="list-unstyled">
                                @foreach ($ruta->lugaresVisitar as $lugar)
                                    <li class="mb-2"><i
                                            class="fas fa-check-circle text-success me-2 tiny"></i>{{ $lugar->nombre_lugar }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-sm-6 mb-4">
                            <h5 class="text-warning fw-bold small text-uppercase">🛎️ Inclusiones:</h5>
                            <ul class="list-unstyled">
                                @foreach ($ruta->serviciosIncluidos as $servicio)
                                    <li class="mb-2"><i
                                            class="fas fa-plus text-primary me-2 tiny"></i>{{ $servicio->servicio }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="mt-2 p-3 bg-white bg-opacity-10 rounded">
                        <h5 class="text-danger fw-bold small text-uppercase">⚠️ Restricciones e Importante:</h5>
                        <p class="small m-0">Niños mayores de 4 a 10 años pagan tarifa completa para este Full Day. No
                            incluye comidas extras ni propinas.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="row g-2 mb-4 gallery-container">
                    @foreach ($ruta->imagenes as $index => $img)
                        {{-- Mostramos solo las primeras 4, pero las demás estarán disponibles en el visor --}}
                        <div class="col-6 {{ $index >= 4 ? 'd-none' : '' }}">
                            <div class="rounded overflow-hidden shadow-sm" style="height: 160px; cursor: pointer;">
                                <img src="{{ $img->url_imagen }}" class="gallery-item w-100 h-100 object-fit-cover"
                                    alt="Vista de la ruta" onclick="openLightbox({{ $index }})">
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="modal fade" id="lightboxModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <div class="modal-content bg-transparent border-0">
                            <div class="modal-body p-0 position-relative">
                                <button type="button"
                                    class="btn-close btn-close-white position-absolute top-0 end-0 m-3 z-3"
                                    data-bs-dismiss="modal"></button>

                                <div class="d-flex align-items-center justify-content-between">
                                    <button class="btn text-white fs-1" onclick="changeImage(-1)"><i
                                            class="fas fa-chevron-left"></i></button>

                                    <img src="" id="lightboxImage" class="img-fluid rounded shadow-lg mx-auto"
                                        style="max-height: 85vh;">

                                    <button class="btn text-white fs-1" onclick="changeImage(1)"><i
                                            class="fas fa-chevron-right"></i></button>
                                </div>

                                <div class="text-center text-white mt-3 italic" id="imageCounter"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="booking-container p-4 rounded-4 shadow-lg border border-secondary border-opacity-25">
                    <div class="text-center mb-4">
                        <p class="text-uppercase small tracking-widest mb-1">Precio por persona</p>
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <span class="tipo1 text-decoration-line-through fs-5">S/.{{ $ruta->precio_regular }}</span>
                            <span class="fs-1 fw-bold text-success">S/.{{ $ruta->precio_actual }}</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="adventure-title small mb-3"><i class="far fa-calendar-alt me-2 text-warning"></i>Fechas
                            disponibles:</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @forelse ($ruta->fechasDisponibles as $fecha)
                                <span class="badge bg-dark border border-secondary p-2 fw-normal">
                                    {{ \Carbon\Carbon::parse($fecha->fecha)->translatedFormat('d / M / Y') }}
                                </span>
                            @empty
                                <div class=" text-danger  small fst-italic ">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    Fechas por confirmar
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @php
                        $hayFechas = $ruta->fechasDisponibles->isNotEmpty();
                    @endphp

                    @if ($hayFechas)
                        <a href="{{ route('reserva.formulario', ['ruta' => $ruta->id_ruta]) }}"
                            class="btn btn-success btn-lg w-100 fw-bold py-3 shadow-sm hover-lift">
                            RESERVAR AHORA <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    @else
                        <button class="btn btn-secondary btn-lg w-100 fw-bold py-3" disabled>
                            NO DISPONIBLE <i class="fas fa-calendar-times ms-2"></i>
                        </button>
                    @endif


                    <p class="text-center small opacity-50 mt-3 mb-0">
                        <i class="fas fa-shield-alt me-1"></i> Pago seguro y reserva inmediata
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-dark py-5 text-white text-center border-top border-secondary border-opacity-25">
        <div class="container">
            <h2 class="adventure-title h3 mb-2">También te puede interesar</h2>
            <p class="lead fst-italic mb-4 opacity-50">"Un buen viajero no tiene planes fijos..."</p>
        </div>
    </section>

    @include('paguinas.paqueterutas') <!-- Aquí ya estará disponible $rutas como colección -->
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {

        /* Animación info */
        const infoItems = document.querySelectorAll('.info-card h5, .info-card li');
        infoItems.forEach((item, index) => {
            item.style.opacity = '0';
            item.style.transform = 'translateX(-20px)';
            item.style.transition = 'all 0.5s ease';

            setTimeout(() => {
                item.style.opacity = '1';
                item.style.transform = 'translateX(0)';
            }, 100 * index);
        });

        /* Animación galería */
        const galleryImgs = document.querySelectorAll('.gallery-item');
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                entry.target.classList.toggle('show', entry.isIntersecting);
                entry.target.classList.toggle('hide', !entry.isIntersecting);
            });
        }, {
            threshold: 0.3
        });

        galleryImgs.forEach(img => observer.observe(img));

        /* Lightbox */
        const allImages = [
            @foreach ($ruta->imagenes as $img)
                "{{ asset($img->url_imagen) }}",
            @endforeach
        ];

        let currentIndex = 0;
        const lightboxModal = new bootstrap.Modal(document.getElementById('lightboxModal'));
        const lightboxImage = document.getElementById('lightboxImage');
        const imageCounter = document.getElementById('imageCounter');

        function updateLightbox() {
            lightboxImage.style.opacity = '0';
            setTimeout(() => {
                lightboxImage.src = allImages[currentIndex];
                imageCounter.innerText = `Imagen ${currentIndex + 1} de ${allImages.length}`;
                lightboxImage.style.opacity = '1';
            }, 200);
        }

        window.openLightbox = function(index) {
            currentIndex = index;
            updateLightbox();
            lightboxModal.show();
        };

        window.changeImage = function(direction) {
            currentIndex = (currentIndex + direction + allImages.length) % allImages.length;
            updateLightbox();
        };

        document.addEventListener('keydown', e => {
            if (!document.getElementById('lightboxModal').classList.contains('show')) return;
            if (e.key === 'ArrowRight') changeImage(1);
            if (e.key === 'ArrowLeft') changeImage(-1);
            if (e.key === 'Escape') lightboxModal.hide();
        });

    });
</script>
