<?php

echo '==================='.PHP_EOL;
echo 'TrelloSignage 初期設定'.PHP_EOL;
echo '==================='.PHP_EOL;
echo PHP_EOL;
echo 'TrelloSignageを正しく利用するための初期設定を開始します。'.PHP_EOL;

echo '次のURLをブラウザで開いてください。'.PHP_EOL;
echo 'https://trello.com/app-key'.PHP_EOL;
echo 'ブラウザを開き、開発者キーをコピーしてそのまま下に入力してください。'.PHP_EOL.'key:';
$dev_key = trim(fgets(STDIN));

echo 'トークンの準備を行います。'.PHP_EOL;
echo '次のURLをブラウザで開いてください。'.PHP_EOL;
echo 'https://trello.com/1/authorize?key='.$dev_key.'&name=TrelloSignage&expiration=never&response_type=token&scope=read'.PHP_EOL;
echo '承認するとトークンが表示されます。トークンをコピーして、そのまま下に入力してください。'.PHP_EOL.'token:';
$dev_token = trim(fgets(STDIN));

$user = json_decode(file_get_contents('https://trello.com/1/members/me?token='.$dev_token.'&key='.$dev_key));
$fullname = $user->fullName;
$username = $user->username;
echo 'アカウントの接続が完了しました。'.$fullname.'さん('.$username.')としてログインしています。'.PHP_EOL;
echo '次に表示されている内容は、あなたのボード一覧です。表示したいリストはどのボードにありますか？idを入力してください。'.PHP_EOL;
$board = json_decode(file_get_contents('https://api.trello.com/1/members/'.$username.'?fields=username,url&boards=all&board_fields=name&organizations=all&organization_fields=displayName&key='.$dev_key.'&token='.$dev_token));

foreach ($board->boards as $value) {
  echo $value->name.'( '.$value->id.' )'.PHP_EOL;
}

echo 'board id:';
$board_id = trim(fgets(STDIN));

echo '指定されたボード内にあるリストは次の通りです。'.PHP_EOL;
$list = json_decode(file_get_contents('https://trello.com/1/boards/'.$board_id.'/lists?key='.$dev_key.'&token='.$dev_token.'&fields=name'));

foreach ($list as $value) {
  echo $value->name.'( '.$value->id.' )'.PHP_EOL;
}

echo '[実行予定]のリストはどのリストですか？idを入力してください。'.PHP_EOL.'[実行予定]のリストID:';
$list_plans_id = trim(fgets(STDIN));
echo '[実行中]のリストはどのリストですか？idを入力してください。'.PHP_EOL.'[実行中]のリストID:';
$list_running_id = trim(fgets(STDIN));

echo PHP_EOL;

echo '==================='.PHP_EOL;
echo '初期設定完了'.PHP_EOL;
echo '==================='.PHP_EOL;
echo PHP_EOL;

echo '２〜３行目を次のように書き換えてください:'.PHP_EOL;
echo '$cards_running = json_decode(file_get_contents(\'https://api.trello.com/1/lists/'.$list_running_id.'/cards?key='.$dev_key.'&token='.$dev_token.'\'));'.PHP_EOL;
echo '$cards_plans = json_decode(file_get_contents(\'https://api.trello.com/1/lists/'.$list_plans_id.'/cards?key='.$dev_key.'&token='.$dev_token.'\'));'.PHP_EOL;


 ?>
