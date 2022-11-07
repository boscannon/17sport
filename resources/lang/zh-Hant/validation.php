<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute 必須被接受.',
    'active_url' => ':attribute 不是有效的網址.',
    'after' => ':attribute 必須是 :date 之後的日期.',
    'after_or_equal' => ':attribute 必須是等於 :date 或 :date 之後的日期.',
    'alpha' => ':attribute 只能包含字母.',
    'alpha_dash' => ':attribute 只能包含字母、底線、- 線.',
    'alpha_num' => ':attribute 只能包含字母和數字.',
    'array' => ':attribute 必須是陣列.',
    'before' => ':attribute 必須是 :date 之前的日期.',
    'before_or_equal' => ':attribute 必須是等於 :date 或 :date 之前的日期.',
    'between' => [
        'numeric' => ':attribute 必須介於 :min 到 :max 之間.',
        'file' => ':attribute 容量必須介於 :min KB到 :max KB之間.',
        'string' => ':attribute 字元必須介於 :min 到 :max.',
        'array' => ':attribute 項目必須介於 :min 到 :max.',
    ],
    'boolean' => ':attribute 必須為 true 或 false.',
    'confirmed' => ':attribute 與確認欄位不相符.',
    'date' => ':attribute 非有效日期.',
    'date_equals' => ':attribute 必須等於 :date 日期.',
    'date_format' => ':attribute 與日期格式 :format 不相符.',
    'different' => ':attribute 和 :other 必須不同.',
    'digits' => ':attribute 必須 :digits 位數.',
    'digits_between' => ':attribute 必須介於 :min 到 :max 位數之間.',
    'dimensions' => ':attribute 圖像尺寸無效.',
    'distinct' => ':attribute 有重複的值.',
    'email' => ':attribute 電子郵件格式無效.',
    'exists' => '所選 :attribute 無效.',
    'file' => ':attribute 必須是個檔案.',
    'filled' => ':attribute 必須有值.',
    'gt' => [
        'numeric' => ':attribute 必須大於 :value.',
        'file' => ':attribute 必須大於 :value KB.',
        'string' => ':attribute 必須大於 :value 字元.',
        'array' => ':attribute 必須多於 :value 項.',
    ],
    'gte' => [
        'numeric' => ':attribute 必須大於或等於 :value.',
        'file' => ':attribute 必須大於或等於 :value KB.',
        'string' => ':attribute 必須大於或等於 :value 字元.',
        'array' => ':attribute 最少 :value 項.',
    ],
    'image' => ':attribute 必須為圖片.',
    'in' => '所選 :attribute 無效.',
    'in_array' => ':attribute 不存在於 :other.',
    'integer' => ':attribute 必須是整數.',
    'ip' => ':attribute 必須是有效的 IP 位址.',
    'ipv4' => ':attribute 必須是有效的 IPv4 位址.',
    'ipv6' => ':attribute 必須是有效的 IPv6 位址.',
    'json' => ':attribute 必須是有效的 JSON 字串.',
    'lt' => [
        'numeric' => ':attribute 必須小於 :value.',
        'file' => ':attribute 必須小於 :value KB.',
        'string' => ':attribute 必須小於 :value 字元.',
        'array' => ':attribute 必須少於 :value 項.',
    ],
    'lte' => [
        'numeric' => ':attribute 必須小於或等於 :value.',
        'file' => ':attribute 必須小於或等於 :value KB.',
        'string' => ':attribute 必須小於或等於 :value 字元.',
        'array' => ':attribute 最多 :value 項.',
    ],
    'max' => [
        'numeric' => ':attribute 最大 :max.',
        'file' => ':attribute 最大 :max KB.',
        'string' => ':attribute 最大 :max 字元.',
        'array' => ':attribute 最多 :max 項.',
    ],
    'mimes' => ':attribute 必須符合: :values 檔案類型.',
    'mimetypes' => ':attribute 必須符合: :values 檔案類型.',
    'min' => [
        'numeric' => ':attribute 最小 :min.',
        'file' => ':attribute 最小 :min KB.',
        'string' => ':attribute 最小 :min 字元.',
        'array' => ':attribute 最少 :min 項.',
    ],
    'not_in' => '所選 :attribute 無效.',
    'not_regex' => ':attribute 格式無效.',
    'numeric' => ':attribute 必須是數字.',
    'present' => ':attribute 必須有值.',
    'regex' => ':attribute 格式無效.',
    'required' => ':attribute 必須有值.',
    'required_if' => '當 :other 是 :value 時, :attribute 必須有值.',
    'required_unless' => '除非 :other 是 :values, 否則 :attribute 必須有值.',
    'required_with' => '當 :values 有值時, :attribute 必須有值.',
    'required_with_all' => '當 :values 有值時, :attribute 必須有值.',
    'required_without' => '當 :values 沒有值時, :attribute 必須有值.',
    'required_without_all' => '當沒有 :values 值時, :attribute 必須有值.',
    'same' => ':attribute 和 :other 必須相同.',
    'size' => [
        'numeric' => ':attribute 大小必須為 :size.',
        'file' => ':attribute 必須 :size KB.',
        'string' => ':attribute 必須 :size 字元.',
        'array' => ':attribute 必須包含 :size 項.',
    ],
    'starts_with' => ':attribute 必須從以下之一開始: :values',
    'string' => ':attribute 必須是字串.',
    'timezone' => ':attribute 必須為有效時區.',
    'unique' => ':attribute 已經存在.',
    'uploaded' => ':attribute 上傳失敗.',
    'url' => ':attribute 格式無效.',
    'uuid' => ':attribute 必須為有效的 UUID.',
    'captcha' => '驗證碼錯誤',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
