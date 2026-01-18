@extends('layouts.app')

@section('title', 'Blog')
<section class="hero text-center">
        <link rel="stylesheet" href="{{ asset('css/blog.css') }}">


    <h1 class="text-3xl font-bold sm:text-2xl md:text-4xl">
        Empieza a descubrir <span>La Libertad</span>
    </h1>
    <p>Tours Full Days todos los días</p>
</section>
<!-- Espaciador (opcional si hay más contenido abajo) -->
<section class="bg-dark py-3">
    <div class="container d-flex justify-content-center"></div>
</section>

@section('plantilla')
    <section class="bg-light py-5">
        <div class="container">
            <h2>Descubre Trujillo con Nuestra Agencia de Turismo</h2>
            <p class="lead text-center">
                Somos una agencia de turismo especializada en brindar experiencias inolvidables en la ciudad de Trujillo y
                sus alrededores. Conoce la historia, cultura y naturaleza de esta joya del norte peruano.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <img src="{{ asset('imagenes/historia.png')}}" 
                        class="img-fluid rounded shadow" alt="Turismo Trujillo" title="Historia">
                </div>
                <div class="col-md-6">
                    <h2>Nuestra Historia</h2>
                    <p>
                        Somos una agencia con más de 10 años de experiencia en el sector turístico, ofreciendo tours
                        personalizados, excursiones full day y paquetes culturales. Nuestro equipo está conformado por guías
                        locales, apasionados por mostrar lo mejor de Trujillo.
                    </p>
                    <p>
                        Contamos con transporte seguro, guías certificados y un profundo conocimiento de los destinos
                        históricos como Chan Chan, Huaca del Sol y la Luna, y la mágica playa de Huanchaco.
                    </p>
                </div>
            </div>
            @include('paguinas.nosotros.filosofia')
            @include('paguinas.nosotros.valores')
            @include('paguinas.nosotros.testimonios')
        </div>
    </section>
@endsection

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Blantic+Rockybilly&display=swap" rel="stylesheet">


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const valores = document.querySelectorAll('.valor');

        valores.forEach(valor => {
            valor.addEventListener('click', function() {
                this.classList.toggle('open');
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
