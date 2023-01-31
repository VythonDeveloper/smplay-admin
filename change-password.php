<?php 
include "header.php";
include "../dbcon.php";

$errorMsg = '';
if(isset($_POST['changeBtn'])){
    $currentPassword = md5($_POST['currentPassword']);
    $newPassword = md5($_POST['newPassword']);
    $confirmPassword = md5($_POST['confirmPassword']);
    $adminId = $_SESSION['adminId'];

    if($newPassword == $confirmPassword){
        $conn->query("Update admin set password = '$newPassword' where id = '$adminId' and password = '$currentPassword'");
        if($conn->affected_rows > 0){
            $errorMsg = "<div class=\"p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800\" role=\"alert\"><span class=\"font-medium\">Success!</span> Password Changed</div>";
        } else{
            $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> Invalid Current Password</div>";
        }
    } else{
        $errorMsg = "<div class=\"p-4 mb-4 text-sm text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-200 dark:text-yellow-800\" role=\"alert\"><span class=\"font-medium\">Warning!</span> New Password and Confirm Password must be same</div>";
    }
}
?>
<section class="text-blueGray-700">
    <div class="container items-center px-5">
        <div class="flex flex-col w-full p-10 my-6 transition duration-500 ease-in-out transform bg-white rounded-lg md:mt-0">
            <div class="mt-6">
                <form method="POST" class="space-y-6 mb-10">
                    <div class="grid grid-cols-1 gap-2 lg:grid-cols-3">
                        <div>
                            <label for="currentPassword" class="block text-sm font-medium text-neutral-600"> Current Password </label>
                            <div class="mt-1">
                                <input
                                    id="currentPassword"
                                    name="currentPassword"
                                    type="password"
                                    required=""
                                    placeholder="**********"
                                    class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300"
                                />
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label for="newPassword" class="block text-sm font-medium text-neutral-600"> New Password </label>
                            <div class="mt-1">
                                <input
                                    id="newPassword"
                                    name="newPassword"
                                    type="password"
                                    required=""
                                    placeholder="************"
                                    class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300"
                                />
                            </div>
                        </div>
                        <div class="space-y-1">
                            <label for="confirmPassword" class="block text-sm font-medium text-neutral-600"> Confirm Password </label>
                            <div class="mt-1">
                                <input
                                    id="confirmPassword"
                                    name="confirmPassword"
                                    type="password"
                                    required=""
                                    placeholder="*************"
                                    class="block w-full px-5 py-3 text-base text-neutral-600 placeholder-gray-300 transition duration-500 ease-in-out transform border border-transparent rounded-lg bg-gray-50 focus:outline-none focus:border-transparent focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-300"
                                />
                            </div>
                        </div>
                    </div>
                    <div>
                        <button
                            type="submit"
                            id="changeBtn"
                            name="changeBtn"
                            class="inline-flex text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                        >
                            Change Password
                            <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </form>
                <?php echo $errorMsg;?>
            </div>
        </div>
    </div>
</section>
<?php include "footer.php";?>
