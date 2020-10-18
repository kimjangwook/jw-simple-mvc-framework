# JW Simple MVC Framework

一番簡単な形のMVCフレームワークです。

このフレームワークはフレームワーク・MVCパターンの理解を深めるために作られたものです。

セキュリティーなどは考慮してないので、実際使う時には十分な注意が必要です。

## モデル

すべてのモデルは `model/model.php` を相続して作ることを想定しています。

サポートするタイプは `MySQL`、`SQLite`の2種類です。

理解のため、`model/user.php` ファイルおよび、`database.sqlite`を置いておきました。

モデルを利用したコントローラは `controllers/users/list.php` です。

モデルは `App\Model` の名前空間を使用しています。

## コントローラ

すべてのコントローラは `controllers/base.php` を相続して作ることを想定しています。

PSR-4の名前空間をサポートしているため、フォルダー名に合わせ、名前空間を設定してください。

コントローラは `App\Controllers` の名前空間を使用しています。

基本的にコントローラと同じパスのビューを利用しますが、ビューの変更も可能です。

`$viewPath`のルートは`views`フォルダーです。

```php
class TestController extends BaseController
{
    public $viewPath = '/path/you/want/to/use';
}
```

## ビュー

コントローラに指定されているビューを表示します。

コントローラが存在しなくても、ビューがある場合（コントローラの利用が必要ない場合）、ビューのみ作成することも可能です。

