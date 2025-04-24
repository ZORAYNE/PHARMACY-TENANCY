<!-- resources/views/layouts/default.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Dashboard</title>
    <!-- Include your CSS and JS assets -->
</head>
<body class="bg-gray-100 dark:bg-gray-800">
    <div class="container mx-auto">
        <!-- Include navigation here -->
        <x-navigation />

        <!-- Content -->
        @yield('content')
    </div>
</body>
</html>
