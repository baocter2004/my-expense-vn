<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Dòng thông báo lỗi mặc định
    |--------------------------------------------------------------------------
    */

    'accepted'             => ':attribute phải được chấp nhận.',
    'accepted_if'          => ':attribute phải được chấp nhận khi :other là :value.',
    'active_url'           => ':attribute không phải là URL hợp lệ.',
    'after'                => ':attribute phải sau ngày :date.',
    'after_or_equal'       => ':attribute phải là ngày sau hoặc bằng :date.',
    'alpha'                => ':attribute chỉ được chứa các chữ cái.',
    'alpha_dash'           => ':attribute chỉ được chứa chữ cái, số, gạch ngang và gạch dưới.',
    'alpha_num'            => ':attribute chỉ được chứa chữ cái và số.',
    'array'                => ':attribute phải là một mảng.',
    'before'               => ':attribute phải trước ngày :date.',
    'before_or_equal'      => ':attribute phải trước hoặc bằng ngày :date.',
    'between'              => [
        'array'   => ':attribute phải có giữa :min và :max phần tử.',
        'file'    => ':attribute phải trong khoảng :min đến :max kilobytes.',
        'numeric' => ':attribute phải trong khoảng :min đến :max.',
        'string'  => ':attribute phải trong khoảng :min đến :max ký tự.',
    ],
    'boolean'              => ':attribute phải đúng hoặc sai.',
    'confirmed'            => ':attribute xác nhận không khớp.',
    'current_password'     => 'Mật khẩu hiện tại không đúng.',
    'date'                 => ':attribute không phải ngày hợp lệ.',
    'date_equals'          => ':attribute phải bằng ngày :date.',
    'date_format'          => ':attribute không đúng định dạng :format.',
    'decimal'              => ':attribute phải có :decimal số thập phân.',
    'declined'             => ':attribute phải được từ chối.',
    'different'            => ':attribute và :other phải khác nhau.',
    'digits'               => ':attribute phải có :digits chữ số.',
    'digits_between'       => ':attribute phải có giữa :min và :max chữ số.',
    'dimensions'           => ':attribute có kích thước không hợp lệ.',
    'distinct'             => ':attribute đã tồn tại giá trị trùng lặp.',
    'email'                => ':attribute không đúng định dạng email.',
    'ends_with'            => ':attribute phải kết thúc bằng: :values.',
    'exists'               => ':attribute đã chọn không tồn tại.',
    'file'                 => ':attribute phải là file.',
    'filled'               => ':attribute không được để trống.',
    'gt' => [
        'array'   => ':attribute phải có nhiều hơn :value phần tử.',
        'file'    => ':attribute phải lớn hơn :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn :value.',
        'string'  => ':attribute phải dài hơn :value ký tự.',
    ],
    'gte' => [
        'array'   => ':attribute phải có ít nhất :value phần tử.',
        'file'    => ':attribute phải lớn hơn hoặc bằng :value kilobytes.',
        'numeric' => ':attribute phải lớn hơn hoặc bằng :value.',
        'string'  => ':attribute phải có ít nhất :value ký tự.',
    ],
    'image'                => ':attribute phải là hình ảnh.',
    'in'                   => ':attribute đã chọn không hợp lệ.',
    'in_array'             => ':attribute không tồn tại trong :other.',
    'integer'              => ':attribute phải là số nguyên.',
    'ip'                   => ':attribute phải là địa chỉ IP hợp lệ.',
    'ipv4'                 => ':attribute phải là địa chỉ IPv4 hợp lệ.',
    'ipv6'                 => ':attribute phải là địa chỉ IPv6 hợp lệ.',
    'json'                 => ':attribute phải là chuỗi JSON hợp lệ.',
    'lt' => [
        'array'   => ':attribute phải ít hơn :value phần tử.',
        'file'    => ':attribute phải nhỏ hơn :value kilobytes.',
        'numeric' => ':attribute phải nhỏ hơn :value.',
        'string'  => ':attribute phải ngắn hơn :value ký tự.',
    ],
    'lte' => [
        'array'   => ':attribute không được quá :value phần tử.',
        'file'    => ':attribute phải nhỏ hơn hoặc bằng :value kilobytes.',
        'numeric' => ':attribute phải nhỏ hơn hoặc bằng :value.',
        'string'  => ':attribute phải không quá :value ký tự.',
    ],
    'max' => [
        'array'   => ':attribute không được quá :max phần tử.',
        'file'    => ':attribute không được lớn hơn :max kilobytes.',
        'numeric' => ':attribute không được lớn hơn :max.',
        'string'  => ':attribute không được dài hơn :max ký tự.',
    ],
    'mimes'                => ':attribute phải là file loại: :values.',
    'mimetypes'            => ':attribute phải là file loại: :values.',
    'min' => [
        'array'   => ':attribute phải có ít nhất :min phần tử.',
        'file'    => ':attribute phải ít nhất :min kilobytes.',
        'numeric' => ':attribute phải ít nhất :min.',
        'string'  => ':attribute phải ít nhất :min ký tự.',
    ],
    'multiple_of'          => ':attribute phải là bội số của :value.',
    'not_in'               => ':attribute đã chọn không hợp lệ.',
    'not_regex'            => ':attribute không đúng định dạng.',
    'numeric'              => ':attribute phải là số.',
    'password'             => 'Mật khẩu không đúng.',
    'present'              => ':attribute phải được cung cấp.',
    'prohibited'           => ':attribute không được phép.',
    'regex'                => ':attribute không đúng định dạng.',
    'required'             => ':attribute là bắt buộc.',
    'required_if'          => ':attribute là bắt buộc khi :other là :value.',
    'required_unless'      => ':attribute là bắt buộc trừ khi :other là :values.',
    'required_with'        => ':attribute là bắt buộc khi :values tồn tại.',
    'required_without'     => ':attribute là bắt buộc khi :values không tồn tại.',
    'same'                 => ':attribute và :other phải khớp.',
    'size' => [
        'array'   => ':attribute phải có :size phần tử.',
        'file'    => ':attribute phải có dung lượng :size kilobytes.',
        'numeric' => ':attribute phải bằng :size.',
        'string'  => ':attribute phải đúng :size ký tự.',
    ],
    'starts_with'          => ':attribute phải bắt đầu bằng: :values.',
    'string'               => ':attribute phải là chuỗi.',
    'timezone'             => ':attribute phải là múi giờ hợp lệ.',
    'unique'               => ':attribute đã được sử dụng.',
    'uploaded'             => ':attribute tải lên thất bại.',
    'url'                  => ':attribute không đúng định dạng URL.',

    /*
    |--------------------------------------------------------------------------
    | Tuỳ chỉnh thông báo lỗi riêng
    |--------------------------------------------------------------------------
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'Thông báo lỗi tùy chỉnh.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tuỳ chỉnh tên thuộc tính
    |--------------------------------------------------------------------------
    */

    'attributes' => [
        'email' => 'Địa chỉ email',
        'password' => 'Mật khẩu',
        'first_name' => 'Tên',
        'last_name' => 'Họ',
        'gender' => 'Giới tính',
        'birth_date' => 'Ngày sinh',
        'avatar' => 'Ảnh đại diện',
        'current_password' => 'Mật khẩu hiện tại',
        'new_password' => 'Mật khẩu mới',
        'again_new_password' => 'Xác nhận mật khẩu mới'
    ],
];
