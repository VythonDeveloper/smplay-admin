<?php include "header.php";?>

<form method="POST" action="./controllers/notification-controller.php">
    <div class="grid md:grid-cols-4 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="priority" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Priority</label>
            <div class="flex items-center mb-4">
                <input id="country-option-1" type="radio" name="priority" value="Important" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-red-300 light:focus:ring-red-600 light:focus:bg-red-600 light:bg-gray-700 light:border-gray-600 checked:bg-red-700" checked>
                <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 light:text-gray-300">
                Important
                </label>
            </div>
            <div class="flex items-center mb-4">
                <input id="country-option-2" type="radio" name="priority" value="Normal" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 light:focus:ring-blue-600 light:focus:bg-blue-600 light:bg-gray-700 light:border-gray-600">
                <label for="country-option-2" class="block ml-2 text-sm font-medium text-gray-900 light:text-gray-300">
                Normal
                </label>
            </div>
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Heading</label>
            <input type="text" id="title" name="title" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Heading" required>
        </div>
        <div class="relative z-0 w-full mb-6 group col-span-2">
            <label for="content" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Message Content</label>
            <textarea id="content" name="content" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Type content here ...."></textarea>
        </div>
    </div>
    <button type="submit" name="pathAction" value="Push-Notification" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center light:bg-blue-600 light:hover:bg-blue-700 light:focus:ring-blue-800">Send Notification</button>
</form>

<?php include "footer.php";?>