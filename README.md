# web-tempate

# Dockerでsymfonyのwebをすぐに立ち上げられるフレームワーク
symfonyは5.4 PHP7.4で作成ずみ　（PHPのバージョン変更でsymfonyのバージョンが変わります）  
TopControllerでメインメニューを作成済み
必要に応じてメニュー項目を増やしてください

# データベースを作成し、crudを作成するには？

## エンティティーを作成
```
bin/console make:entity エンティティー名
```
## 作成したエンティティーを使ったCRUDの作成
```
bin/console make:crud 使用するエンティティー名
```
