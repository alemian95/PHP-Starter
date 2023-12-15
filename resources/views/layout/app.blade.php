<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP Starter</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            font-size: 16px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        html, body, #app {
            min-height: 100vh;
        }

        #app {
            display: grid;
            grid-template-rows: auto 1fr auto;
        }

        nav, footer {
            background: #e3e3e3;
            padding: 0.25rem;
        }

        footer p {
            text-align: center;
        }
    </style>
</head>
<body>

    <div id="app">
        <nav>
            <span>Navbar</span>
            <div>
                @include('components.navlink', [ 'href' => '/', 'text' => 'Home' ])
                @include('components.navlink', [ 'href' => '/test', 'text' => 'Test' ])
                @include('components.navlink', [ 'href' => '/api', 'text' => 'Api↗️', 'new_tab' => true ])
            </div>
        </nav>
        <main>
            @yield('page')
        </main>
        <footer>
            <p>&copy;{{ date('Y') }} | Developed By PHP Starter</p>
        </footer>
    </div>
    
</body>
</html>