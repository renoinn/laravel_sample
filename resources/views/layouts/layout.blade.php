<!DOCTYPE html>
<html>                         
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="ja" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,minimum-scale=1.0,user-scalable=no">

    <meta name="mobile-web-app-capable" content="yes">

    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    <link rel="apple-touch-icon-precomposed" href="images/ios-desktop.png">
    <link rel="stylesheet" href="/bookmarks/assets/css/style.css" type="text/css" media="screen, tv" />

    <title>Bookmarks</title>   
</head>
<body>
<header>
    <h1>SUDO.MKDIR.BOOKMARKS</h1>   
    @auth
    <span><img src="{{Auth::user()->profile_image_url}}" /></span>
    <span><a href="/snapmark/logout">Logout</a></span>
    @endauth                   
</header>
<main>
@yield('content')              
</main>
</body>
</html> 