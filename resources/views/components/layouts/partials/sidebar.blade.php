  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">VisualMaster</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Dario Ronquillo</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <!-- Inicio -->
          <li class="nav-item">
              <a href="{{route('inicio')}}" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>
                  Inicio
                </p>
              </a>
          </li>

          <!-- Categorias -->          
          <li class="nav-item">
              <a href="{{route('categories')}}" class="nav-link">
                <i class="nav-icon fas fa-th-large"></i>
                <p>
                  Categorias
                </p>
              </a>
          </li>

          <!-- Productos -->          
          <li class="nav-item">
              <a href="{{route('products')}}" class="nav-link">
                <i class="nav-icon fas fa-store"></i>
                <p>
                  Productos
                </p>
              </a>
          </li>

          <!-- Proveedores -->          
          <li class="nav-item">
              <a href="{{route('providers')}}" class="nav-link">
                <i class="nav-icon fas fa-store-alt"></i>
                <p>
                  Proveedores
                </p>
              </a>
          </li>
          
          <!-- Categoria de activos -->          
          <li class="nav-item">
              <a href="{{route('categoact')}}" class="nav-link">
                <i class="nav-icon fas fa-paw"></i>
                <p>
                  Categorias Activos
                </p>
              </a>
          </li>

          <!-- Empresa de activos -->          
          <li class="nav-item">
              <a href="{{route('enterprise')}}" class="nav-link">
                <i class="nav-icon fas fa-hospital-user"></i>
                <p>
                  Empresas de Activos
                </p>
              </a>
          </li>

          <!-- Medida -->          
          <li class="nav-item">
              <a href="{{route('measurement')}}" class="nav-link">
                <i class="nav-icon fas fa-balance-scale"></i>
                <p>
                  Medida de Activos
                </p>
              </a>
          </li>

          <!-- Activos vivos cerdos -->          
          <li class="nav-item">
              <a href="{{route('farms')}}" class="nav-link">
                <i class="nav-icon fas fa-piggy-bank"></i>
                <p> 
                  Cerdos
                </p>
              </a>
          </li>

          <!-- Usuarios -->          
          <li class="nav-item">
              <a href="{{route('users')}}" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p> 
                  Usuarios
                </p>
              </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>