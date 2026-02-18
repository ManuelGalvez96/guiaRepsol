<div class="results-info">
    <p class="results-count">
        @if($usuarios->count() > 0)
            Mostrando {{ $usuarios->firstItem() }} - {{ $usuarios->lastItem() }} de {{ $usuarios->total() }} usuarios
            @if(request('buscar'))
                <span class="search-term">para "{{ request('buscar') }}"</span>
            @endif
        @else
            @if(request('buscar') || request('rol'))
                No se encontraron usuarios con los filtros aplicados
            @else
                No hay usuarios registrados
            @endif
        @endif
    </p>
    <br>
</div>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellidos</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Fecha de registro</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id }}</td>
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->apellidos ?? '-' }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <span class="rol-badge rol-{{ $usuario->rol }}">
                        {{ ucfirst($usuario->rol) }}
                    </span>
                </td>
                <td>{{ $usuario->created_at ? $usuario->created_at->format('d/m/Y H:i') : '-' }}</td>
                <td>
                    <div class="action-buttons">
                        <button type="button" class="btn-edit" onclick="openEditUserModal({{ $usuario->id }})">✏️</button>
                        <button type="button" class="btn-delete" onclick="deleteUsuario({{ $usuario->id }})">🗑️</button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center p-40">
                    @if(request('buscar'))
                        No se encontraron usuarios que coincidan con "{{ request('buscar') }}"
                        <br><small class="search-hint">Intenta con otros términos de búsqueda</small>
                    @else
                        No hay usuarios disponibles
                    @endif
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Paginación -->
    <div class="pagination">
        @if($usuarios->onFirstPage())
            <span class="page-link page-disabled">«</span>
        @else
            <a href="{{ $usuarios->appends(request()->query())->previousPageUrl() }}" class="page-link">«</a>
        @endif

        @if($usuarios->currentPage() > 3)
            <a href="{{ $usuarios->appends(request()->query())->url(1) }}" class="page-link">1</a>
            @if($usuarios->currentPage() > 4)
                <span class="page-dots">...</span>
            @endif
        @endif

        @for($i = max(1, $usuarios->currentPage() - 2); $i <= min($usuarios->lastPage(), $usuarios->currentPage() + 2); $i++)
            @if($i == $usuarios->currentPage())
                <span class="page-link active">{{ $i }}</span>
            @else
                <a href="{{ $usuarios->appends(request()->query())->url($i) }}" class="page-link">{{ $i }}</a>
            @endif
        @endfor

        @if($usuarios->currentPage() < $usuarios->lastPage() - 2)
            @if($usuarios->currentPage() < $usuarios->lastPage() - 3)
                <span class="page-dots">...</span>
            @endif
            <a href="{{ $usuarios->appends(request()->query())->url($usuarios->lastPage()) }}" class="page-link">{{ $usuarios->lastPage() }}</a>
        @endif

        @if($usuarios->hasMorePages())
            <a href="{{ $usuarios->appends(request()->query())->nextPageUrl() }}" class="page-link">»</a>
        @else
            <span class="page-link page-disabled">»</span>
        @endif
    </div>
</div>
