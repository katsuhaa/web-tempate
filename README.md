# web-tempate

# Dockerでsymfonyのwebをすぐに立ち上げられるフレームワーク
symfonyは5.4 PHP7.4で作成ずみ　（PHPのバージョン変更でsymfonyのバージョンが変わります）  
TopControllerでメインメニューを作成済み
必要に応じてメニュー項目を増やしてください

最初のユーザーはアドミン権限がつきます

# データベースを作成し、crudを作成するには？

## エンティティーを作成
```
bin/console make:entity エンティティー名
```
## 作成したエンティティーを使ったCRUDの作成
```
bin/console make:crud 使用するエンティティー名
```

＃このプロジェクトでは雛形に加え、以下のコマンドを実行

mail address:no-replay@example.com

```
bin/console make:user
bin/console doctrine:schema:update --dump-sql --complete
bin/console doctrine:schema:update --dump-sql --complete --force
bin/console make:auth
--  Login form authenticator を選択
bin/console make:registration-form
bin/console make:reset-password  # usernameで作成する場合はこのバンドルが使えない
bin/console make:crud User
```


