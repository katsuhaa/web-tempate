# web-tempate

# Dockerでsymfonyのwebをすぐに立ち上げられるフレームワーク
symfonyは5.4 PHP7.4で作成ずみ　（PHPのバージョン変更でsymfonyのバージョンが変わります）  
symfonyをインストール後、
```
bin/console make:controller
```
でTopControllerを作成した状態　ただし、ROUTEは'/'　twigもresource直下にindex.html.twigを配置してあります。

# データベースを作成し、crudを作成するには？
```
bin/console make:crud
```
