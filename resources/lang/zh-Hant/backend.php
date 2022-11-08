<?php

return [
  'menu' => [
    'users'=> '管理員',
    'users_setting'=> '管理員設定',
    'roles'=> '角色',
    'basic'=> '基本資料',
    'departments'=> '部門管理',
    'jobs'=> '職稱管理',
    'members'=> '會員管理',
    'suppliers'=> '供應商管理',
    'staff'=> '人員管理',
    'test'=> '測試',
    'template'=> '模板'
  ],
  'audits' => [
    'event' => '動作',
    'auditing' => '操作紀錄',
    'created' => '「:name」 => [:new]',
    'updated' => '「:name」 => [:new]',
    'deleted' => '「:name」 => [:old]',
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
    'remark' => '備註'
  ],
];
