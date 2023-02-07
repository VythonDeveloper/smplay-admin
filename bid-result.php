<?php 
include "header.php";
$marketList = getSattaMarkets();
$selectedDate = $_GET['date'] ?? date('l d M, Y');
$marketResult = getMarketResult($selectedDate);
// print_r($marketResult);
$date = date('Y-m-d');
$end_date = '2023-02-01';
?>

<div class="grid md:grid-cols-3 md:gap-6">
    <div class="col-span-1">
        <p class="text-center font-medium mb-5 text-green-700"><?php echo $selectedDate;?></p>
        <ul class="w-full text-sm text-gray-900 bg-white border border-gray-200 rounded-lg light:bg-gray-700 light:border-gray-600 light:text-white">
            <li class="w-full px-4 py-2 border-b border-gray-200 rounded-t-lg light:border-gray-600 font-medium">Current Date</li>
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
            <li class="w-full px-4 py-2 rounded-b-lg font-medium">Starting Date</li>
        </ul>
    </div>

    
    <div class="col-span-2">
        <form method="POST" action="./controllers/bid-result-controller.php">
            <?php foreach($marketList as $value){?>
                <input type="hidden" id="marketDate" name="marketDate" value="<?php echo $selectedDate;?>">
                <input type="hidden" id="marketId_<?php echo $value['id'];?>" name="marketIds[]" value="<?php echo $value['id'];?>">
                <div class="grid md:grid-cols-4 md:gap-6">
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="market_<?php echo $value['id'];?>" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Market - <?php echo $value['resultOpenTime'];?> Hrs</label>
                        <input type="text" id="market_<?php echo $value['id'];?>" name="markets[]" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500" placeholder="Market Title" value="<?php echo $value['title'];?>" readonly>
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="openScore_<?php echo $value['id'];?>" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Open</label>
                        <input type="number" id="openScore_<?php echo $value['id'];?>" name="openScores[]" maxlength="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="***" onkeyup="calculateJodi('<?php echo $value['id'];?>')" oninput="this.value=this.value.slice(0,this.maxLength)" value="<?php echo $marketResult[$value['id']]['openScore'] ?? '';?>">
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="jodiScore_<?php echo $value['id'];?>" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Jodi</label>
                        <input type="text" id="jodiScore_<?php echo $value['id'];?>" name="jodiScores[]" maxlength="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="**" readonly value="<?php echo $marketResult[$value['id']]['jodiScore'] ?? '';?>">
                    </div>
                    <div class="relative z-0 w-full mb-6 group">
                        <label for="closeScore_<?php echo $value['id'];?>" class="block mb-2 text-sm font-medium text-gray-900 light:text-white">Close</label>
                        <input type="number" id="closeScore_<?php echo $value['id'];?>" name="closeScores[]" maxlength="3" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 light:bg-gray-700 light:border-gray-600 light:placeholder-gray-400 light:text-white light:focus:ring-blue-500 light:focus:border-blue-500 tracking-[.50em]" placeholder="***" onkeyup="calculateJodi('<?php echo $value['id'];?>')" oninput="this.value=this.value.slice(0,this.maxLength)" value="<?php echo $marketResult[$value['id']]['closeScore'] ?? '';?>">
                    </div>
                </div>
            <?php  } ?>
            <button type="submit" name="pathAction" value="Post-Bid-Result" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 float-right">Post Result</button>
        </form>
    </div>
    
</div>

<script>
    function _(el){
        return document.getElementById(el);
    }

    function calculateJodi(id){
        let openScore = _("openScore_"+id).value;
        let closeScore = _("closeScore_"+id).value;
        let openJodi = '*';
        let closeJodi = '*';
        if(openScore.length == 3){
            openSum = 0;
            while (openScore) {
                openSum += openScore % 10;
                openScore = Math.floor(openScore / 10);
            }
            if(openSum < 10){
                openJodi = openSum;
            } else{
                openJodi = Math.floor(openSum % 10);
            }
        } else{
            openJodi = '*';
        }

        if(closeScore.length == 3){
            closeSum = 0;
            while (closeScore) {
                closeSum += closeScore % 10;
                closeScore = Math.floor(closeScore / 10);
            }
            if(closeSum < 10){
                closeJodi = closeSum;
            } else{
                closeJodi = Math.floor(closeSum % 10);
            }
        } else{
            closeJodi = '*';
        }

        _("jodiScore_"+id).value = openJodi.toString() + closeJodi.toString();
    }
</script>
<?php include "footer.php";?>