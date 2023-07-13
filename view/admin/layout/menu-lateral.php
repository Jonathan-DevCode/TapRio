 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4">
 	<!-- Sidebar -->
 	<div class="sidebar">
 		<!-- Sidebar user panel (optional) -->
 		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
 			<div class="image">

 				<?php if (isset($data['config']->avatar) && !empty($data['config']->avatar)) : ?>
 					<img src="${baseUri}/media/avatar/${avatar}" alt="user" class="img-circle elevation-2" />
 				<?php else : ?>
 					<img src="${baseUri}/media/avatar/nopic.png" alt="user" class="img-circle elevation-2" />
 				<?php endif; ?>

 			</div>
 			<div class="info">
 				<a class="d-block pointer">${uname}</a>
 			</div>
 		</div>


 		<!-- Sidebar Menu -->
 		<nav class="mt-2">
 			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
 				<!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
 				<li class="nav-header">
 					<h6>Gerenciar Conteúdo</h6>
 				</li>
 				<!-- class menu-open no LI para abrir o menu -->
 				<!-- class active no A para marcar o menu inferior -->
 				<?php if (Usuario::verifyPermission("slides") || Usuario::verifyPermission("parceiros")) : ?>
 					<li class="nav-item supermenu-home">
 						<a class="nav-link menu-home">
 							<i class="nav-icon fas fa-home"></i>
 							<p>
 								Home
 								<i class="right fas fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<?php if (Usuario::verifyPermission("slides")) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/slide/" class="nav-link menu-slide">
 										<p>Slides e Banners</p>
 									</a>
 								</li>
 							<?php endif; ?>
 							<?php if (Usuario::verifyPermission("parceiros")) : ?>
 								<!-- <li class="nav-item">
 									<a href="<?= Http::base() ?>/parceiros-lista/" class="nav-link menu-parceiros">
 										<p>Seus Parceiros</p>
 									</a>
 								</li> -->
 							<?php endif; ?>
 							<?php if (Usuario::verifyPermission("paginas")) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/pagina-lista/" class="nav-link menu-pagina-gerenciar">
 										<p>Páginas</p>
 									</a>
 								</li>
 							<?php endif; ?>
 							<?php if (Usuario::verifyPermission("paginas")) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/pagina-categoria/" class="nav-link menu-pagina-categorias">
 										<p>Categorias das páginas</p>
 									</a>
 								</li>
 							<?php endif; ?>
 						</ul>
 					</li>
 				<?php endif; ?>
				<?php if (Usuario::verifyIsAdmin()) : ?>
					<li class="nav-item">
						<a href="<?= Http::base() ?>/sitemap" target="_blank" class="nav-link">
							<i class="nav-icon fas fa-file"></i>
							<p>
								Sitemap XML
							</p>
						</a>
					</li>
				<?php endif; ?>

 				<li class="nav-item">
 					<a href="<?= Http::base() ?>" target="_blank" class="nav-link">
 						<i class="nav-icon fas fa-share"></i>
 						<p>
 							Visite sua Imobiliária
 						</p>
 					</a>
 				</li>

 				<li class="nav-header">
 					<h6>Gerenciar sua Imobiliária</h6>
 				</li>

 				<!-- <li class="nav-item supermenu-dashboard">
 					<a href="<?= Http::base() ?>/admin" class="nav-link menu-dashboard">
 						<i class="nav-icon fas fa-chart-pie"></i>
 						<p>
 							Dashboard
 						</p>
 					</a>
 				</li> -->

 				<?php if (Usuario::verifyPermission("integracoes")) : ?>
 					<li class="nav-item supermenu-integracoes">
 						<a href="<?= Http::base() ?>/integracoes" class="nav-link menu-integracoes">
 							<i class="nav-icon fas fa-share-alt"></i>
 							<p>
 								Integrações XML
 							</p>
 						</a>
 					</li>
 				<?php endif; ?>

 				<?php if (Usuario::verifyPermission("imoveis")) : ?>
 					<li class="nav-item supermenu-imoveis">
 						<a class="nav-link menu-imoveis">
 							<i class="nav-icon fas fa-home"></i>
 							<p>
 								Imóveis
 								<i class="right fas fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">

 							<?php if (Usuario::verifyIsAdmin()) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/imovel-lista-site" class="nav-link menu-imoveis-site">Anúncios de clientes</a>
 								</li>
 							<?php endif; ?>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/imovel-lista" class="nav-link menu-imoveis-gerenciar">Lista completa</a>
 							</li>
 							<?php if (Usuario::verifyPermission('imoveis', 'gerenciar')) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/imovel-novo" class="nav-link menu-imoveis-cadastrar">Cadastrar novo imóvel</a>
 								</li>
 							<?php endif; ?>
 							<?php if (Usuario::verifyPermission('chaves')) : ?>
 								<li class="nav-item">
 									<a href="<?= Http::base() ?>/imovel-chaves" class="nav-link menu-imoveis-chaves">Chaves</a>
 								</li>
 							<?php endif; ?>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/condominio" class="nav-link menu-imoveis-condominios">Lista de Condomínios</a>
 							</li>
 							<!-- <li class="nav-item">
 								<a href="<?= Http::base() ?>/imovel-categoria" class="nav-link menu-imoveis-categorias">Categorias</a>
 							</li>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/modelo" class="nav-link menu-imoveis-modelos">Modelos</a>
 							</li>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/imovel-atributo" class="nav-link menu-imoveis-atributos">Atributos</a>
 							</li>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/caracteristica" class="nav-link menu-imoveis-caracteristicas">Características</a>
 							</li>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/caracteristicaCategoria" class="nav-link menu-imoveis-caracteristicaCategorias">Categorias de Características</a>
 							</li> -->

 						</ul>
 					</li>
 				<?php endif; ?>


 				<?php if (Usuario::verifyPermission("localidades")) : ?>
 					<!-- <li class="nav-item supermenu-localidade">
 						<a class="nav-link menu-frete">
 							<i class="nav-icon fas fa-map-marked-alt"></i>
 							<p>
 								Localidades
 								<i class="right fas fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/cidades" class="nav-link menu-cidades">Cidades
 								</a>
 							</li>
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/bairros" class="nav-link menu-bairros">Bairros
 								</a>
 							</li>
 						</ul>
 					</li> -->
 				<?php endif; ?>

 				<?php if (Usuario::verifyPermission("clientes")) : ?>
 					<li class="nav-item supermenu-clientes">
 						<a href="<?= Http::base() ?>/cliente" class="nav-link menu-clientes">
 							<i class="nav-icon fa fa-user"></i>
 							<p>
 								Clientes
 							</p>
 						</a>
 					</li>
 				<?php endif; ?>
 				<!-- <li class="nav-item supermenu-newsletter">
 					<a href="<?= Http::base() ?>/newsletter" class="nav-link menu-newsletter">
 						<i class="nav-icon fa fa-envelope"></i>
 						<p>
 							Newsletter
 						</p>
 					</a>
 				</li> -->


 				<?php if (Usuario::verifyIsAdmin()) : ?>
 					<li class="nav-header">
 						<h6>Configurações</h6>
 					</li>

 					<li class="nav-item supermenu-contato">
 						<a class="nav-link menu-contato">
 							<i class="nav-icon fas fa-address-card"></i>
 							<p>
 								Dados para Contato
 								<i class="right fas fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview">
 							<li class="nav-item">
 								<a href="<?= Http::base() ?>/configuracao/rede" class="nav-link menu-contato-redes">Redes Sociais
 								</a>
 							</li>
 							<?php if (Session::node("uis_admin") == 'sim') : ?>
 								<li class="nav-item">
									<a href="<?= Http::base() ?>/configuracao/email" class="nav-link menu-contato-email">Email e SMTP
									</a>
								</li>
 							<?php endif; ?>
 						</ul>
 					</li>
 					<li class="nav-item supermenu-informacoes">
 						<a href="<?= Http::base() ?>/configuracao/site" class="nav-link menu-informacoes">
 							<i class="nav-icon fa fa-info-circle"></i>
 							<p>
 								Informações de Exibição
 							</p>
 						</a>
 					</li>
 				<?php endif; ?>
 				<!-- <li class="nav-item supermenu-configuracoes">
 						<a href="<?= Http::base() ?>/configuracao" class="nav-link menu-configuracoes">
 							<i class="nav-icon fa fa-cog"></i>
 							<p>
 								Configurações
 							</p>
 						</a>
 					</li> -->
 				<?php if (Usuario::verifyPermission("usuarios")) : ?>
 					<li class="nav-item supermenu-usuarios">
 						<a href="<?= Http::base() ?>/usuario" class="nav-link menu-usuarios">
 							<i class="nav-icon fa fa-user-circle"></i>
 							<p>
 								Usuários
 							</p>
 						</a>
 					</li>
 				<?php endif; ?>
 				<?php if (Usuario::verifyIsAdmin()) : ?>
 					<li class="nav-item supermenu-log">
 						<a href="<?= Http::base() ?>/usuario/log" class="nav-link menu-log">
 							<i class="nav-icon fa fa-eye"></i>
 							<p>
 								Ações dos usuários
 							</p>
 						</a>
 					</li>
 				<?php endif; ?>

 				<li class="nav-item">
 					<hr>
 					<a href="<?= Http::base() ?>/logout" class="nav-link">
 						<i class="nav-icon fa fa-power-off"></i>
 						<p>
 							Logout / Sair
 						</p>
 					</a>
 				</li>


 			</ul>
 		</nav>
 	</div>
 </aside>