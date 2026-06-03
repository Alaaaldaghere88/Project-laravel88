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

    'accepted' => 'يجب قبول حقل :attribute.',
    'accepted_if' => 'يجب قبول حقل :attribute عندما يكون :other :value.',
    'active_url' => 'حقل :attribute يجب أن يكون رابطاً صالحاً.',
    'after' => 'حقل :attribute يجب أن يكون تاريخاً بعد :date.',
    'after_or_equal' => 'حقل :attribute يجب أن يكون تاريخاً بعد أو يساوي :date.',
    'alpha' => 'حقل :attribute يجب أن يحتوي على أحرف فقط.',
    'alpha_dash' => 'حقل :attribute يجب أن يحتوي على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'حقل :attribute يجب أن يحتوي على أحرف وأرقام فقط.',
    'any_of' => 'حقل :attribute غير صالح.',
    'array' => 'حقل :attribute يجب أن يكون مصفوفة.',
    'ascii' => 'حقل :attribute يجب أن يحتوي على أحرف أبجدية رقمية أحادية البايت ورموز فقط.',
    'before' => 'حقل :attribute يجب أن يكون تاريخاً قبل :date.',
    'before_or_equal' => 'حقل :attribute يجب أن يكون تاريخاً قبل أو يساوي :date.',
    'between' => [
        'array' => 'حقل :attribute يجب أن يحتوي على عناصر بين :min و :max.',
        'file' => 'حقل :attribute يجب أن يكون حجمه بين :min و :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن تكون قيمته بين :min و :max.',
        'string' => 'حقل :attribute يجب أن يكون عدد أحرفه بين :min و :max.',
    ],
    'boolean' => 'حقل :attribute يجب أن يكون true أو false.',
    'can' => 'حقل :attribute يحتوي على قيمة غير مصرح بها.',
    'confirmed' => 'تأكيد حقل :attribute غير متطابق.',
    'contains' => 'حقل :attribute يفتقد قيمة مطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'حقل :attribute يجب أن يكون تاريخاً صالحاً.',
    'date_equals' => 'حقل :attribute يجب أن يكون تاريخاً مساوياً لـ :date.',
    'date_format' => 'حقل :attribute يجب أن يتطابق مع الصيغة :format.',
    'decimal' => 'حقل :attribute يجب أن يكون له :decimal منازل عشرية.',
    'declined' => 'يجب رفض حقل :attribute.',
    'declined_if' => 'يجب رفض حقل :attribute عندما يكون :other :value.',
    'different' => 'حقل :attribute و :other يجب أن يكونا مختلفين.',
    'digits' => 'حقل :attribute يجب أن يكون :digits أرقام.',
    'digits_between' => 'حقل :attribute يجب أن يكون عدد أرقامه بين :min و :max.',
    'dimensions' => 'حقل :attribute له أبعاد صورة غير صالحة.',
    'distinct' => 'حقل :attribute له قيمة مكررة.',
    'doesnt_contain' => 'حقل :attribute يجب ألا يحتوي على أي مما يلي: :values.',
    'doesnt_end_with' => 'حقل :attribute يجب ألا ينتهي بواحد مما يلي: :values.',
    'doesnt_start_with' => 'حقل :attribute يجب ألا يبدأ بواحد مما يلي: :values.',
    'email' => 'حقل :attribute يجب أن يكون بريداً إلكترونياً صالحاً.',
    'encoding' => 'حقل :attribute يجب أن يكون مشفراً بـ :encoding.',
    'ends_with' => 'حقل :attribute يجب أن ينتهي بواحد مما يلي: :values.',
    'enum' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'exists' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'extensions' => 'حقل :attribute يجب أن يكون له أحد الامتدادات التالية: :values.',
    'file' => 'حقل :attribute يجب أن يكون ملفاً.',
    'filled' => 'حقل :attribute يجب أن يحتوي على قيمة.',
    'gt' => [
        'array' => 'حقل :attribute يجب أن يحتوي على أكثر من :value عنصر.',
        'file' => 'حقل :attribute يجب أن يكون أكبر من :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من :value.',
        'string' => 'حقل :attribute يجب أن يكون أكبر من :value حرف.',
    ],
    'gte' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :value عنصر أو أكثر.',
        'file' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value.',
        'string' => 'حقل :attribute يجب أن يكون أكبر من أو يساوي :value حرف.',
    ],
    'hex_color' => 'حقل :attribute يجب أن يكون لوناً ست عشرياً صالحاً.',
    'image' => 'حقل :attribute يجب أن يكون صورة.',
    'in' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'in_array' => 'حقل :attribute يجب أن يكون موجوداً في :other.',
    'in_array_keys' => 'حقل :attribute يجب أن يحتوي على مفتاح واحد على الأقل من: :values.',
    'integer' => 'حقل :attribute يجب أن يكون عدداً صحيحاً.',
    'ip' => 'حقل :attribute يجب أن يكون عنوان IP صالحاً.',
    'ipv4' => 'حقل :attribute يجب أن يكون عنوان IPv4 صالحاً.',
    'ipv6' => 'حقل :attribute يجب أن يكون عنوان IPv6 صالحاً.',
    'json' => 'حقل :attribute يجب أن يكون نص JSON صالحاً.',
    'list' => 'حقل :attribute يجب أن يكون قائمة.',
    'lowercase' => 'حقل :attribute يجب أن يكون بأحرف صغيرة.',
    'lt' => [
        'array' => 'حقل :attribute يجب أن يحتوي على أقل من :value عنصر.',
        'file' => 'حقل :attribute يجب أن يكون أصغر من :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أصغر من :value.',
        'string' => 'حقل :attribute يجب أن يكون أصغر من :value حرف.',
    ],
    'lte' => [
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :value عنصر.',
        'file' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value.',
        'string' => 'حقل :attribute يجب أن يكون أصغر من أو يساوي :value حرف.',
    ],
    'mac_address' => 'حقل :attribute يجب أن يكون عنوان MAC صالحاً.',
    'max' => [
        'array' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max عنصر.',
        'file' => 'حقل :attribute يجب ألا يكون أكبر من :max كيلوبايت.',
        'numeric' => 'حقل :attribute يجب ألا يكون أكبر من :max.',
        'string' => 'حقل :attribute يجب ألا يكون أكبر من :max حرف.',
    ],
    'max_digits' => 'حقل :attribute يجب ألا يحتوي على أكثر من :max رقم.',
    'mimes' => 'حقل :attribute يجب أن يكون ملفاً من النوع: :values.',
    'mimetypes' => 'حقل :attribute يجب أن يكون ملفاً من النوع: :values.',
    'min' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :min عنصر على الأقل.',
        'file' => 'حقل :attribute يجب أن يكون على الأقل :min كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون على الأقل :min.',
        'string' => 'حقل :attribute يجب أن يكون على الأقل :min حرف.',
    ],
    'min_digits' => 'حقل :attribute يجب أن يحتوي على :min رقم على الأقل.',
    'missing' => 'حقل :attribute يجب أن يكون مفقوداً.',
    'missing_if' => 'حقل :attribute يجب أن يكون مفقوداً عندما يكون :other :value.',
    'missing_unless' => 'حقل :attribute يجب أن يكون مفقوداً ما لم يكن :other :value.',
    'missing_with' => 'حقل :attribute يجب أن يكون مفقوداً عندما تكون :values موجودة.',
    'missing_with_all' => 'حقل :attribute يجب أن يكون مفقوداً عندما تكون :values موجودة كلها.',
    'multiple_of' => 'حقل :attribute يجب أن يكون مضاعفاً لـ :value.',
    'not_in' => 'القيمة المحددة لـ :attribute غير صالحة.',
    'not_regex' => 'تنسيق حقل :attribute غير صالح.',
    'numeric' => 'حقل :attribute يجب أن يكون رقماً.',
    'password' => [
        'letters' => 'حقل :attribute يجب أن يحتوي على حرف واحد على الأقل.',
        'mixed' => 'حقل :attribute يجب أن يحتوي على حرف كبير وحرف صغير على الأقل.',
        'numbers' => 'حقل :attribute يجب أن يحتوي على رقم واحد على الأقل.',
        'symbols' => 'حقل :attribute يجب أن يحتوي على رمز واحد على الأقل.',
        'uncompromised' => 'قيمة :attribute المقدمة ظهرت في تسريب بيانات. الرجاء اختيار :attribute مختلف.',
    ],
    'present' => 'حقل :attribute يجب أن يكون موجوداً.',
    'present_if' => 'حقل :attribute يجب أن يكون موجوداً عندما يكون :other :value.',
    'present_unless' => 'حقل :attribute يجب أن يكون موجوداً ما لم يكن :other :value.',
    'present_with' => 'حقل :attribute يجب أن يكون موجوداً عندما تكون :values موجودة.',
    'present_with_all' => 'حقل :attribute يجب أن يكون موجوداً عندما تكون :values موجودة كلها.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما يكون :other :value.',
    'prohibited_if_accepted' => 'حقل :attribute محظور عندما يكون :other مقبولاً.',
    'prohibited_if_declined' => 'حقل :attribute محظور عندما يكون :other مرفوضاً.',
    'prohibited_unless' => 'حقل :attribute محظور ما لم يكن :other موجوداً في :values.',
    'prohibits' => 'حقل :attribute يمنع وجود :other.',
    'regex' => 'تنسيق حقل :attribute غير صالح.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'حقل :attribute يجب أن يحتوي على مداخل لـ: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يكون :other مقبولاً.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما يكون :other مرفوضاً.',
    'required_unless' => 'حقل :attribute مطلوب ما لم يكن :other موجوداً في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما تكون :values موجودة.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values موجودة كلها.',
    'required_without' => 'حقل :attribute مطلوب عندما تكون :values غير موجودة.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا تكون أي من :values موجودة.',
    'same' => 'حقل :attribute يجب أن يتطابق مع :other.',
    'size' => [
        'array' => 'حقل :attribute يجب أن يحتوي على :size عنصر.',
        'file' => 'حقل :attribute يجب أن يكون حجمه :size كيلوبايت.',
        'numeric' => 'حقل :attribute يجب أن يكون :size.',
        'string' => 'حقل :attribute يجب أن يكون :size حرف.',
    ],
    'starts_with' => 'حقل :attribute يجب أن يبدأ بواحد مما يلي: :values.',
    'string' => 'حقل :attribute يجب أن يكون نصاً.',
    'timezone' => 'حقل :attribute يجب أن يكون منطقة زمنية صالحة.',
    'unique' => 'قيمة :attribute مستخدمة بالفعل.',
    'uploaded' => 'فشل رفع :attribute.',
    'uppercase' => 'حقل :attribute يجب أن يكون بأحرف كبيرة.',
    'url' => 'حقل :attribute يجب أن يكون رابطاً صالحاً.',
    'ulid' => 'حقل :attribute يجب أن يكون ULID صالحاً.',
    'uuid' => 'حقل :attribute يجب أن يكون UUID صالحاً.',

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
            'rule-name' => 'رسالة مخصصة',
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

    'attributes' => [
        'first_name' => 'الاسم الأول',
        'last_name' => 'الاسم الأخير',
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'رقم الهاتف',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'current_password' => 'كلمة المرور الحالية',
        'new_password' => 'كلمة المرور الجديدة',
        'age' => 'العمر',
        'gender' => 'الجنس',
        'address' => 'العنوان',
        'city' => 'المدينة',
        'country' => 'الدولة',
        'nationality' => 'الجنسية',
        'birth_date' => 'تاريخ الميلاد',
        'image' => 'الصورة',
        'avatar' => 'الصورة الشخصية',
        'file' => 'الملف',
        'title' => 'العنوان',
        'content' => 'المحتوى',
        'description' => 'الوصف',
        'price' => 'السعر',
        'quantity' => 'الكمية',
        'role' => 'الدور',
        'status' => 'الحالة',
        'type' => 'النوع',
        'category' => 'الفئة',
        'date' => 'التاريخ',
        'time' => 'الوقت',
        'start_date' => 'تاريخ البداية',
        'end_date' => 'تاريخ النهاية',
        'start_time' => 'وقت البداية',
        'end_time' => 'وقت النهاية',
        'url' => 'الرابط',
        'website' => 'الموقع الإلكتروني',
        'facebook' => 'فيسبوك',
        'twitter' => 'تويتر',
        'instagram' => 'انستغرام',
        'linkedin' => 'لينكد إن',
        'youtube' => 'يوتيوب',
        'whatsapp' => 'واتساب',
        'telegram' => 'تيليغرام',
        'message' => 'الرسالة',
        'subject' => 'الموضوع',
        'comment' => 'التعليق',
        'review' => 'المراجعة',
        'rating' => 'التقييم',
        'code' => 'الرمز',
        'otp' => 'رمز التحقق',
        'token' => 'الرمز المميز',
        'id' => 'المعرف',
        'uuid' => 'المعرف الفريد',
        'slug' => 'الرابط المختصر',
        'summary' => 'الملخص',
        'body' => 'المحتوى',
        'excerpt' => 'المقتطف',
        'tags' => 'الوسوم',
        'meta_title' => 'عنوان SEO',
        'meta_description' => 'وصف SEO',
        'meta_keywords' => 'كلمات SEO',
        'width'=>'العرض',
        'tall'=>'الطول',
        'new-phone'=>'الرقم الجديد'
    ],

];
