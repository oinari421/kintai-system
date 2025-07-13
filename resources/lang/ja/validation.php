<?php

return [

    'accepted' => ':attributeを承認してください。',
    'active_url' => ':attributeは有効なURLではありません。',
    'after' => ':attributeには、:date以降の日付を指定してください。',
    'after_or_equal' => ':attributeには、:date以降もしくは同日時を指定してください。',
    'alpha' => ':attributeには、アルファベッドのみ使用できます。',
    'alpha_dash' => ':attributeには、英数字とダッシュ(-)及び下線(_)が使用できます。',
    'alpha_num' => ':attributeには、英数字が使用できます。',
    'array' => ':attributeには、配列を指定してください。',
    'before' => ':attributeには、:date以前の日付を指定してください。',
    'before_or_equal' => ':attributeには、:date以前もしくは同日時を指定してください。',
    'between' => [
        'numeric' => ':attributeには、:min〜:maxまでの数値を指定してください。',
        'file'    => ':attributeには、:min〜:max KBのファイルを指定してください。',
        'string'  => ':attributeは、:min〜:max文字で指定してください。',
        'array'   => ':attributeの項目は、:min〜:max個で指定してください。',
    ],
    'boolean' => ':attributeには、trueかfalseを指定してください。',
    'confirmed' => ':attributeと確認フィールドが一致しません。',
    'date' => ':attributeは、正しい日付ではありません。',
    'date_format' => ':attributeの形式は、:formatと合いません。',
    'different' => ':attributeと:otherには、異なるものを指定してください。',
    'digits' => ':attributeは:digits桁で指定してください。',
    'digits_between' => ':attributeは:min〜:max桁で指定してください。',
    'email' => ':attributeは、有効なメールアドレス形式で指定してください。',
    'exists' => '選択された:attributeは正しくありません。',
    'file' => ':attributeには、ファイルを指定してください。',
    'filled' => ':attributeに値を指定してください。',
    'image' => ':attributeには、画像ファイルを指定してください。',
    'in' => '選択された:attributeは正しくありません。',
    'integer' => ':attributeは整数で指定してください。',
    'ip' => ':attributeには、有効なIPアドレスを指定してください。',
    'max' => [
        'numeric' => ':attributeには、:max以下の数字を指定してください。',
        'file'    => ':attributeには、:max KB以下のファイルを指定してください。',
        'string'  => ':attributeは、:max文字以内で指定してください。',
        'array'   => ':attributeの項目は、:max個以下で指定してください。',
    ],
    'mimes' => ':attributeには、:valuesタイプのファイルを指定してください。',
    'min' => [
        'numeric' => ':attributeには、:min以上の数字を指定してください。',
        'file'    => ':attributeには、:min KB以上のファイルを指定してください。',
        'string'  => ':attributeは、:min文字以上で指定してください。',
        'array'   => ':attributeの項目は、:min個以上で指定してください。',
    ],
    'not_in' => '選択された:attributeは正しくありません。',
    'numeric' => ':attributeには、数字を指定してください。',
    'required' => ':attributeは必須項目です。',
    'same' => ':attributeと:otherが一致しません。',
    'size' => [
        'numeric' => ':attributeは:sizeを指定してください。',
        'file'    => ':attributeは:size KBのファイルを指定してください。',
        'string'  => ':attributeは:size文字で指定してください。',
        'array'   => ':attributeの項目は:size個指定してください。',
    ],
    'string' => ':attributeは文字列を指定してください。',
    'unique' => ':attributeはすでに使用されています。',
    'url' => ':attributeは有効なURL形式で指定してください。',

    'custom' => [
        'email' => [
            'unique' => 'そのメールアドレスはすでに登録されています。',
        ],
    ],

    'attributes' => [
        'name' => '名前',
        'email' => 'メールアドレス',
        'password' => 'パスワード',
    ],
];
