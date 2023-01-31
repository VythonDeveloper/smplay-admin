<?php 
include "../dbcon.php";
$errorMsg = '';
if(isset($_POST['from']) && $_POST['from'] == "Delete_ContactUs"){
    $contactusId = $_POST['contactusId'];
    $conn->query("Delete from contact_us where id = '$contactusId'");
    if($conn->affected_rows > 0){
        $errorMsg = "<div class=\"p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800\" role=\"alert\"><span class=\"font-medium\">Success!</span> Contact Us query with id $contactusId is deleted.</div>";
    } else{
        $errorMsg = "<div class=\"p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800\" role=\"alert\"><span class=\"font-medium\">Ooops!</span> Something went wrong. Try again</div>";
    }
}
include "header.php";
$contactUsData = getContactUs();
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
                                Fullname
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Email
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Subject
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Message
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
                        if($contactUsData == null){ ?>
                            <tr>
                                <td class="py-4 px-6 text-center" colspan="7">
                                    No Data to show
                                </td>
                            </tr>
                        <?php } else{ 
                            foreach ($contactUsData as $key => $value) { ?>
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="py-4 px-6" id="<?php echo 'contactId'.$value['id'];?>">
                                        <?php echo $value['id'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'contactFullname'.$value['id'];?>">
                                        <?php echo $value['fullname'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'contactEmail'.$value['id'];?>">
                                        <?php echo $value['email'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'contactSubject'.$value['id'];?>">
                                        <?php echo $value['subject'];?>
                                    </td>
                                    <td class="py-4 px-6 maxline2" id="<?php echo 'contactMessage'.$value['id'];?>">
                                        <?php echo $value['message'];?>
                                    </td>
                                    <td class="py-4 px-6" id="<?php echo 'contactDate'.$value['id'];?>">
                                        <?php echo $value['date'];?>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="inline-flex rounded-md shadow-sm" role="group">
                                            <button type="button" class="py-2 px-3 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" onclick="openModal(<?php echo $value['id'];?>);">View</button>
                                            <form method="POST">
                                                <input type="hidden" name="contactusId" value="<?php echo $value['id'];?>">
                                                <button type="submit" name="from" value="Delete_ContactUs" class="py-2 px-3 text-xs font-medium text-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800" onclick="return confirm('Are you sure to delete the selected Contact query?');">Delete</button>
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
<!-- Modal toggle -->
<button style="display: none;" type="button" id="openModalButton" data-modal-toggle="defaultModal">
  Toggle modal
</button>
<!-- Main modal -->
<div id="defaultModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
    <div class="relative w-full h-full max-w-2xl md:h-auto">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white" id="modalTitle"></h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="defaultModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-6 space-y-6">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 text-center" id="modalSubtitle"></p>
                <hr>
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400" id="modalContent"></p>
                <hr>
            </div>
            <!-- Modal footer -->
            <!-- <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-toggle="defaultModal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">I accept</button>
                <button data-modal-toggle="defaultModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600"></button>
            </div> -->
        </div>
    </div>
</div>
<?php include "footer.php";?>
<script type="text/javascript">
    function _(el){
        return document.getElementById(el);
    }
    function openModal(id){
        var fullname = _("contactFullname"+id).innerHTML;
        var subject = _("contactSubject"+id).innerHTML;
        var email = _("contactEmail"+id).innerHTML;
        var message = _("contactMessage"+id).innerHTML;
        var date = _("contactDate"+id).innerHTML;
        // $("#defaultModal").modal();
        _("modalTitle").innerHTML = subject;
        _("modalContent").innerHTML = "<strong>" + message + "</strong>";
        _("modalSubtitle").innerHTML = fullname + ' | ' + email + ' | ' + date;
        _("openModalButton").click();
    }
</script>
