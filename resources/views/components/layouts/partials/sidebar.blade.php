<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('porcino.dashboard')}}" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="VisualMaster Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">VisualMaster</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          <!-- Inicio -->
          <li class="nav-item">
              <a href="{{route('porcino.dashboard')}}" class="nav-link">
                <i class="nav-icon fas fa-home"></i>
                <p>Dashboard</p>
              </a>
          </li>
               
          <!-- Inventario -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-boxes"></i>
              <p>
                Inventario
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('categories')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('products')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('providers')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Proveedores</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('compras')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Compras</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Activos -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Activos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('categoact')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías Activos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('enterprise')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Empresas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('measurement')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Medidas</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Gestión Porcina -->
          <li class="nav-item has-treeview">          
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-piggy-bank"></i>
              <p>
                Gestión Porcina
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">   
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('farms') }}">
                      <i class="fas fa-tractor"></i>
                      <span>Granjas</span>
                  </a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="{{ route('barns') }}">
                      <i class="fas fa-warehouse nav-icon"></i>
                      <span>Galpones</span>
                  </a>
              </li>
              <li class="nav-item">
                <a href="{{route('lots')}}" class="nav-link">
                  <i class="far fa-layer-group nav-icon"></i>
                  <p>Lotes</p>
                </a>
              </li>                                      
              <li class="nav-item">
                <a href="{{route('pigs')}}" class="nav-link">
                  <i class="nav-icon fas fa-piggy-bank"></i>
                  <p>Cerdos</p>
                </a>
              </li>
              <li class="nav-item">
                  <a href="{{route('personals')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Personal</p>
                  </a>
              </li>     
              <li class="nav-item">
                  <a href="{{route('categoria-personals')}}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Categorías de Personal</p>
                  </a>
              </li>                       
              <!-- <li class="nav-item">
                <a href="{{route('feeding.dashboard')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alimentación</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('feeding.inventory')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Inventario Alimentos</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('growth.selector')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Engorde</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('welfare.panel')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Bienestar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('feeding.report')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporte</p>
                </a>
              </li> -->
            </ul>
          </li>

          <!-- Alimentacion Y Bienestar -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-warehouse"></i>
              <p>
                Alimentacion 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                  <a class="nav-link" href="{{ route('feeding') }}">
                      <i class="far fa-circle nav-icon"></i>
                      <span>Alimentación</span>
                  </a>                
              </li> 
           
            </ul>
          </li>

          <!-- Administración -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Administración
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('clients')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Clientes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('users')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Usuarios</p>
                </a>
              </li>
            </ul>
          </li>

          <!-- Espacio para futuros módulos -->
          <li class="nav-header">Módulos futuros</li>
          <li class="nav-item">
            <a href="#" class="nav-link disabled">
              <i class="nav-icon fas fa-plus"></i>
              <p>Próximamente...</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>