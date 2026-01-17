<?php

return [

    'required' => ':attributeを入力してください',
    'email' => ':attributeは「ユーザー名@ドメイン」形式で入力してください',
    'string' => ':attributeは文字列で入力してください',
    'numeric' => ':attributeは数字で入力してください',
    'max' => [
        'numeric' => ':attributeは:max以下で入力してください',
        'string' => ':attributeは:max文字以下で入力してください',
    ],
    'unique' => ':attributeは既に登録されています',
    'regex' => ':attributeの形式が正しくありません',

    'attributes' => [
        'email' => 'メールアドレス',
        'password' => 'パスワード',
        'name' => '名前',
    ],

];
