@extends('layouts.app')

@section('title','Términos y Condiciones')
@section('meta_description','Condiciones de uso del sitio y la calculadora de indemnización y finiquito en México.')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
  <header class="space-y-2">
    <h1 class="text-2xl md:text-3xl font-semibold">Términos y Condiciones</h1>
    <p class="text-sm text-gray-600">
      Última actualización:
      <time datetime="{{ now()->toDateString() }}">{{ now()->translatedFormat('d \\de F, Y') }}</time>
    </p>
  </header>

  <section class="prose prose-indigo max-w-none">
    <h2>1. Identidad del titular</h2>
    <p>
      Este sitio web y la herramienta de cálculo (la “<strong>Plataforma</strong>”) son operados por
      <strong>{{ config('app.name') }}</strong>. Para cualquier duda, contáctanos en
      <a href="mailto:contacto@calculadoraindemnizacion.com">contacto@calculadoraindemnizacion.com</a>.
    </p>

    <h2>2. Aceptación de las condiciones</h2>
    <p>
      Al acceder y utilizar la Plataforma aceptas estos <strong>Términos y Condiciones</strong>. Si no estás de acuerdo,
      debes abstenerte de usarla. También aplican nuestro
      <a href="{{ route('aviso-privacidad') }}" class="underline">Aviso de Privacidad</a> y
      nuestra <a href="{{ route('politica-cookies') }}" class="underline">Política de Cookies</a>.
    </p>

    <h2>3. Naturaleza del servicio (no es asesoría legal)</h2>
    <p>
      La Plataforma proporciona <strong>estimaciones orientativas</strong> sobre indemnización o finiquito con base en
      parámetros que tú ingresas y en disposiciones de la <em>Ley Federal del Trabajo (LFT)</em>. La información
      mostrada no constituye asesoría legal, fiscal ni laboral, ni crea relación abogado-cliente. Para un caso concreto,
      consulta a un(a) profesional calificado(a).
    </p>

    <h2>4. Elegibilidad y uso</h2>
    <ul>
      <li>Debes tener capacidad legal para contratar conforme a la legislación mexicana.</li>
      <li>Te comprometes a usar la Plataforma de modo lícito y respetuoso, sin vulnerar derechos de terceros.</li>
      <li>Eres responsable de la veracidad y exactitud de los datos que proporciones.</li>
    </ul>

    <h2>5. Funcionamiento de la calculadora</h2>
    <p>
      Los resultados dependen de la calidad de la información capturada (fechas, salario diario/SDI, antigüedad,
      tipo de terminación, etc.). Podrían existir <strong>variaciones</strong> por criterios administrativos o
      jurisdiccionales, topes, UMA vigentes, pruebas, convenios o particularidades del caso.
    </p>

    {{-- Descomenta si activas planes de pago --}}
    {{--
    <h2>6. Pagos y facturación</h2>
    <p>
      Algunas funcionalidades pueden ser de pago. Los precios se mostrarán antes de contratar. Aceptas cubrir los cargos
      e impuestos aplicables. Emitimos factura a solicitud cumpliendo requisitos fiscales vigentes. Puedes cancelar
      conforme a la política indicada en la página de compra.
    </p>
    --}}

    <h2>6. Propiedad intelectual</h2>
    <p>
      El software, interfaces, textos, logotipos, diseños, compilaciones y demás contenidos de la Plataforma son
      propiedad de {{ config('app.name') }} o de sus licenciantes y están protegidos por las leyes aplicables. No
      adquieres derecho alguno sobre ellos. No puedes copiar, descompilar, realizar ingeniería inversa, distribuir,
      rentar, vender o crear obras derivadas sin permiso previo y por escrito.
    </p>

    <h2>7. Uso permitido y prohibido</h2>
    <ul>
      <li>Permitido: uso personal o profesional para estimaciones orientativas, consulta y descarga de resultados para tu expediente.</li>
      <li>Prohibido: usar la Plataforma para fines ilícitos; intentar vulnerar seguridad; extraer datos masivamente (scraping);
        eludir medidas técnicas; publicar o transmitir contenido difamatorio, discriminatorio, ilegal o que infrinja derechos.</li>
    </ul>

    <h2>8. Privacidad y cookies</h2>
    <p>
      El tratamiento de datos personales (p. ej., los que envías en el formulario de contacto) se rige por nuestro
      <a href="{{ route('aviso-privacidad') }}" class="underline">Aviso de Privacidad</a>. Sobre cookies y
      tecnologías similares, consulta la <a href="{{ route('politica-cookies') }}" class="underline">Política de Cookies</a>.
    </p>

    <h2>9. Herramientas de terceros, publicidad y afiliados</h2>
    <p>
      Podríamos integrar servicios de terceros (p. ej., analítica, correo transaccional, publicidad contextual).
      Estos terceros son responsables de sus propias políticas. Si se muestran anuncios o enlaces afiliados, podrían
      generar una compensación sin costo adicional para ti.
    </p>

    <h2>10. Disponibilidad y cambios en la Plataforma</h2>
    <p>
      La Plataforma se ofrece “tal cual” y “según disponibilidad”. Podríamos actualizar, mejorar, suspender o
      descontinuar funciones sin previo aviso para mantener y mejorar el servicio.
    </p>

    <h2>11. Limitación de responsabilidad</h2>
    <p>
      En la medida máxima permitida por la ley, {{ config('app.name') }} no será responsable de daños indirectos,
      incidentales, especiales, punitivos o consecuenciales derivados del uso o imposibilidad de uso de la Plataforma.
      Nuestra responsabilidad total acumulada frente a ti se limitará, en su caso, al monto efectivamente pagado por
      servicios de la Plataforma en los 12 meses previos al evento que dio origen a la reclamación (siempre que existan servicios de pago).
    </p>

    <h2>12. Indemnidad</h2>
    <p>
      Aceptas mantener indemne a {{ config('app.name') }} frente a reclamaciones de terceros derivadas de tu uso de la
      Plataforma en contravención de estos Términos o de la ley aplicable.
    </p>

    <h2>13. Modificaciones a los Términos</h2>
    <p>
      Podremos modificar estos Términos para reflejar cambios legales o funcionales. La versión vigente será la publicada
      en esta página con su <strong>fecha de actualización</strong>. El uso posterior a los cambios implica aceptación.
    </p>

    <h2>14. Ley aplicable y jurisdicción</h2>
    <p>
      Estos Términos se rigen por las leyes de los <em>Estados Unidos Mexicanos</em>. Para la interpretación y cumplimiento,
      las partes se someten a la jurisdicción de los tribunales competentes en el estado de <strong>Puebla, México</strong>,
      renunciando a cualquier otro fuero que pudiera corresponderles por razón de su domicilio presente o futuro.
    </p>

    <h2>15. Contacto</h2>
    <p>
      Si tienes preguntas sobre estos Términos, escríbenos a:
      <a href="mailto:contacto@calculadoraindemnizacion.com">contacto@calculadoraindemnizacion.com</a>.
    </p>

    <hr>

    <p class="text-sm text-gray-600">
      Al usar la Plataforma confirmas que has leído y aceptas estos Términos y Condiciones, el Aviso de Privacidad y la Política de Cookies.
    </p>
  </section>
</div>
@endsection

