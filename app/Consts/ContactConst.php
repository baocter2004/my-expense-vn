<?php

namespace App\Consts;

class ContactConst
{
    const SUBJECT_SUPPORT = 1;
    const SUBJECT_FEEDBACK = 2;
    const SUBJECT_BUG = 3;
    const SUBJECT_OTHER = 4;

    const SUBJECTS = [
        self::SUBJECT_SUPPORT  => 'Hỗ trợ kỹ thuật',
        self::SUBJECT_FEEDBACK => 'Góp ý / phản hồi',
        self::SUBJECT_BUG      => 'Báo lỗi hệ thống',
        self::SUBJECT_OTHER    => 'Khác',
    ];
}
