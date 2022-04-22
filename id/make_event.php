<?php
$dir    = '../images/gallery';
$files1 = scandir($dir . '/jkt');
$files2 = scandir($dir . '/bali');
$files3 = scandir($dir . '/fkr');
$files4 = scandir($dir . '/pdyout');

$collections = [];
foreach($files4 as $file) {
    if($file=='.' || $file=='..') {
        continue;
    }

    $collections[] = [
        'title' => 'Samasta Pet Day’s Out',
        'file' => '../images/gallery/pdyout/'.$file
    ];
}

foreach($files3 as $file) {
    if($file=='.' || $file=='..') {
        continue;
    }

    $collections[] = [
        'title' => '',
        'file' => '../images/gallery/fkr/'.$file
    ];
}

foreach($files1 as $file) {
    if($file=='.' || $file=='..') {
        continue;
    }

    $collections[] = [
        'title' => 'Press Release Kamipetz Jakarta',
        'file' => '../images/gallery/jkt/'.$file
    ];
}

foreach($files2 as $file) {
    if($file=='.' || $file=='..') {
        continue;
    }

    $collections[] = [
        'title' => 'Press Release Kamipetz Bali',
        'file' => '../images/gallery/bali/'.$file
    ];
}

$limit = 33;
$page = 1;
$index = 0;
$rolling = 0;
$items = '';

$fileContent = file_get_contents('events_tpl.html');
while($page<=10) {
    $rolling += 1;

    if(isset($collections[$index])) {
        $items .= '<div class="isotope-item col-lg-4 col-md-6 col-sm-12 planning">
                    <div class="vertical-item gallery-item content-absolute text-center ds">
                        <div class="item-media">
                            <img src="'.$collections[$index]['file'].'" alt="">
                            <div class="media-links">
                                <div class="links-wrap">
                                    <a class="p-view prettyPhoto " title="" data-gal="prettyPhoto[gal]" href="'.$collections[$index]['file'].'"></a>
                                </div>
                            </div>
                        </div>
                        <div class="item-content darken_gradient">
                            <h4 class="poppins">
                                <a>'.$collections[$index]['title'].'</a>
                            </h4>
                        </div>
                    </div>
                </div>';
    }

    if($rolling==$limit) {
        $pagging = '';
        for($i=1; $i<=10; $i++) {
            $pagging .= '<li class="'.($page==$i?'active':'').'" style="margin-bottom:5px;" ><a href="events'. ($i>=2?'-'.$i:'') .'.html">'.$i.'</a></li>';
        }

        $fileStore = str_replace('<!-- thumbnail -->', $items, $fileContent);
        $fileStore = str_replace('<!-- page -->', $pagging, $fileStore);
        $fileName = 'events'. ($page>=2?'-'.$page:'') .'.html';
        $fileStore = str_replace('<!-- filename -->', $fileName, $fileStore);

        if(file_exists($fileName)) {
            unlink($fileName);
        }

        file_put_contents($fileName, $fileStore);


        $rolling = 0;
        $page += 1;
        $items = '';
    }
    $index += 1;
}

//print_r($collections);