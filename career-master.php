<?php 
include "../dbcon.php";
$errorMsg = '';
if(isset($_POST['from']) && $_POST['from'] == "Delete_Resume"){
    $resumeId = $_POST['resumeId'];
    $res = $conn->query("Select * from resume where id = '$resumeId'");
    if($res->num_rows > 0){
        $row = $res->fetch_assoc();
        try{
            unlink('../assets/resume/'.$row['resumeFile']);
            $conn->query("Delete from resume where id = '$resumeId'");
            if($conn->affected_rows > 0){
                $errorMsg = "<div class=\"p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800\" role=\"alert\"><span class=\"font-medium\">Success!</span> Resume with id $resumeId deleted</div>";
            } else{
                $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> Something went wrong. Try again</div>";
            }
        } catch(Exception $e){
            $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> Unable to delete resume with id $resumeId</div>";
        }
    } else{
        $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> No such resume found</div>";
    }
}
include "header.php";
$resumeData = getResumes();
?>
<section class="text-gray-600 body-font">
    <div class="container px-5 py-5 mx-auto">
        <div class="lg w-full mx-auto overflow-auto">
            <?php echo $errorMsg;?>
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Id
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Resume File
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Fullname
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Email
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Phone
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Date
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($resumeData == null){ ?>
                            <tr>
                                <td class="py-4 px-6 text-center" colspan="7">
                                    No Data to show
                                </td>
                            </tr>
                        <?php } else{ 
                            foreach ($resumeData as $key => $value) { ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="py-4 px-6" id="<?php echo 'resumeId'.$value['id'];?>">
                                        <?php echo $value['id'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'resumeFile'.$value['id'];?>">
                                        <a href="../assets/resume/<?php echo $value['resumeFile'];?>" download><?php echo $value['resumeFile'];?></a>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'resumeFullname'.$value['id'];?>">
                                        <?php echo $value['fullname'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'resumeEmail'.$value['id'];?>">
                                        <?php echo $value['email'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'resumePhone'.$value['id'];?>">
                                        <?php echo $value['phone'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'resumDate'.$value['id'];?>">
                                        <?php echo $value['date'];?>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                          <a target="_blank" href="../assets/resume/<?php echo $value['resumeFile'];?>" class="py-2 px-3 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">View</a>
                                          <form method="POST">
                                            <input type="hidden" name="resumeId" value="<?php echo $value['id'];?>">
                                            <button type="submit" name="from" value="Delete_Resume" class="py-2 px-3 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" onclick="return confirm('Are you sure to delete the selected Resume?');">Delete</button>
                                          </form>
                                        </div>
                                    </td>
                                </tr>
                           <?php } 
                       }?>       
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<?php include "footer.php";?>
