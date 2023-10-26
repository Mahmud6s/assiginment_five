<!DOCTYPE html>
<html>

<head>
    <title>Registration Form</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex justify-center items-center">
    <div class="bg-white p-8 rounded shadow-md w-1/2">
        <h1 class="text-3xl font-semibold mb-4">Registration Form</h1>
        <form method="post" action="process_registration.php">
            <div class="mb-4">
                <label for="username" class="block font-medium text-gray-700">Username:</label>
                <input type="text" name="username" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="email" class="block font-medium text-gray-700">Email:</label>
                <input type="email" name="email" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label for="password" class="block font-medium text-gray-700">Password:</label>
                <input type="password" name="password" required
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="flex items-center justify-between">
                <button type="submit"
                    class="w-2/3 bg-blue-500 text-white font-semibold p-2 rounded-lg hover:bg-blue-600">Register</button>
                    <a href="login_form.php" class="text-blue-500 ml-4 inline-block py-2 px-4 bg-blue-200 hover:bg-blue-200 rounded-full transition duration-300">Login</a>

            </div>
        </form>
    </div>
</body>

</html>
