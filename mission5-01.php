<!DOCTYPE html>
<html lang = "ja">
    <head>
        <meta charset = "UTF-8">
        <title>mission_5-01</title>
    </head>
    <body>
        <?php
        
        //DB接続設定
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        // テーブル作成
        $sql = "CREATE TABLE IF NOT EXISTS m5_01"
        ."("
        ."id INT AUTO_INCREMENT PRIMARY KEY,"
        ."name char(32),"
        ."comment TEXT,"
        ."date TIMESTAMP,"
        ."pass TEXT"
        .");";
        $stmt = $pdo->query($sql);
        
        // ■ ■ ■ 投稿フォームに名前とコメントとパスワードが入っている＆＆編集対象番号が空だったら新規投稿処理 ■ ■ ■
        if(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["pass"]) && empty($_POST["edit_num"])){
        
                //名前を変数に入れる
                $name = $_POST["name"];
                
                //コメントを変数に入れる
                $comment = $_POST["comment"];
                
                //投稿日時を変数に入れる
                $date = date("Y-m-d H:i:s");
                
                //パスワードを変数に入れる
                $pass = $_POST["pass"];
                
                //データベースへの接続
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                //データレコードの挿入
                $sql = $pdo -> prepare("INSERT INTO m5_01 (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
                $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
                $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                $name = $_POST["name"];
                $comment = $_POST["comment"];
                $pass = $_POST["pass"];
                $date = date("Y-m-d H:i:s");
                $sql -> execute();
                
        } else if(isset($_POST["delete"]) && isset($_POST["delpass"])){// ■ ■ ■ フォームに削除対象番号とパスワードが入っていたら削除処理 ■ ■ ■
        
                //削除番号を変数に入れる
                $delete = $_POST["delete"];
                
                //削除パスワードを変数に入れる
                $delpass = $_POST["delpass"];
                
                //データベースへの接続
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                //データレコードを抽出
                $sql = 'SELECT * FROM m5_01';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    
                    //削除番号が正しくて、パスワードが正しかったら
                    if($row['id'] == $delete && $row['pass'] == $delpass){
                        
                        //データレコードを消去(SQL)
                        $id = $delete;
                        $sql = 'delete from m5_01 where id=:id';
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                    
                    //削除番号が正しくて、パスワードが間違っていたら
                    if($row['id'] == $delete && $row['pass'] != $delpass){
                        
                        //エラーメッセージを表示
                        echo "パスワードが間違っています。";
                    }
                }
        } else if(isset($_POST["edit"]) && isset($_POST["editpass"])){// ■ ■ ■ 編集フォームに編集対象番号とパスワードが入っていたらフォームに編集対象箇所を表示する処理 ■ ■ ■
            
               //編集対象番号を変数に入れる
               $edit_num = $_POST["edit"];
               
               //パスワードを変数に入れる
               $editpass = $_POST["editpass"];
               
               //データベースへの接続
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                //データレコードを抽出
                $sql = 'SELECT * FROM m5_01';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    
                    //編集番号とパスワードが等しかったら
                    if($row['id'] == $edit_num && $row['pass'] == $editpass){
                        
                        //編集するidを変数に入れる
                        $edit_data0 = $row['id'];
                        
                        //編集するnameを変数に入れる
                        $edit_data1 = $row['name'];
                        
                        //編集するcommentを変数に入れる
                        $edit_data2 = $row['comment'];
                        
                        //編集するpassを変数に入れる
                        $edit_data3 = $row['pass'];
                    }
                    
                    //編集番号が正しくてパスワードが間違っていたら
                    if($row['id'] == $edit_num && $row['pass'] != $editpass){
                        
                        //編集パスワードを変数から除く
                        $editpass = "";
                        
                        //エラーメッセージを表示
                        echo "パスワードが間違っています。";
                    }
                }
        } else if(isset($_POST["name"]) && isset($_POST["comment"]) && isset($_POST["pass"]) && isset($_POST["edit_num"])){
                
                //編集対象番号を変数に入れる
                $edit_num = $_POST["edit_num"];
                
                //編集後の名前を変数に入れる
                $edit_name = $_POST["name"];
                
                //編集後のコメントを変数に入れる
                $edit_comment = $_POST["comment"];
                
                //編集時の時間を変数に入れる
                $edit_date = date("Y-m-d H:i:s");
                
                //編集後のパスワードを変数に入れる
                $edit_pass = $_POST["pass"];
                
                //データベースへの接続
                $dsn = 'データベース名';
                $user = 'ユーザー名';
                $password = 'パスワード';
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
                
                //データレコードを抽出
                $sql = 'SELECT * FROM m5_01';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    
                    //編集番号と投稿番号が等しかったら
                    if($row['id'] == $edit_num ){
                        
                        //データ更新
                        $id = $edit_num;
                        $name = $edit_name;
                        $comment = $edit_comment;
                        $date = $edit_date;
                        $pass = $edit_pass;
                        $sql = 'UPDATE m5_01 SET name=:name,comment=:comment,pass=:pass,date=:date WHERE id=:id'; //データ更新SQLで実行(SQL)
                        $stmt = $pdo->prepare($sql);
                        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                        $stmt->execute();
                    }
                }
        }
        ?>
        <!-- この掲示板のテーマ -->
        <h2>毎日の体温記録</h2>

        <!--新規投稿入力フォーム-->
        <form action = "" method = "post">
        <input type = "text" name = "name" placeholder = "名前" value = "<?php if(isset($edit_data1)){echo $edit_data1;}?>" required><br>
        <input type = "text" name = "comment" placeholder = "体温" value = "<?php if(isset($edit_data2)){echo $edit_data2;}?>" required><br>
        <input type = "password" name = "pass" placeholder = "パスワード" value = "<?php if(isset($edit_data3)){echo $edit_data3;}?>" required>
        <input type = "hidden" name = "edit_num" value = "<?php if(isset($edit_num)){echo $edit_num;}?>">
        <input type = "submit" value = "投稿"><br><br>
        </form>
        <!--削除番号指定用フォーム-->
        <form action = "" method = "post">
        <input type = "number" name = "delete" placeholder = "削除対象番号" required><br>
        <input type = "password" name = "delpass" placeholder = "パスワード" required>
        <input type = "submit" value = "削除"><br><br>
        </form>
        <!--編集番号指定用フォーム-->
        <form action = "" method = "post">
        <input type = "number" name = "edit" placeholder = "編集対象番号" required><br>
        <input type = "password" name = "editpass" placeholder = "パスワード" required>
        <input type = "submit" value = "編集">
        </form><br>
        --------------------------------------------------------------------------------------------------------------<br>
        [投稿一覧]<br>

        <?php

        //データベースへの接続（SQL）
        $dsn = 'データベース名';
        $user = 'ユーザー名';
        $password = 'パスワード';
        $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        //データレコードを抽出(SQL)
        $sql = 'SELECT * FROM m5_01';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date'].'<br>';
        echo "<hr>";
        }
        ?>
    </body>
</html>