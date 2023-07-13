<link href="${baseUri}/view/tema/components/header/header.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg fixed-top bg-body-tertiary">
    <div class="container d-flex w-100">
        <a class="navbar-brand" href="${baseUri}"><img src="${baseUri}/media/site/${config_site_logo}" class="logo-site"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="navbar-nav my-2 my-lg-0 ">
                <li class="nav-item">
                    <a class="nav-link" href="${baseUri}/imovel/lista?negociation=venda">Comprar</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="${baseUri}/imovel/lista?negociation=aluguel">Alugar</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="${baseUri}/imovel/lista">Descobrir</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="${baseUri}/imovel/anuncie">Venda ou Alugue</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="${baseUri}/imovel/administracao">Administração</a>
                </li>

                <?php if (isset($data['paginasTopo']) && is_array($data['paginasTopo']) && sizeof($data['paginasTopo']) > 0) : ?>
                    <?php foreach ($data['paginasTopo'] as $pag) : ?>
                        <!-- Paginas -->
                        <?php if (isset($pag->paginas) && is_array($pag->paginas) && sizeof($pag->paginas) > 0) : ?>
                            <?php foreach ($pag->paginas as $pages) : ?>                                
                                <li class="nav-item">
                                    <a class="nav-link" href="<?= Http::base() ?>/pagina/<?= $pag->categoria_pagina_url ?>/<?= $pages->pagina_url ?>"><?= $pages->pagina_titulo ?></a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <!-- FIm paginas -->
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>