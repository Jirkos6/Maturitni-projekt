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

    'accepted' => 'Pole :attribute musí být přijato.',
    'accepted_if' => 'Pole :attribute musí být přijato, když :other je :value.',
    'active_url' => 'Pole :attribute musí být platná URL adresa.',
    'after' => 'Pole :attribute musí být datum po :date.',
    'after_or_equal' => 'Pole :attribute musí být datum po nebo rovno :date.',
    'alpha' => 'Pole :attribute může obsahovat pouze písmena.',
    'alpha_dash' => 'Pole :attribute může obsahovat pouze písmena, čísla, pomlčky a podtržítka.',
    'alpha_num' => 'Pole :attribute může obsahovat pouze písmena a čísla.',
    'array' => 'Pole :attribute musí být pole.',
    'ascii' => 'Pole :attribute musí obsahovat pouze jednobytové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí být datum před :date.',
    'before_or_equal' => 'Pole :attribute musí být datum před nebo rovno :date.',
    'between' => [
        'array' => 'Pole :attribute musí obsahovat mezi :min a :max položkami.',
        'file' => 'Pole :attribute musí být mezi :min a :max kilobajty.',
        'numeric' => 'Pole :attribute musí být mezi :min a :max.',
        'string' => 'Pole :attribute musí být mezi :min a :max znaky.',
    ],
    'boolean' => 'Pole :attribute musí být true nebo false.',
    'can' => 'Pole :attribute obsahuje nepovolené hodnoty.',
    'confirmed' => 'Potvrzení pole :attribute se neshoduje.',
    'contains' => 'Pole :attribute postrádá požadovanou hodnotu.',
    'current_password' => 'Heslo je nesprávné.',
    'date' => 'Pole :attribute musí být platné datum.',
    'date_equals' => 'Pole :attribute musí být datum rovné :date.',
    'date_format' => 'Pole :attribute musí odpovídat formátu :format.',
    'decimal' => 'Pole :attribute musí mít :decimal desetinných míst.',
    'declined' => 'Pole :attribute musí být odmítnuto.',
    'declined_if' => 'Pole :attribute musí být odmítnuto, když :other je :value.',
    'different' => 'Pole :attribute a :other musí být odlišné.',
    'digits' => 'Pole :attribute musí být :digits číslic.',
    'digits_between' => 'Pole :attribute musí být mezi :min a :max číslicemi.',
    'dimensions' => 'Pole :attribute má neplatné rozměry obrázku.',
    'distinct' => 'Pole :attribute obsahuje duplicitní hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmí končit jedním z následujících: :values.',
    'doesnt_start_with' => 'Pole :attribute nesmí začínat jedním z následujících: :values.',
    'email' => 'Pole :attribute musí být platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končit jedním z následujících: :values.',
    'enum' => 'Vybraná hodnota :attribute je neplatná.',
    'exists' => 'Vybraná hodnota :attribute je neplatná.',
    'extensions' => 'Pole :attribute musí mít jednu z následujících přípon: :values.',
    'file' => 'Pole :attribute musí být soubor.',
    'filled' => 'Pole :attribute musí mít hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí obsahovat více než :value položek.',
        'file' => 'Pole :attribute musí být větší než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být větší než :value.',
        'string' => 'Pole :attribute musí být delší než :value znaků.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí obsahovat :value položek nebo více.',
        'file' => 'Pole :attribute musí být větší nebo rovno :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být větší nebo rovno :value.',
        'string' => 'Pole :attribute musí být delší nebo rovno :value znaků.',
    ],
    'hex_color' => 'Pole :attribute musí být platná hexadecimální barva.',
    'image' => 'Pole :attribute musí být obrázek.',
    'in' => 'Vybraná hodnota :attribute je neplatná.',
    'in_array' => 'Pole :attribute musí existovat v :other.',
    'integer' => 'Pole :attribute musí být celé číslo.',
    'ip' => 'Pole :attribute musí být platná IP adresa.',
    'ipv4' => 'Pole :attribute musí být platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí být platná IPv6 adresa.',
    'json' => 'Pole :attribute musí být platný JSON řetězec.',
    'list' => 'Pole :attribute musí být seznam.',
    'lowercase' => 'Pole :attribute musí být psáno malými písmeny.',
    'lt' => [
        'array' => 'Pole :attribute musí obsahovat méně než :value položek.',
        'file' => 'Pole :attribute musí být menší než :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být menší než :value.',
        'string' => 'Pole :attribute musí být kratší než :value znaků.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmí obsahovat více než :value položek.',
        'file' => 'Pole :attribute musí být menší nebo rovno :value kilobajtů.',
        'numeric' => 'Pole :attribute musí být menší nebo rovno :value.',
        'string' => 'Pole :attribute musí být kratší nebo rovno :value znaků.',
    ],
    'mac_address' => 'Pole :attribute musí být platná MAC adresa.',
    'max' => [
        'array' => 'Pole :attribute nesmí obsahovat více než :max položek.',
        'file' => 'Pole :attribute nesmí být větší než :max kilobajtů.',
        'numeric' => 'Pole :attribute nesmí být větší než :max.',
        'string' => 'Pole :attribute nesmí být delší než :max znaků.',
    ],
    'max_digits' => 'Pole :attribute nesmí obsahovat více než :max číslic.',
    'mimes' => 'Pole :attribute musí být soubor typu: :values.',
    'mimetypes' => 'Pole :attribute musí být soubor typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musí obsahovat alespoň :min položek.',
        'file' => 'Pole :attribute musí být alespoň :min kilobajtů.',
        'numeric' => 'Pole :attribute musí být alespoň :min.',
        'string' => 'Pole :attribute musí být alespoň :min znaků dlouhé.',
    ],
    'min_digits' => 'Pole :attribute musí obsahovat alespoň :min číslic.',
    'missing' => 'Pole :attribute musí chybět.',
    'missing_if' => 'Pole :attribute musí chybět, když :other je :value.',
    'missing_unless' => 'Pole :attribute musí chybět, pokud :other není :value.',
    'missing_with' => 'Pole :attribute musí chybět, když je přítomno :values.',
    'missing_with_all' => 'Pole :attribute musí chybět, když jsou přítomny hodnoty :values.',
    'multiple_of' => 'Pole :attribute musí být násobkem :value.',
    'not_in' => 'Vybraná hodnota :attribute je neplatná.',
    'not_regex' => 'Formát pole :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí být číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovat alespoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovat alespoň jedno velké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovat alespoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovat alespoň jeden symbol.',
        'uncompromised' => 'Zadané :attribute se objevilo v úniku dat. Zvolte prosím jiné :attribute.',
    ],
    'present' => 'Pole :attribute musí být přítomno.',
    'present_if' => 'Pole :attribute musí být přítomno, když :other je :value.',
    'present_unless' => 'Pole :attribute musí být přítomno, pokud :other není :value.',
    'present_with' => 'Pole :attribute musí být přítomno, když je přítomno :values.',
    'present_with_all' => 'Pole :attribute musí být přítomno, když jsou přítomny hodnoty :values.',
    'prohibited' => 'Pole :attribute je zakázáno.',
    'prohibited_if' => 'Pole :attribute je zakázáno, když :other je :value.',
    'prohibited_if_accepted' => 'Pole :attribute je zakázáno, když je :other přijato.',
    'prohibited_if_declined' => 'Pole :attribute je zakázáno, když je :other odmítnuto.',
    'prohibited_unless' => 'Pole :attribute je zakázáno, pokud :other není v :values.',
    'prohibits' => 'Pole :attribute zakazuje přítomnost :other.',
    'regex' => 'Formát pole :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovat položky pro: :values.',
    'required_if' => 'Pole :attribute je povinné, když :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, když je :other přijato.',
    'required_if_declined' => 'Pole :attribute je povinné, když je :other odmítnuto.',
    'required_unless' => 'Pole :attribute je povinné, pokud :other není v :values.',
    'required_with' => 'Pole :attribute je povinné, když je přítomno :values.',
    'required_with_all' => 'Pole :attribute je povinné, když jsou přítomny hodnoty :values.',
    'required_without' => 'Pole :attribute je povinné, když není přítomno :values.',
    'required_without_all' => 'Pole :attribute je povinné, když není přítomna žádná z hodnot :values.',
    'same' => 'Pole :attribute se musí shodovat s :other.',
    'size' => [
        'array' => 'Pole :attribute musí obsahovat :size položek.',
        'file' => 'Pole :attribute musí být :size kilobajtů.',
        'numeric' => 'Pole :attribute musí být :size.',
        'string' => 'Pole :attribute musí být :size znaků dlouhé.',
    ],
    'starts_with' => 'Pole :attribute musí začínat jedním z následujících: :values.',
    'string' => 'Pole :attribute musí být řetězec.',
    'timezone' => 'Pole :attribute musí být platné časové pásmo.',
    'unique' => 'Tato hodnota :attribute je již použita.',
    'uploaded' => 'Nahrávání pole :attribute se nezdařilo.',
    'uppercase' => 'Pole :attribute musí být psáno velkými písmeny.',
    'url' => 'Pole :attribute musí být platná URL adresa.',
    'ulid' => 'Pole :attribute musí být platný ULID.',
    'uuid' => 'Pole :attribute musí být platný UUID.',

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
            'rule-name' => 'vlastní-zpráva',
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
        'name' => 'jméno',
        'email' => 'e-mailová adresa',
        'password' => 'heslo',
        'title' => 'název',
        'description' => 'popis',
        'start_date' => 'datum zahájení',
        'end_date' => 'datum ukončení',
        'start_time' => 'čas zahájení',
        'end_time' => 'čas ukončení',
        'location' => 'místo',
        'team_id' => 'družina',
        'member_id' => 'člen',
        'surname' => 'příjmení',
        'age' => 'věk',
        'telephone' => 'telefon',
        'mother_name' => 'jméno matky',
        'mother_surname' => 'příjmení matky',
        'mother_telephone' => 'telefon matky',
        'mother_email' => 'e-mail matky',
        'father_name' => 'jméno otce',
        'father_surname' => 'příjmení otce',
        'father_telephone' => 'telefon otce',
        'father_email' => 'e-mail otce',
    ],

];
