<!DOCTYPE html>
<style>
    .square{       
    background: #C0C0C0;
    border: 1px dashed #bbb;
    padding: 5px;
    text-align: center;
    display:inline-block;
    width: 10%;
    height: 0; /* A mágica está aqui */
    padding-bottom: 5%; /* ... e está aqui */
    margin: 1px;
    position: relative;
}   
 </style>
 
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Candidatos</title>
    </head>
    <body>
        <div class="titulo"> @yield('titulo')</div>  
        <div class="container"> @yield('conteudo')</div>
        <script src="js/app.js"></script>
    </body>
</html>