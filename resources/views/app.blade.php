<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico?v=2">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png?v=2">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=2">

    <!-- Social Media Preview (Open Graph for WhatsApp, LinkedIn, Facebook, etc.) -->
    <meta name="description" content="KI-gestütztes Ticket-Management System - Enodia Software">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://project-x-ki.laravel.cloud/">
    <meta property="og:site_name" content="Project-X KI">
    <meta property="og:title" content="Project-X KI | Enodia Software">
    <meta property="og:description" content="KI-gestütztes Ticket-Management System">
    <meta property="og:image" content="https://project-x-ki.laravel.cloud/images/project-x-bg.png">
    <meta property="og:image:secure_url" content="https://project-x-ki.laravel.cloud/images/project-x-bg.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="1024">
    <meta property="og:image:alt" content="Project-X KI Logo">

    <!-- Twitter / X -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="https://project-x-ki.laravel.cloud/">
    <meta name="twitter:title" content="Project-X KI | Enodia Software">
    <meta name="twitter:description" content="KI-gestütztes Ticket-Management System">
    <meta name="twitter:image" content="https://project-x-ki.laravel.cloud/images/project-x-bg.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>