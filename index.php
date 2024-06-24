<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>POS System</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background: url("pos/admin/assets/img/theme/acceuil.jpg") no-repeat;
            background-color: black;
            color: white;
            font-family: 'Nunito', sans-serif;
            font-weight: 500;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
            width: 700px;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            backdrop-filter: blur(9px);
            -webkit-backdrop-filter: blur(9px);
        }



.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.75); /* La dernière valeur (0.5) représente l'opacité (de 0 à 1) */
                backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
}
        
        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        a:hover{
            color: white;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Gestion Alimentation
            </div>

            <div class="links">
                <a href="pos/admin/">Connexion Admin</a>
                <a href="pos/cashier/">Connexion Caissier</a>
                <a href="pos/customer">Connexion Cients</a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>