


<!--header--><!--header--><!--header-->
<!--header--><!--header--><!--header-->
<!--header--><!--header--><!--header-->
<header class="header">
        <!-- Top Bar -->

        <div class="top_bar">
          <p>Para mayor información puedes comunicarte al 8343182700 Ext.104, 123, 121 &#128241;</p>
        </div>
        <!-- Header Main -->
        <div class="header_main">
            <div class="cont-menu">
                <div class="row justify-content-between">
                    <!-- Logo -->
                    <div class="col-lg-3 col-sm-3 col-1 order-1">
                      <a href="{{ url('') }}">
                        <div class="logo_container">
                            <div class="logo">

                            </div>
                        </div>
                      </a>
                    </div>
                    <!-- BArra de busqueda -->
                    <div class="col-lg-5 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <input type="search" id="inp_bus" required="required" class="header_search_input" placeholder="Buscar tus productos">
                                    <button type="submit" onclick="buscar()" class="header_search_button trans_300" value="Submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Deseados -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                          <div class="dropdown">
                          <a class="dropbtn">
                            <div class="wishlist d-flex flex-row align-items-center justify-content-end">                                <!--<div class="wishlist_icon"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918681/heart.png" alt=""></div>-->
                                <div class="wishlist_content">
                                    @if(auth()->user())
                                        <input type="hidden" id="isUser" value="true">
                                        <div class="wishlist_text" style="display:none;" id='nombre_persona'>
                                            @if(auth()->user()->nombre)
                                            {{auth()->user()->nombre }} {{ auth()->user()->paterno}}
                                            @else
                                            {{auth()->user()->nombre_completo }}
                                            @endif
                                        </div>
                                        <div style="display: none;" id="genero">
                                            @if(auth()->user()->genero)
                                                {{auth()->user()->genero}}
                                            @else
                                                0
                                            @endif
                                        </div>
                                    @else
                                    <div id="btn_iniciosesion" class="CW-101">Inicia sesión</div>
                                    @endif
                                  <h5>
                                      <div class="wishlist_text" id="saludo">Bienvenido</div>
                                      <div class="bienvenido-name" id="bienvenido"></div>
                                  </h5>
                                </div>
                            </div>
                          </a>
                          <div class="dropdown-content">
                            @if(auth()->user())
                            <form class="" action="{{ route('logout') }}" method="POST">
                                {{ csrf_field() }}
                                <a href="{{ url('cliente') }}">Cuenta</a>
                                <button onclick="limpiarHeader()" class="BTN-CS" >Cerrar sesión</button>
                            </form>

                            @else
                                <a href="{{ url('login') }}">Iniciar sesion</a>
                                <a href="{{ url('UserRegistrationForm') }}">Crear cuenta</a>
                            @endif
                          </div>
                        </div>

                            <!-- Carrito -->
                            <a href="{{ route('carrito')}}">
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon"> <img data-src="{{ asset('/img/icons/carro-de-la-compra.svg')}}" alt="" class="lazyload">
                                        <div class="cart_count"><span id="tot_carr_num_h">0</span></div>
                                    </div>
                                    <div class="cart_content">
                                        <div class="cart_text">Carrito</div>
                                        <div id="tot_carr_num_txt" class="cart_price">$0.00</div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="NEWnav-menu">
        <nav class="navbar navbar-expand-lg navbar-dark">
          <button class="navbar-toggler btn-menu-text" type="button" data-toggle="collapse" data-target="#main_nav">
            Menu <i class="fas fa-bars"></i>
          </button>
          <div class="collapse navbar-collapse" id="main_nav">
            <ul class="navbar-nav ">
                <li class="nav-item dropdown ">
                    <a data-toggle="dropdown" class="nav-link" class=""> Departamentos <i class="fas fa-angle-down"></i> </a>
                    <ul class="dropdown-menu fn-35">
                <!--departamento--><!--departamento-->
                  <li class="has-submenu">
                     <a class="dropdown-item principal-drop"> Muebles <i class="fas fa-angle-right"></i> <i class="fas fa-angle-down"></i></a>
                        <div class="megasubmenu dropdown-menu">
                            <div class="row nav-sub-depo">
                            <div class="col-6" >
                                <h6 class="title">Salas</h6>
                                <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/55') }}">Salas </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/41') }}">Love seat</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/18') }}">Centros de entretenimiento</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/37') }}">Juegos de mesas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/196') }}">Reclinables</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/45') }}">Mesas sueltas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/44') }}">Mesas para tv</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/57') }}">Sillones</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/59') }}">Sofá cama</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/43') }}">Mesedoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/24') }}">Consoletas</a>
                                    </li>
                                </ul>
                            </div><!-- end col-3 -->
                            <div class="col-6">
                                <h6 class="title">Recamara</h6>
                                    <ul class="navbar-nav navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/52') }}">Recamara KS</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/179') }}">Recamara QS</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/180') }}">Recamara MAT</a>
                                    </li>
                                    <!--<li class="nav-item ">
                                    <a class="nav-link" href="{{ url('Departamento/2/18') }}">Recamara IND</li>
                                </a>-->
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/6') }}">Bancas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/9') }}">Bases de madera</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/12') }}">Buroes</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/13') }}">Cabeceras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/14') }}">Camas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/19') }}">Closet</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/35') }}">Guardaropa</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/40') }}">Literas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/212') }}">Baules</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/63') }}">Tocadores</a>
                                    </li>
                                    </ul>
                            </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Comedor</h6>
                                  <ul class="navbar-nav navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/22') }}">Comedores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/3') }}">Antecomedores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/11') }}">Bufeteros</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/15') }}">Cantina</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/56') }}">Sillas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/193') }}">Mesas de comedor</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Cocina</h6>
                                  <ul class="navbar-nav navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/20') }}">Cocinetas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/7') }}">Bancos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/30') }}">Despenseros</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Oficina y estudio</h6>
                                  <ul class="navbar-nav navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/31') }}">Escritorios</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/35/282') }}">Sillas ejecutivas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/39') }}">Libreros</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                          <h6 class="title">Bebes</h6>
                            <ul class="navbar-nav list-unstyled">
                              <li class="nav-item ">
                                  <a class="nav-link" href="{{ url('Departamento/12/26') }}">Cunas</a>
                              </li>
                              <li class="nav-item ">
                                  <a class="nav-link" href="{{ url('Departamento/12/192') }}">Sillas</a>
                              </li>
                              <li class="nav-item ">
                                  <a class="nav-link" href="{{ url('Departamento/12/215') }}">Comodas</a>
                              </li>
                            </ul>
                       </div><!-- end row -->
                       </div>
                  </li>
              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                <a class="dropdown-item principal-drop" href="#"> Linea blanca <i class="fas fa-angle-right"></i> <i class="fas fa-angle-down"></i></a>
                        <div class="megasubmenu dropdown-menu">
                            <div class="row nav-sub-depo">
                            <div class="col-6">
                                    <h6 class="title">Cocina</h6>
                                    <ul class="navbar-nav navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/95') }}">Campanas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/99') }}">Estufas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/108') }}">Refrigeradores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/101') }}">Horno de microondas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/102') }}">Hornos empotrables</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/96') }}">Congeladores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/100') }}">Frigobar</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/107') }}">Parrillas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/110') }}">Tanques de gas</a>
                                    </li>
                                    </ul>
                            </div><!-- end col-3 -->
                            <div class="col-6">
                                <h6 class="title">Clima y ventilación</h6>
                                    <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/91') }}">Minisplits</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/97') }}">Aire humedo</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/94') }}">Calentadores de aire</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/111') }}">Ventilador de pedestal</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/112') }}">Ventilador de techo</a>
                                    </li>
                                    </ul>
                            </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Lavado y secado</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/103') }}">Lavadoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/109') }}">Secadoras</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Varios</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/98') }}">Enfriadores de agua</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/93') }}">Boilers</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/2/42') }}">Maquinas de coser</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/4/92') }}">Aspiradoras</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                       </div><!-- end row -->
                       </div>
                  </li>
              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                 <a class="dropdown-item principal-drop" href="#"> Electronica <i class="fas fa-angle-right"></i> <i class="fas fa-angle-down"></i></a>
                    <div class="megasubmenu dropdown-menu">
                      <div class="row nav-sub-depo">
                          <div class="col-6">
                                <h6 class="title">Television y video</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/86') }}">Televisiones</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/83') }}">Soportes para tv</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/88') }}">Video</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Audio y equipos de sonido</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/84') }}">Teatros en casa</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/71') }}">Bocinas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/69') }}">Amplificadores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/76') }}">Equipos modulares</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/70') }}">Autoestereos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/325') }}">Bocinas para auto</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                          <div class="col-6">
                              <h6 class="title">Varios</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/72') }}">Camaras de video</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/3/85') }}">Telefonos</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->


                          <div class="col-6">
                              <h6 class="title">Automotriz</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/23/248') }}">Acumuladores</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                     </div><!-- end row -->
                 </div>
              </li>

              <!--departamento sencillos--><!--departamento sencillos--><!--departamento sencillos-->
              <li><a class="dropdown-item principal-drop" href="{{ url('Departamento/8/132') }}"> Colchones </a></li>

              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                 <a class="dropdown-item principal-drop" href="#"> Computo <i class="fas fa-angle-right"></i><i class="fas fa-angle-down"></i></a>
                    <div class="megasubmenu dropdown-menu">
                      <div class="row nav-sub-depo" >
                          <div class="col-6">
                                <h6 class="title">Computo</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/142') }}">Impresoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/144') }}">Laptops</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/206') }}">Tablets</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/207') }}">Proyectores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/140') }}">Computadoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/10/189') }}">Accesorios para computadoras</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                     </div><!-- end row -->
                 </div>
              </li>

              <!--departamento sencillos--><!--departamento sencillos--><!--departamento sencillos-->
                  <li><a class="dropdown-item principal-drop" href="{{ url('Departamento/7/129') }}"> Celulares </a></li>

              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                 <a class="dropdown-item principal-drop" href="#"> Decoracion <i class="fas fa-angle-right"></i><i class="fas fa-angle-down"></i></a>
                    <div class="megasubmenu dropdown-menu">
                      <div class="row nav-sub-depo">
                          <div class="col-6">
                                <h6 class="title">Decoracion</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/32') }}">Espejos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/49') }}">Percheros</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/80') }}">Relojes de pared</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/134') }}">Arreglos varios</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/297') }}">Esculturas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/133') }}">Arboles</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/286') }}">Bailarinas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/290') }}">Budas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/291') }}">Caballos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/137') }}">Cuadros</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/139') }}">Tapetes</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/151') }}">Cojines</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/315') }}">Portaretratos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/319') }}">Lamparas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/176') }}">Candelabros</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/292') }}">Cajas decorativas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/295') }}">Charolas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/301') }}">Floreros</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/9/305') }}">Jarrones</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                     </div><!-- end row -->
                 </div>
              </li>

              <!--departamento sencillos--><!--departamento sencillos--><!--departamento sencillos-->
                  <li><a class="dropdown-item principal-drop" href="{{ url('Departamento/13/4') }}"> Aparatos de ejercicio </a></li>

              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                 <a class="dropdown-item principal-drop" href="#"> Enseres menores <i class="fas fa-angle-right"></i><i class="fas fa-angle-down"></i></a>
                    <div class="megasubmenu dropdown-menu">
                      <div class="row nav-sub-depo">
                          <div class="col-6">
                                <h6 class="title">Cocina</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/118') }}">Baterías de cocina</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/119') }}">Batidoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/120') }}">Cafeteras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/121') }}">Cuchillos</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/122') }}">Extractores de jugo</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/123') }}">Licuadoras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/127') }}">Sandwiceras</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/128') }}">Vajillas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/162') }}">Tostadores</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/6/170') }}">Sartenes</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                         <div class="col-6">
                            <h6 class="title">Varios</h6>
                            <ul class="navbar-nav list-unstyled">
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ url('Departamento/6/126') }}">Planchas</a>
                                </li>
                            </ul>
                        </div><!-- end col-3 -->
                     </div><!-- end row -->
                 </div>
              </li>

              <!--departamento sencillos--><!--departamento sencillos--><!--departamento sencillos-->
                  <!-- <li><a class="dropdown-item principal-drop" href="{{ url('Departamento/20/81') }}"> Ferreteria </a></li> -->


              <!--departamento sencillos--><!--departamento sencillos--><!--departamento sencillos-->
                  <li><a class="dropdown-item principal-drop" href="{{ url('Departamento/20/81') }}"> Relojes </a></li>

              <!--departamento--><!--departamento-->
              <li class="has-submenu">
                 <a class="dropdown-item principal-drop" href="#"> Blancos <i class="fas fa-angle-right"></i><i class="fas fa-angle-down"></i></a>
                    <div class="megasubmenu dropdown-menu">
                      <div class="row nav-sub-depo">
                          <div class="col-6">
                                <h6 class="title">Blancos</h6>
                                  <ul class="navbar-nav list-unstyled">
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/5/114') }}">Edredones</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/5/113') }}">Almohadas</a>
                                    </li>
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('Departamento/5/116') }}">Protectores</a>
                                    </li>
                                  </ul>
                          </div><!-- end col-3 -->
                     </div><!-- end row -->
                 </div>
              </li>

                </ul>
            </li>

            <li class="nav-item float-right" > <a class="nav-link" href="{{ url('Empresa/QuienesSomos') }}" style="">¿Quienes somos?</a> </li>
            <li class="nav-item float-right Dinamica-menucss" > <a class="nav-link" href="{{ url('Dinamica') }}" style="">¡Participa en el sorteo! <i class="fas fa-trophy" style=""></i></a> </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="{{ url('Empresa/Sucursales') }}"><i class="fas fa-map-marked-alt"></i> Nuestras sucursales</a></li>

        </ul>

          </div> <!-- navbar-collapse.// -->

        </nav>
        </div>
