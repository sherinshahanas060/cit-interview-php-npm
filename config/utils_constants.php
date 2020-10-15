<?php

return [
    'SUCCESS' => '100',
    'SUCCESSWITHMESSAGE' => '101',
    'SUCCESSWITHHTML' => '102',
    'SUCCESSWITHDATA' => '103',
    'CREATED' => '201',
    'ACCEPTED' => '202',
    'ERROR_NO_CONTENT' => '204',
    'ERROR_BAD_REQUEST' => '400',
    'ERROR_UNAUTHORIZED' => '401',
    'ERROR_PAYMENT_REQUIRED' => '402',
    'ERROR_FORBIDDEN' => '403',
    'ERROR_NOT_FOUND' => '404',
    'ERROR_CONFLICT' => '409',
    'ERROR_UNSUPPORTEDMEDIATYPE' => '415',
    'ERROR_INTERNAL_SERVER_ERROR' => '500',
    'ERROR_WRONGLOGIN' => '601',
    'ERROR_ALREADY_EXIST' => '602',
    'ERROR_WRONG_DATA_TYPE' => '603',
    'ERROR_EMPTY_FIELD' => '604',
    'ERROR_NOTAVAILABLENOW' => '605',
    'ERROR_ALREADY_UPLOADED' => '607',
    'ERROR_VALID_INPUT' => '999',
    'ERROR_EMAIL' => '988',
    'ERROR_PASSWORD' => '987',
    'ERROR_INVALID_INPUT' => '408',

    // status
    'STATUS_INACTIVE' =>"0",
    'STATUS_ACTIVE' =>"1",
    'STATUS_NEW' =>"2",
    'STATUS_PENDING' =>"3",
    'STATUS_APPROVED' =>"4",
    'STATUS_DECLINED' =>"5",
    'STATUS_PROCESSED' =>"6",
    'STATUS_PRESENT' =>"7",
    'STATUS_ABSENT' =>"8",
    'STATUS_YES' =>"1",
    'STATUS_NO' =>"0",
    'CANCELLED' =>"9",
    'TERMINATED' =>"10",
    'ON_VACATION' =>"11",
    'PAYROLL' =>"12",
    'REJECTED' =>"13",
    'BLACK_LISTED' => "2",
    'VALIDATED' => "1",
    'NOT-VALIDATED' => "0",

    // types
    'FEATURED' => "1",
    'RELATED' => "2",
    'COURSE_MASTER' => "1",
    'COURSE_SINGLE' => "2",
    'LIFESUPPORT_COURSE' => "3",
    'TO_DO_GROUP' => "2",
    'TO_DO_OWN' => "1",

    //level
    'LEVEL_OTHER' => "1",
    'LEVEL_PARENT' => "2",
    'LEVEL_CONTECTED' => "3",
    'LEVEL_ACCREDITED' => "4",
    'LEVEL_COURSE_TO_MASTER' => "5",

    //notify types
    'GENARAL' => 1,
    'PERSONAL' => 2,
    'GROUP' => 3,
    'TEAM' => 4,

    //Template Approval Status
    'TEMPLATE_APPROVED' => "1",
    'TEMPLATE_PENDING' => "2",
    'TEMPLATE_REDO' => "3",
    'TEMPLATE_REJECTED' => "4",

    //Certificate Folder Types
    'DELEGATE_CERTIFICATE' => "1",
    'FACULTY_CERTIFICATE' => "2",
    'APPRECIATION_CERTIFICATE' => "3",
    'FACULTY_BADGE' => "4",
    'DELEGATE_BADGE' => "5",

    //Certificate Number
    'CERTIFICATE_NUMBER' => '46520',
    
    // leads status
    'NEW' => 0,
    'LEAD_TAKEN' => 1,
    'LEAD_CONVERTED' => 2,
    'LEAD_RELEASED' => 3,

    // leads type
    'LEAD_USER_GEN' => 1,
    'LEAD_AUTO_GEN' => 2,

    // support type
    'SUPPORT_USER_GEN' => 1,
    'SUPPORT_AUTO_GEN' => 2,

    //supplier & client document types
    'TRADE_LICENCE' => 1,
    'TAX_REGISTRATION' => 2,
    'OWNER_DOCUMENTS' => 3,

    // event category association
    'CATEGORY_COURSE' => 5,
    'CATEGORY_PARTNER' => 4,
    'CATEGORY_ACADEMY' => 3,
    'CATEGORY_FACULTY' => 1,

    //Priority Status
    "SCHEDULED" => '100',

    //Estimation Status
    "CREATED" => 1,
    "PROCEEDED_FOR_APPROVAL" => 2,
    "APPROVED" => 3,

    //Estimation Approval Status
    "PROCEEDED" => 2,

    //Campaign type
    "EMAIL" => 1,
    "SMS" => 2,

    //Leave Statuses
    "LEAVE_APPLIED" => 1,
    "LEAVE_APPROVED" => 2,
    "LEAVE_REJECTED" => 3,


    //API
    'ATTENDANCE' => 1,

    //Banner
    'RELATIVE_BANNER' => 1,
    'FEATURED_BANNER' => 2
];