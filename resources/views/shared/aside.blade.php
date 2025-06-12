<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link " href="{{ route('home') }}">
          <i class="bi bi-grid"></i>
          <span>Admin</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-cart-check-fill"></i><span>Ventas</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{ route('ventas-nuevas') }}">
              <i class="bi bi-circle"></i><span>Vender Producto</span>
            </a>
          </li>
          <li>
            <a href="{{ route('detalles_ventas.index') }}">
              <i class="bi bi-circle"></i><span>Consultar Ventas</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('productos.index') }}">
          <i class="bi bi-journal-text"></i>
          </i><span>Productos</span>
        </a> 
      </li><!-- End Forms Nav -->

     
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('recepciones.index') }}">
          <i class="bi bi-tools"></i>
          <span>Recepcion de Equipos</span>
        </a>
      </li>
     
      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
          <i class="fa-solid fa-file-invoice-dollar"></i><span>Cotizaciones</span>
        </a>
        
      </li><!-- End Charts Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('inventario.index') }}">
          <i class="bi bi-journal-text"></i><span>Inventario</span>
        </a>
        
      </li><!-- End Icons Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('clientes.index') }}">
          <i class="fa-solid fa-user-tie"></i><span>Clientes</span>
        </a>
        
      </li
      <!-- End Profile Page Nav -->

      <!-- End Contact Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('usuarios.index') }}">
          <i class="bi bi-person-circle"></i>
          <span>Usuarios</span>
        </a>
      </li>
      

      <!-- End Error 404 Page Nav -->

      <!-- End Blank Page Nav -->

    </ul>

  </aside>