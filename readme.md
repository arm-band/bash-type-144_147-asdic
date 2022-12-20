# Type144/147 ASDIC

## Abstract

日時フォーマット付きで ping を投げ続け、結果をテキストファイルに出力するスニペットです。

## Result's sample

ファイルに出力される結果は以下のようなフォーマットになります (ただし言語やタイムゾーン指定に依る)。

```
YYYY年mm月dd日 hh時ii分ss秒 PING 192.0.2.1 (192.0.2.1) 56(84) bytes of data.
YYYY年mm月dd日 hh時ii分ss秒 64 bytes from 192.0.2.1: icmp_seq=1 ttl=56 time=8.40 ms
YYYY年mm月dd日 hh時ii分ss秒 64 bytes from 192.0.2.1: icmp_seq=2 ttl=56 time=8.20 ms
YYYY年mm月dd日 hh時ii分ss秒 64 bytes from 192.0.2.1: icmp_seq=3 ttl=56 time=72.2 ms
YYYY年mm月dd日 hh時ii分ss秒 64 bytes from 192.0.2.1: icmp_seq=4 ttl=56 time=36.6 ms
```

## Usage

1. `config.php.sample` をコピーして `config.php` を作成してください
2. 適宜設定を変更してください
    - `address`: ping を送信する宛先
        - 手動で Ctrl + C で強制終了するか、端末の再起動などで**プロセスが終了しない限り ping を投げ続ける**ので、**第三者の迷惑にならない宛先を指定してください**
    - `resultOutput`: ファイル出力先パス・ファイル名
        - `path`: ファイル出力先のフォルダ名。デフォルトは `result`
        - `baseFilename`: ファイル出力先のベースファイル名。デフォルトは `result` で、末尾にハイフン + 年月日8ケタ + `.log` が付く。そのため、ファイル名は `result-yyyyMMdd.log` となる。
3. `main.php` を `php /PATH/TO/TYPE-144_147-ASDIC/main.php` のように PHP 上で実行
4. 確認が完了した任意のタイミングで、コマンドプロンプトを Ctrl + C や `kill` 等で終了させる