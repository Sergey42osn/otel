<?php
 return

    array(
        'jq_val_mes' => array(
            'required_pass' => 'обязательно для заполнения',
        ),
        'jq_validate_msgs' =>
        array(
            "validNumber" =>  "Внесите корректный номер",
            'validHour' => "Check-out-to must be After than Check Out From",
            'validHourto' => "Check-in-to must be After than Check Out From",
            'required' => 'Обязательно для заполнения.',
            'remote' => 'Пожалуйста, исправьте это поле.',
            'email' => 'Внесите корректный эл. почту.',
            'url' => 'Please enter a valid URL.',
            'date' => 'Please enter a valid date.',
            'dateISO' => 'Please enter a valid date (ISO).',
            'number' => 'Внесите корректный номер.',
            'digits' => 'Пожалуйста, вводите только цифры.',
            'creditcard' => 'Пожалуйста, введите действительный номер кредитной карты.',
            'equalTo' => 'Please enter the same value again.',
            'accept' => 'Please enter a value with a valid extension.',
            'maxlength' => 'Введите не более {0} символов.',
            'minlength' => 'Пожалуйста, введите хотя бы {0} символa.',
            'rangelength' => 'Please enter a value between {0} and {1} characters long.',
            'range' => 'Please enter a value between {0} and {1}.',
            'max' => 'Please enter a value less than or equal to {0}.',
            'min' => 'Пожалуйста, введите значение больше чем {0}.',
            'regex' => 'Пожалуйста, проверьте введенные данные.',
            'pwcheck' => 'Пароль должен содержать буквы и цифры.',
        ),

        'accepted' => ':attribute должен быть принят.',
        'active_url' => ':attribute is not a valid URL.',
        'after' => ':attribute must be a date after :date.',
        'after_or_equal' => ':attribute must be a date after or equal to :date.',
        'alpha' => ':attribute may only contain letters.',
        'alpha_dash' => ':attribute может содержать только буквы, цифры, тире и символы подчеркивания.',
        'alpha_num' => ':attribute может содержать только буквы и цифры.',
        'array' => ':attribute must be an array.',
        'before' => ':attribute must be a date before :date.',
        'before_or_equal' => ':attribute must be a date before or equal to :date.',
        'between' =>
        array(
            'numeric' => ':attribute должно быть между :min и :max.',
            'file' => ':attribute должно быть между :min и :max килобайта.',
            'string' => ':attribute должно быть между :min и :max символов.',
            'array' => ':attribute должно быть между :min и :max.',
        ),
        'boolean' => ':attribute field must be true or false.',
        'confirmed' => ':attribute подтверждение не совпадает.',
        'date' => ':attribute не действительная дата.',
        'date_equals' => ':attribute must be a date equal to :date.',
        'date_format' => ':attribute does not match the format :format.',
        'different' => ':attribute and :other must be different.',
        'digits' => ':attribute must be :digits digits.',
        'digits_between' => ':attribute должно быть между :min и :max цифрами.',
        'dimensions' => ':attribute has invalid image dimensions.',
        'distinct' => ':attribute поле имеет повторяющееся значение.',
        'email' => ':attribute адрес эл. почты должен быть действительным.',
        'ends_with' => ':attribute must end with one of the following: :values',
        'exists' => 'The selected :attribute is invalid.',
        'file' => ':attribute must be a file.',
        'filled' => ':attribute field must have a value.',
        'gt' =>
        array(
            'numeric' => ':attribute must be greater than :value.',
            'file' => ':attribute must be greater than :value kilobytes.',
            'string' => ':attribute must be greater than :value characters.',
            'array' => ':attribute must have more than :value items.',
        ),
        'gte' =>
        array(
            'numeric' => ':attribute must be greater than or equal :value.',
            'file' => ':attribute must be greater than or equal :value kilobytes.',
            'string' => ':attribute must be greater than or equal :value characters.',
            'array' => ':attribute must have :value items or more.',
        ),
        'image' => ':attribute must be an image.',
        'in' => 'The selected :attribute is invalid.',
        'in_array' => ':attribute поле не существует :other.',
        'integer' => ':attribute must be an integer.',
        'ip' => ':attribute must be a valid IP address.',
        'ipv4' => ':attribute must be a valid IPv4 address.',
        'ipv6' => ':attribute must be a valid IPv6 address.',
        'json' => ':attribute must be a valid JSON string.',
        'lt' =>
        array(
            'numeric' => ':attribute должно быть меньше, чем :value.',
            'file' => ':attribute должно быть меньше, чем :value килобайтов.',
            'string' => ':attribute должно быть меньше, чем :value символа.',
            'array' => ':attribute must have less than :value items.',
        ),
        'lte' =>
        array(
            'numeric' => ':attribute must be less than or equal :value.',
            'file' => ':attribute must be less than or equal :value kilobytes.',
            'string' => ':attribute must be less than or equal :value characters.',
            'array' => ':attribute must not have more than :value items.',
        ),
        'max' =>
        array(
            'numeric' => ':attribute may not be greater than :max.',
            'file' => ':attribute may not be greater than :max kilobytes.',
            'string' => ':attribute may not be greater than :max characters.',
            'array' => ':attribute may not have more than :max items.',
        ),
        'mimes' => ':attribute must be a file of type: :values.',
        'mimetypes' => ':attribute must be a file of type: :values.',
        'min' =>
        array(
            'numeric' => ':attribute пароль должен быть не меньше :min.',
            'file' => ':attribute must be at least :min kilobytes.',
            'string' => ':attribute пароль должен быть не меньше :min символов.',
            'array' => ':attribute must have at least :min items.',
        ),
        'not_in' => 'The selected :attribute is invalid.',
        'not_regex' => ':attribute format is invalid.',
        'numeric' => ':attribute must be a number.',
        'password' => 'Неправильный пароль.',
        'present' => ':attribute field must be present.',
        'regex' => ':attribute format is invalid.',
        'required' => 'Поле :attribute обязательно к заполнению.',
        'required_if' => ':attribute поле обязательно, когда :other is :value.',
        'required_unless' => ':attribute поле обязательно, если только :other is in :values.',
        'required_with' => ':attribute поле обязательно, когда :values is present.',
        'required_with_all' => ':attribute field is required when :values are present.',
        'required_without' => ':attribute field is required when :values is not present.',
        'required_without_all' => ':attribute field is required when none of :values are present.',
        'same' => ':attribute and :other must match.',
        'size' =>
        array(
            'numeric' => ':attribute must be :size.',
            'file' => ':attribute must be :size kilobytes.',
            'string' => ':attribute must be :size characters.',
            'array' => ':attribute must contain :size items.',
        ),
        'starts_with' => ':attribute must start with one of the following: :values',
        'string' => ':attribute must be a string.',
        'timezone' => ':attribute must be a valid zone.',
        'unique' => ':attribute уже использовано.',
        'uploaded' => ':attribute failed to upload.',
        'url' => ':attribute format is invalid.',
        'uuid' => ':attribute must be a valid UUID.',
        'custom' =>
        array(
            'attribute-name' =>
            array(
                'rule-name' => 'custom-message',
            ),
        ),

        'attributes' => [
            'phone' => 'телефон',
            'payment_type_id' => 'метод оплаты',
            'name' => 'имя',
            'email' => 'эл. почта',
            'city' => 'город',
            'address' => 'адрес',
            'comment' => 'особые пожелания',
            'password' => 'пароль',
            'password_confirmation' => 'потвердить пароль',
            'cityzen' => 'гражданство'
        ]
);
