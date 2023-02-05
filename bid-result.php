<?php 
include "header.php";
$marketList = getSattaMarkets();
$selectedDate = isset($_GET['date']) ? $_GET['date'] :  'Vivek';
echo $selectedDate;
// Start date
$date = date('Y-m-d');
// End date
$end_date = '2023-02-01';
?>

<div class="grid md:grid-cols-3 md:gap-6">
    <div class="col-span-1">
        <ul class="w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg light:bg-gray-700 light:border-gray-600 light:text-white">
            <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg light:border-gray-600">Date</li>
            <?php 
            while (strtotime($date) >= strtotime($end_date)) { 
                $formattedDate = date('l d M, Y', strtotime($date));
                ?>
                <a href='bid-result.php?date=<?php echo $formattedDate;?>'>
                    <li class="w-full px-4 py-2 border-b border-gray-200 light:border-gray-600 hover:bg-gray-300 cursor-pointer <?php echo $selectedDate == $formattedDate ? 'bg-gray-300' : '';?>">
                        
                        <?php 
                        echo $formattedDate;
                        $date = date("Y-m-d", strtotime("-1 day", strtotime($date))); 
                        ?>
                    </li>
                </a>
            <?php } ?>
            <li class="w-full px-4 py-2 rounded-b-lg">Date</li>
        </ul>
    </div>

    <div class="col-span-2">
        <?php foreach($marketList as $value){?>
            <div class="grid md:grid-cols-4 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Market</label>
                    <input type="text" id="title" name="title" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Market Title" value="<?php echo $value['title'];?>" readonly required>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Open</label>
                    <input type="text" id="title" name="title" maxlength="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="***" required>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Jodi</label>
                    <input type="text" id="title" name="title" maxlength="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="**" required>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Close</label>
                    <input type="text" id="title" name="title" maxlength="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="***" required>
                </div>
            </div>
        <?php  } ?>
        <button type="submit" name="pathAction" value="Create-Satta-Market" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 float-right">Post Result</button>
    </div>
</div>

<?php include "footer.php";?>