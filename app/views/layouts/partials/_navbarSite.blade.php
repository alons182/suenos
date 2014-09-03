<nav class="menu">
    <ul class="inner">
        <li> <a href="/">Inicio</a> </li>
        <li> <a href="/about">Acerca de Nosotros</a></li>
        <li> <a href="/opportunity">Oportunidad</a></li>
        @if($currentUser)
            <li> {{ link_to_payments()}}</li>
        @endif
        <li> <a href="/contact">Contacto</a></li>
        <li class="store parent"> <span>Tienda</span>
            <ul class="sub-menu">
                <li><a href="#">Celulares</a></li>
                <li><a href="#">Perfumes</a></li>
                <li><a href="#">Ropa</a></li>
                <li><a href="#">Zapatos</a></li>
                <li><a href="#">Servicios</a></li>
            </ul>
        </li>
    </ul>
</nav>