<!DOCTYPE html>
<html lang="pt-br">



<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
	<title>${config_site_title} | Dashboard</title>
	@(admin.layout.maincss)

	<!-- chartist CSS -->
	<link href="${baseUri}/view/admin/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
	<link href="${baseUri}/view/admin/assets/plugins/chartist-js/dist/chartist-init.css" rel="stylesheet">

</head>


<body class="hold-transition sidebar-mini">
	<div class="wrapper">
		@(admin.layout.topo)
		@(admin.layout.menu-lateral)
		<div class="content-wrapper">

			<div class="content-header">
				<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-sm-6">
							<h1 class="m-0">Dashboard</h1>
						</div>
						<div class="col-sm-6">
							<ol class="breadcrumb float-sm-right">
								<li class="breadcrumb-item"><a >Home</a></li>
								<li class="breadcrumb-item active">Dashboard</li>
							</ol>
						</div>
					</div>
				</div>
			</div>
			<div class="content">
				<div class="container-fluid">
					<h4>Dashboard em desenvolvimento...</h4>
				</div>
			</div>
		</div>
		<aside class="control-sidebar control-sidebar-dark">
		</aside>

		@(admin.layout.footer)
	</div>

	@(admin.layout.mainjs)
	<script src="${baseUri}/view/admin/assets/plugins/chartist-js/dist/chartist.min.js"></script>
	<script src="${baseUri}/view/admin/assets/plugins/chartist-js/dist/chartist.min.js"></script>

	<script>
		$(".supermenu-dashboard").addClass("menu-open");
		$(".menu-dashboard").addClass("active");
	</script>

</body>

</html>