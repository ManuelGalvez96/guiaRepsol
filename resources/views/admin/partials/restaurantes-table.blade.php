<div class="results-info">
    <p class="results-count">
        @if($restaurantes->count() > 0)
            Mostrando {{ $restaurantes->firstItem() }} - {{ $restaurantes->lastItem() }} de {{ $restaurantes->total() }} restaurantes
            @if(request('buscar'))
                <span class="search-term">para "{{ request('buscar') }}"</span>
            @endif
        @else
            @if(request('buscar') || request('tipo_comida') || request('valoracion') || request('precio'))
                No se encontraron restaurantes con los filtros aplicados
            @else
                No hay restaurantes registrados
            @endif
        @endif
    </p>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Tipo de Comida</th>
                <th>Telefono</th>
                <th>Precio</th>
                <th>Valoración</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($restaurantes as $restaurante)
            <tr>
                <td>
                    @if($restaurante->imagenes->first())
                        <img src="{{ asset($restaurante->imagenes->first()->url) }}" alt="{{ $restaurante->nombre }}" class="restaurant-img">
                    @else
                        <div class="restaurant-img"></div>
                    @endif
                </td>
                <td>{{ $restaurante->nombre }}</td>
                <td>{{ $restaurante->direccion }}, {{ $restaurante->ubicacion->ciudad ?? '' }}</td>
                <td>
                    @if($restaurante->tiposComida->count() > 0)
                        {{ $restaurante->tiposComida->pluck('nombre')->join(', ') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $restaurante->telefono ?? '-' }}</td>
                <td>{{ number_format($restaurante->precio, 2) }}€</td>
                <td>{{ number_format($restaurante->valoracion_promedio, 1) }}</td>
                <td>
                    <div class="action-buttons">
                        <button type="button" class="btn-edit" onclick="openEditModal({{ $restaurante->id }})">✏️</button>
                        <button type="button" class="btn-delete" onclick="deleteRestaurante({{ $restaurante->id }})">🗑️</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center p-40">
                    @if(request('buscar'))
                        No se encontraron restaurantes que coincidan con "{{ request('buscar') }}"
                        <br><small style="color: #666; margin-top: 10px; display: block;">Intenta con otros términos de búsqueda</small>
                    @else
                        No hay restaurantes disponibles
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        {{-- Botón Anterior --}}
        @if($restaurantes->onFirstPage())
            <span class="page-link page-disabled">«</span>
        @else
            <a href="{{ $restaurantes->appends(request()->query())->previousPageUrl() }}" class="page-link">«</a>
        @endif

        {{-- Primera página --}}
        @if($restaurantes->currentPage() > 3)
            <a href="{{ $restaurantes->appends(request()->query())->url(1) }}" class="page-link">1</a>
            @if($restaurantes->currentPage() > 4)
                <span class="page-dots">...</span>
            @endif
        @endif

        {{-- Páginas alrededor de la actual --}}
        @for($i = max(1, $restaurantes->currentPage() - 2); $i <= min($restaurantes->lastPage(), $restaurantes->currentPage() + 2); $i++)
            @if($i == $restaurantes->currentPage())
                <span class="page-link active">{{ $i }}</span>
            @else
                <a href="{{ $restaurantes->appends(request()->query())->url($i) }}" class="page-link">{{ $i }}</a>
            @endif
        @endfor

        {{-- Última página --}}
        @if($restaurantes->currentPage() < $restaurantes->lastPage() - 2)
            @if($restaurantes->currentPage() < $restaurantes->lastPage() - 3)
                <span class="page-dots">...</span>
            @endif
            <a href="{{ $restaurantes->appends(request()->query())->url($restaurantes->lastPage()) }}" class="page-link">{{ $restaurantes->lastPage() }}</a>
        @endif

        {{-- Botón Siguiente --}}
        @if($restaurantes->hasMorePages())
            <a href="{{ $restaurantes->appends(request()->query())->nextPageUrl() }}" class="page-link">»</a>
        @else
            <span class="page-link page-disabled">»</span>
        @endif
    </div>
</div>