<?php

return [
  'menu' => [
    'users'=> '管理員',
    'users_setting'=> '管理員設定',
    'system_settings'=> '系統設定',
    'roles'=> '角色',
    'basic'=> '基本資料',
    'departments'=> '部門管理',
    'jobs'=> '職稱管理',
    'members'=> '會員管理',
    'suppliers'=> '供應商管理',
    'staff'=> '人員管理',
    'test'=> '測試',
    'template'=> '模板',
    'products'=> '產品管理',
    'stock_details'=> '庫存明細',
    'orders'=> '訂單',
  ],
  'audits' => [
    'user' => '管理員',
    'event' => '動作',
    'auditing' => '操作紀錄',
    'created' => '「:name」 => [:new]',
    'updated' => '「:name」 => [:new]',
    'deleted' => '「:name」 => [:old]',
  ],
  'system_settings' => [
    'key' => '鍵值',
    'value' => '內容',
    'momo_password' => 'momo master密碼'
  ],
  'users' => [
    'name' => '名稱',
    'email' => '信箱',
    'staff_id' => '人員',
    'password' => '密碼',
    'password_error' => '密碼錯誤',
    'password_confirmation' => '密碼確認',
    'status' => '狀態',
    'retirement_date' => '停用日期',
  ],
  'roles' => [
    'name' => '角色名稱',
    'permissions' => '角色權限'
  ],
  'departments' => [
    'no' => '部門編號',
    'name' => '部門名稱',
    'parent_id' => '上層部門',
    'level' => '層級',
    'remark' => '備註'
  ],
  'staff' => [
    'no' => '人員編號',
    'name' => '人員名稱',
    'identification' => '身分證',
    'department_id' => '所屬部門',
    'appointment_date' => '到職日期',
    'resignation_date' => '離職日期',
    'telephone' => '連絡電話',
    'cellphone' => '手機',
    'address' => '地址',
    'email' => 'email',
    'emergency_contact' => '緊急聯絡人',
    'emergency_contact_phone' => '緊急聯絡人電話',
    'remark' => '備註',
  ],
  'products' => [
    'barcode' => '國際條碼',
    'yahoo_id' => 'yahoo 編號',
    'momo_id' => 'momo 編號',
    'momo_dt_code' => 'momo 品號',
    'name' => '名稱',
    'specification' => '規格',
    'unit' => '單位',
    'type' => '型號',
    'size' => '尺寸',
    'attribute' => '屬性',
    'price' => '售價',
    'stock' => '庫存',
    'remark' => '備註',
    'ecxel_download' => 'excel格式下載',
    "bulk_add" => "批量新增",
    "bulk_add_info" => "注意！國際條碼重複會進行覆蓋",
    "file" => "檔案",
  ],  
  'stock_details' => [
    'product_id' => '產品',
    'order_id' => '訂單',
    'source' => '來源',
    'no' => '訂單編號',
    'barcode' => '國際條碼',
    'name' => '商品名稱',
    'type' => '型號',
    'size' => '尺寸',
    'amount' => '數量',
    'stock' => '庫存',
    'shopline_update_stock' => 'shopline 更新庫存',
    'shopline_excel' => 'shopline excel',
    "file" => "檔案",
    "bulk_add_info" => "注意！國際條碼重複會進行覆蓋",
    'yahoo_id' => 'yahoo 編號',
    'momo_id' => 'momo 編號',
  ],
  'orders' => [
    'no' => '編號',
    'source' => '來源',
    'date' => '日期',
    'recipient_name' => '收件人姓名',
    'recipient_phone' => '收件人電話',
    'recipient_cellphone' => '收件人手機',
    'purchaser_name' => '購買人姓名',
    'purchaser_cellphone' => '購買人手機',
    'due_date' => '應出貨日',
    'remark' => '備註',
    'barcode' => '國際條碼',
    'name' => '商品名稱',
    'amount' => '數量',
    'stock_detail_count' => '匹配',
    'not_match' => '未匹配',
    'match' => '匹配',    
  ]
];
