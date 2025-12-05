@component('mail::message')
# Nuevo mensaje de contacto

**Nombre:** {{ $data['nombre'] }}  
**Correo:** {{ $data['email'] }}

**Mensaje:**
> {{ $data['mensaje'] }}

@component('mail::subcopy')
Este mensaje fue enviado desde el formulario de contacto de {{ config('app.name') }}.
@endcomponent
@endcomponent
