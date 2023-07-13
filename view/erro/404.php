<!DOCTYPE html>
<html lang="pr-br">

<head>
  <meta charset="UTF-8">
  <link rel="icon" type="image/png" sizes="16x16" href="${baseUri}/media/site/${config_site_favicon}">
  @(tema.quarzar.imports.css)
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Imobiliária</title>
</head>
<style>
    body {
        background-color: #eee;
    }

    .spin {
        animation-name: spin;
        animation-duration: 6000ms;
        animation-iteration-count: infinite;
        animation-timing-function: linear;
    }


    @keyframes spin {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }
</style>

<body>

<div class="row">
    <div class="col-12 col-sm-12 text-center mt-5">        
        <h1 class="text-center">404</h1>
        <h4 class="text-center">Página não encontrada</h4>
    </div>
</div>

  
  <!-- js -->
  @(tema.quarzar.imports.js)
  <!-- js -->
</body>

</html>