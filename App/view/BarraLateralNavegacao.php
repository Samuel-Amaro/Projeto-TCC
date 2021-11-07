<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link" href="PainelControle.php">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Registros
                </a>
                <!--Beneficiarios-->
                <div class="sb-sidenav-menu-heading">Beneficiários</div>
                <!--data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"-->
                <a class="nav-link collapsed" href="FormBeneficiario.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div>
                    Cadastrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <!--
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div>
                    Alterar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div>
                    Deletar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                -->
                <!--  data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts" -->
                <a class="nav-link collapsed" href="ListBeneficiarios.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div>
                    Visualizar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <!--Beneficios-->
                <div class="sb-sidenav-menu-heading">Benefícios</div>
                <!--data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"-->
                <a class="nav-link collapsed" href="FormBeneficio.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Cadastrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="UnidadesMedidasBeneficios.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Unidades medidas benefícios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="CategoriaBeneficios.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Categoria benefícios
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <!--Fornecedores-->
                <div class="sb-sidenav-menu-heading">Fornecedores/Doações</div>
                <a class="nav-link collapsed" href="FormFornecedoresDoacoes.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Cadastrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="ListFornecedoresDoadores.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Visualizar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <!--
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Deletar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-clipboard"></i></i></div>
                    Visualizar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                -->
                <!--
                    data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"
                -->
                <?php
                if($modelUser->getTipoUsuario() === "adm") {
                ?>
                <!--Usuarios(Coolaboradores)-->
                <div class="sb-sidenav-menu-heading">Usuários</div>
                <a class="nav-link collapsed btn-cadastrar-user" href="FormUsuario.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Cadastrar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <a class="nav-link collapsed" href="ListUsuarios.php" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Visualizar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <?php
                }else{
                    //se for usuario do tipo comun, não mostra nada
                } 
                ?>
                
                <!--data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"-->
                <!--
                <a class="nav-link collapsed" href="#" target="_self" rel="next">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Alterar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                -->
                <!--
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Deletar
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                -->
                <!--data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts"-->
                <!--
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="layout-static.html">Static Navigation</a>
                        <a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
                    </nav>
                </div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                    <div class="sb-nav-link-icon"><i class="fas fa-book-open"></i></div>
                    Pages
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">
                            Authentication
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="login.html">Login</a>
                                <a class="nav-link" href="register.html">Register</a>
                                <a class="nav-link" href="password.html">Forgot Password</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">
                            Error
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordionPages">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="401.html">401 Page</a>
                                <a class="nav-link" href="404.html">404 Page</a>
                                <a class="nav-link" href="500.html">500 Page</a>
                            </nav>
                        </div>
                    </nav>
                </div>
                <div class="sb-sidenav-menu-heading">Addons</div>
                <a class="nav-link" href="charts.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                    Charts
                </a>
                <a class="nav-link" href="tables.html">
                    <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                    Tables
                </a>
                -->
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logado como: <?= $modelUser->getNomeUsuario(); ?></div>
        </div>
    </nav>
</div>