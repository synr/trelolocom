<?php

// error_reporting(E_ALL | E_STRICT);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);


global $page;
$page = new stdClass();

main();


function main(){
    doRouter();
}


function doRouter(){
  global $page;
  // print_r($_GET);
  $q = $_GET['q'];
  if(preg_match('/^\/([bc])\/([^\/]+)/',$q,$match_arr)){
    if($match_arr[1] == 'b'){
      global $boardID;
      $boardID = $match_arr[2];
      // $url = "https://trello.com/b/$boardID.json?key=83beeb78133c736dc20c54e319b7564b";
      // print($url."\n");
      // $json = file_get_contents($url);
      // print($json);
      // exit;
      // print($json."\n");
      // $data = json_decode($json);
      // $page->data = $data;
      // $json2 = get_data($url);
      // print($json2."\n");
      // exit;

    }
    if($match_arr[1] == 'c'){
      global $cardID;
      $cardID = $match_arr[2];

    }
    
  }
  // print_r($page);
}

?>


<!doctype html>
<html lang="zh-hant"  ng-app="page">
<head>
	<meta charset="UTF-8">
	<title>Trelolo.com</title>
	<link rel="stylesheet" href="/css/skeleton.css">
	<link rel="stylesheet" href="/css/style.css">
    <script src="https://code.angularjs.org/snapshot/angular.js"></script>
    <script src="https://code.angularjs.org/snapshot/angular-sanitize.js"></script>
    <script src="https://cdn.rawgit.com/showdownjs/showdown/develop/dist/showdown.min.js"></script>
	<meta property="og:url" content="https://trelolo.com" />
<!--    <meta property="og:type"               content="article" />-->
    <meta property="og:title" content="Trelolo.com" />
    <meta property="og:description" content="Trelolo 是一個把你的 Trello 公開板轉成網站的服務" />
    <meta property="og:image"  content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  // ga('create', 'UA-106608292-1', 'auto');

</script>
<script>
  <?php global $cardID; if(!empty($cardID)){?>
    window.cardID = '<?php echo $cardID; ?>';
  <?php } ?>
  <?php global $boardID;  if(!empty($boardID)){?>
    window.boardID = '<?php echo $boardID; ?>';
  <?php } ?>
  
</script>
</head>


<body  ng-controller="MgCtrl as ctl">


<header style="background-image: url({{bgImage}});-webkit-background-size: cover;background-color: {{bgColor}};">
    <h1><a style="color: {{bgTextColor}};" href="/b/{{boardID}}">{{myData.name}}</a></h1>
</header>
<nav>
    <ul>
        <li ng-repeat="parent in menu">
            <span ng-if="parent.url=='#'">
                {{parent.title}}
            </span>
            <a href="{{parent.url}}" ng-click="changeContent($event)" ng-if="parent.url!='#' && parent.url.substr(0,4) != 'http'">
            {{parent.title}}
            </a>
            <a href="{{parent.url}}" target="_blank" ng-if="parent.url!='#' && parent.url.substr(0,4) == 'http'">
            {{parent.title}}
            </a>
            <ul>
                <li ng-repeat="child in parent.children">
                    <span ng-if="child.url=='#'">
                        {{child.title}}
                    </span>
                    <a href="{{child.url}}" ng-click="changeContent($event)" ng-if="child.url != '#' && child.url.substr(0,4) != 'http'">{{child.title}}</a>
                    <a href="{{child.url}}" target="_blank" ng-if="child.url.substr(0,4) == 'http'">{{child.title}}</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>
<main>
  <h1 ng-show="!isHome">{{title}}</h1>
   <div ng-bind-html="content"></div>
   <section ng-if="isTreloloDotCom && isHome || cardID == 'qjwlxr7W'" id="transfer-url-to-trelolo">
     <label for="url-from-trello"><h3>貼上你的 Trello 看板網址<br>立刻轉成 Trelolo 網站 </h3></label>
      <input id="url-from-trello" type="text" placeholder="https://trello.com/b/XAL44x7M" ng-model="urlFromTrello" ng-change="doTransUrlToTrelolo()">
      
      <div ng-show="urlFromTrello">
          <button ng-click="doCopyText()">點這裡複製</button>&nbsp;&nbsp;<a href="{{urlToTrelolo}}" target="_blank">或是點此連結前往你的網站</a>
          <input class="url-to-trelolo" ng-model="urlToTrelolo">
      </div>
       
   </section>
    
</main>
<footer>
    Copyright © 2017 <a href="http://trelolo.com/">trelolo.com</a>
</footer>


<script src="/js/script.js"></script>

</body>
</html>