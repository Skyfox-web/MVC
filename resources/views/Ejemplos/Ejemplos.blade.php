@extends('Shared/Layout')


<!--titulo de la pagina-->
<!--titulo de la pagina-->
<!--titulo de la pagina-->
@section('titulo')

@endsection


<!--body--><!--body--><!--body-->
@section('seccion')

<div class="super_container">
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        <div class="top_bar">
            <div class="container">
                <div class="row">
                    <div class="col d-flex flex-row">
                      <div class="top_bar_contact_item">
                          <div class="top_bar_icon"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918577/phone.png" alt=""></div>834 3182700
                      </div>
                      <div class="top_bar_contact_item">
                          <div class="top_bar_icon"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918597/mail.png" alt=""></div><a href="mailto:contacto@muevleria-villarrea.com">contacto@muebleria-villarrea.com</a>
                      </div>
                      <div class="top_bar_content ml-auto">
                          <div class="top_bar_user">
                              <div class="user_icon"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918647/user.svg" alt=""></div>
                              <div><a href="{{ url('UserRegistrationForm') }}">Registrarse</a></div>
                              <div><a href="#LoginPOP">Login</a></div>
                                <div id="LoginPOP" class="popup">
                                    <a href="#" class="close">&times;</a>

                                    <div class="LIInfo-BOX">
                                    <h3>¡Hola de nuevo!</h3>
                                  Inicia sesión con tu correo
                                  electrónico
                                  </div>
                                    <div class="lginBOX">
                                      <input class="marB1" type="text" id="fname" name="fname" placeholder="Correo">
                                      <input type="password" id="fname" name="fname" placeholder="Contraseña">
                                    </div>
                                </div>

                                <a href="#" class="close-popup"></a>

                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div> <!-- Header Main -->
        <div class="header_main">
            <div class="container">
                <div class="row">
                    <!-- Logo -->
                    <div class="col-lg-3 col-sm-3 col-3 order-1">
                        <div class="logo_container">
                            <div class="logo"><a href="#"></a></div>
                        </div>
                    </div> <!-- Search -->
                    <div class="col-lg-5 col-12 order-lg-2 order-3 text-lg-left text-right">
                        <div class="header_search">
                            <div class="header_search_content">
                                <div class="header_search_form_container">
                                    <form action="#" class="header_search_form clearfix"> <input type="search" required="required" class="header_search_input" placeholder="Buscar tus productos">
                                         <button type="submit" class="header_search_button trans_300" value="Submit"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918770/search.png" alt=""></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- Wishlist -->
                    <div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
                        <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                          <a href="#">
                            <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                                <div class="wishlist_icon"><img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918681/heart.png" alt=""></div>
                                <div class="wishlist_content">
                                    <div class="wishlist_text">Deseados</div>
                                    <div class="wishlist_count">10</div>
                                </div>
                            </div>
                          </a>
                            <!-- Cart -->
                            <a href="#">
                            <div class="cart">
                                <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                    <div class="cart_icon"> <img src="https://res.cloudinary.com/dxfq3iotg/image/upload/v1560918704/cart.png" alt="">
                                        <div class="cart_count"><span>3</span></div>
                                    </div>
                                    <div class="cart_content">
                                        <div class="cart_text">Carrito</div>
                                        <div class="cart_price">$185</div>
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- Main Navigation -->
        <nav class="main_nav">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="main_nav_content d-flex flex-row">
                            <!-- Categories Menu -->
                            <!-- Main Nav Menu -->
                            <div class="main_nav_menu">
                                <ul class="standard_dropdown main_nav_dropdown">
                                    <li class="hassubs"> <a href="#">Departamentos<i class="fas fa-chevron-down"></i></a>
                                        <ul>
                                            <li> <a href="{{ url('Departamentos') }}">Muebles<i class="fas fa-chevron-down"></i></a>
                                                <!--<ul>
                                                    <li><a href="#">Lenovo 1<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Lenovo 3<i class="fas fa-chevron-down"></i></a></li>
                                                    <li><a href="#">Lenovo 2<i class="fas fa-chevron-down"></i></a></li>
                                                </ul>-->
                                            </li>
                                            <li><a href="#">Linea Blanca<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Electronica<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Colchones<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Computo<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Celulares<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Decoracion<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Ejercicio<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Enseres<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Infantil<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Ferreteria<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Relojes<i class="fas fa-chevron-down"></i></a></li>
                                            <li><a href="#">Blancos<i class="fas fa-chevron-down"></i></a></li>

                                        </ul>
                                    </li>
                                    <li><a href="#">Inspiracion<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="{{ url('Empresa/QuienesSomos') }}">¿Quienes somos?<i class="fas fa-chevron-down"></i></a></li>
                                    <li><a href="#">Mesa de regalo<i class="fa-gift"></i></a></li>

                                </ul>
                            </div><!-- Menu Trigger -->
                            <div class="menu_trigger_container ml-auto">
                                <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                                    <div class="menu_burger">
                                        <div class="menu_trigger_text">menu</div>
                                        <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav> <!-- Menu -->
        <div class="page_menu">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page_menu_content">
                            <div class="page_menu_search">
                                <form action="#"> <input type="search" required="required" class="page_menu_search_input" placeholder="Search for products..."> </form>
                            </div>
                            <ul class="page_menu_nav">
                                <li class="page_menu_item has-children"> <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children"> <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item"> <a href="#">Home<i class="fa fa-angle-down"></i></a> </li>
                                <li class="page_menu_item has-children"> <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                        <li class="page_menu_item has-children"> <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                            <ul class="page_menu_selection">
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                                <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            </ul>
                                        </li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children"> <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item has-children"> <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                    <ul class="page_menu_selection">
                                        <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page_menu_item"><a href="blog.html">blog<i class="fa fa-angle-down"></i></a></li>
                                <li class="page_menu_item"><a href="contact.html">contact<i class="fa fa-angle-down"></i></a></li>
                            </ul>
                            <div class="menu_contact">
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="images/phone_white.png" alt=""></div>+38 068 005 3570
                                </div>
                                <div class="menu_contact_item">
                                    <div class="menu_contact_icon"><img src="images/mail_white.png" alt=""></div><a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div style="height: 700px"> </div>
</div>
@endsection