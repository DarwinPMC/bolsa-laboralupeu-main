<!-- Correcto: cada campo debe tener el atributo 'label' -->
<x-input-field name="titulo" label="Título de la Oferta" placeholder="Ej: Asistente de Ventas" required />
<x-input-field name="empresa" label="Empresa" value="{{ auth()->user()->name }}" readonly required />
<x-input-field name="ubicacion" label="Ubicación" placeholder="Ciudad, País" required />
<x-input-field name="salario" label="Salario" placeholder="Ej: 1200" />
