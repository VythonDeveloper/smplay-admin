<?php 
$marketId = '';
if(isset($_GET['marketId'])){
    $marketId = $_GET['marketId'];
}else{
    header("Location:market-list.php");
}
$marketData = getMarketDetails($marketId);

include "header.php";
?>

<form method="POST" action="./controllers/market-controller.php">
    <input type="hidden" name="marketId" value="<?php echo $marketData['id'];?>">
    <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Title</label>
            <input type="text" id="title" name="title" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Market Title" required value="<?php echo $marketData['title'];?>">
        </div>
        <div class="relative z-0 w-full mb-6 group">
        <label for="marketStatus" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Market Status</label>
            <label class="relative inline-flex items-center mr-5 cursor-pointer">
                <input type="checkbox" value="Active" class="sr-only peer" id="marketStatus" name="marketStatus" onchange="changeToggleLabel();" <?php echo $marketData['status'] == "Active" ? "checked" : "";?>>
                <div class="w-11 h-6 bg-red-300 rounded-full peer light:bg-gray-700 peer-focus:ring-4 peer-focus:ring-green-300 light:peer-focus:ring-green-800 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all light:border-gray-600 peer-checked:bg-green-600"></div>
                <span class="ml-3 text-sm font-medium text-gray-900 light:text-gray-300" id="marketStatusLabel">Market is Active</span>
            </label>
        </div>
    </div>
    <div class="grid md:grid-cols-4 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
            <label for="bidOpenTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Bid Open Time</label>
            <input type="time" id="bidOpenTime" name="bidOpenTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required value="<?php echo $marketData['bidOpenTime'];?>">
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="bidCloseTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Bid Close Time</label>
            <input type="time" id="bidCloseTime" name="bidCloseTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required value="<?php echo $marketData['bidCloseTime'];?>">
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="resultOpenTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Result Open Time</label>
            <input type="time" id="resultOpenTime" name="resultOpenTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required value="<?php echo $marketData['resultOpenTime'];?>">
        </div>
        <div class="relative z-0 w-full mb-6 group">
            <label for="resultCloseTime" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Result Close Time</label>
            <input type="time" id="resultCloseTime" name="resultCloseTime" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" required value="<?php echo $marketData['resultCloseTime'];?>">
        </div>
    </div>
    <button type="submit" name="pathAction" value="Update-Satta-Market" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save Market</button>
</form>

<script>
    function _(el){
        return document.getElementById(el);
    }

    changeToggleLabel();
    function changeToggleLabel(){
        if(_("marketStatus").checked){
            _("marketStatusLabel").innerHTML = "Market is Active";
        } else{
            _("marketStatusLabel").innerHTML = "Market is Inactive";
        }
    }
</script>
<?php include "footer.php";?>