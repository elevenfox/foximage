<?php
$action = empty($_REQUEST['action']) ? 'set_path' : $_REQUEST['action'];

if($action == 'load_image') {
    $path = $_REQUEST['image_path'];
    $imagePath = $path;
    header('Content-Type: image/jpeg');
    readfile($imagePath);
}

if($action == 'sort_image') {
    $order = $_REQUEST['order'];
    //$order = explode(',', $order);
    //var_dump($order);
    $i = 1;
    $sufix = time();
    $new_list = [];
    foreach($order as $key => $v) {
        $filename = basename($v);
        $path = str_replace($filename,'', $v);
        $new_name = sprintf('%03d', $i) . '-' . $sufix . '.jpg';
        $new_file_name = $path . $new_name;
        //echo '---- rename '.$v.' to '. $new_file_name ."\n";
        rename($v, $new_file_name);
        $new_list[] = $new_file_name;
        $i++;
    }
    // Remove sufix
    foreach($new_list as $key => $v) {
        $filename = basename($v);
        $path = str_replace($filename,'', $v);
        $new_name_arr = explode('-', $filename);
        $new_name = $new_name_arr[0] . '.jpg';
        $new_file_name = $path . $new_name;
        rename($v, $new_file_name);
    }
}

if($action == 'set_path') {
?>
    <form method="post">
    <input type="text" name="image_path" style="height: 40px;font-size: 14px;min-width: 500px;">
    <input type="hidden" name="action" value="load_path">
    <input type="submit" value="Go" style="height: 40px;padding: 0 25px;">
    </form>
<?php
}

if($action == 'load_path') {
    $image_path = $_REQUEST['image_path'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Sorter</title>
    <style>
        #imageContainer {
            display: flex;
            flex-wrap: wrap;
        }

        .image-item {
            margin: 10px;
            border: 1px solid #ddd;
            padding: 5px;
            cursor: move;
        }
    </style>
</head>
<body>
    <?php 
    
        //$imageFolder = '/home/eric/work/004-tmp2/JVID-婕咪-淫乱剪痴女/'; // Change this to the path of your image folder
        $imageFolder = $image_path;
        
        //$images = glob($imageFolder . '/*.{jpg,png,JPG}'); // Adjust the file extension based on your image types
        $images = glob($imageFolder . "*.{[jJ][pP][gG],[pP][nN][gG],[gG][iI][fF]}", GLOB_BRACE);
        natsort($images);
        echo '<div id="imageContainer">';
        foreach ($images as $image) {
            echo '<div class="image-item" data-src="' . $image . '">';
            echo '<img width="110" src="/misc/00-one-time/tmp_ui_sorting.php?action=load_image&image_path=' . $image . '" alt="Image">';
            //echo '<img src="' . $image . '" alt="Image">';
            echo '</div>';
        }
        echo '</div>';
    
        echo '<button id="confirm">Confirm</button>';
    ?>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {
            let prefix = Math.floor(new Date().getTime() / 1000) + "-";
            let order;
            $("#imageContainer").sortable({
                update: function (event, ui) {
                    // Perform an AJAX request to update the image order on the server
                    order = $(this).sortable('toArray', { attribute: 'data-src' });
                    // console.log('----- this is update....');
                    // console.log(order);
                    //$.post('update_order.php', { order: order });
                }
            });
            $("#imageContainer").disableSelection();

            $('#confirm').on('click', ()=>{
                console.log('----- this is confirm....');
                console.log(order);
                console.log('----- going to post....');
                $.post('/misc/00-one-time/tmp_ui_sorting.php?action=sort_image', { order: order }, (resp)=>{
                    console.log('------- post is done');
                    console.log(resp);
                    // Reload page
                    window.location.reload(true);
                });
            });
        });
    </script>
</body>
</html>
<?php
}
?>