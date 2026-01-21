<?php

return [
    'name' => [
        'required' => 'The name field is required.',
        'max' => 'The name may not be greater than 255 characters.',
    ],
    'surname' => [
        'required' => 'The surname field is required.',
        'max' => 'The surname may not be greater than 255 characters.',
    ],
    'phone' => [
        'required' => 'The phone field is required.',
        'unique' => 'This phone number is already registered.',
        'max' => 'Phone number may not be greater than 255 characters.',
    ],
    'country_id' => [
        'required' => 'The country field is required.',
    ],
    'email' => [
        'required' => 'The email field is required.',
        'email' => 'The email must be a valid email address.',
        'max' => 'The email may not be greater than 255 characters.',
        'unique' => 'This email address is already registered.',
        'email' => 'It must be a valid email address.',
    ],
    'captcha' => [
        'required' => 'Captcha verification is required.',
    ],
    'subject' => [
        'required' => 'Subject is required.',
        'max' => 'The email may not be greater than 100 characters.',
    ],
    'token' => [
        'required' => 'Token is required.',
    ],
    'agree' => [
        'required' => 'You must accept the terms of use.',
    ],
    'company_name' => [
        'required' => 'The company name field is required.',
    ],
    'company_about' => [
        'required' => 'The company description field is required.',
        'max' => 'The company description may not be greater than 1000 characters.',
    ],
    'password' => [
        'min' => 'The password must be at least 6 characters.',
        'required' => 'The password field is required.',
        'confirmed' => 'The password confirmation does not match.',
    ],
    'new_password' => [
        'min' => 'The new password must be at least 6 characters.',
        'required' => 'The new password field is required.',
        'confirmed' => 'The new password confirmation does not match.',
    ],
    'title' => [
        'required' => 'The company name is required.',
        'unique' => 'This company name is already taken.',
    ],
    'avatar' => [
        'image' => 'Avatar must be an image file.',
        'mimes' => 'Avatar must be a file of type: jpeg, png, jpg, webp.',
        'max' => 'Avatar size must be less than 5048 KB.',
    ],
    'fax' => [
        'max' => 'Fax number may not be greater than 255 characters.',
    ],
    'website' => [
        'url' => 'Please enter a valid website URL.',
        'max' => 'Website URL may not be greater than 255 characters.',
    ],
    'links' => [
        '*.type.required' => 'The social media type is required.',
        '*.link.required' => 'The social media link is required.',
        '*.link.url' => 'Please enter a valid URL.',
    ],
    'language' => [
        'max' => 'The language may not be greater than 255 characters.',
    ],
    'end_at' => [
        'date' => 'Please enter a valid end date.',
        'after_or_equal' => 'The end date cannot be before the start date.',
    ],
    'reference_code' => [
        'max' => 'The reference code may not be greater than 255 characters.',
    ],
    'job_type_id' => [
        'exists' => 'Please enter a valid job type ID.',
    ],
    'job_sector_id' => [
        'exists' => 'Please enter a valid job sector ID.',
    ],
    'job_position_id' => [
        'exists' => 'Please enter a valid job position ID.',
    ],
    'job_position_level' => [
        'exists' => 'Please enter a valid job position level ID.',
    ],
    'job_experience_level' => [
        'exists' => 'Please enter a valid job experience level ID.',
    ],
    'user_phone' => [
        'max' => 'The phone number may not be greater than 255 characters.',
    ],
    'approve_statu' => [
        'boolean' => 'The approval status must be a valid value.',
    ],
    'approve_type' => [
        'max' => 'The approval type may not be greater than 255 characters.',
    ],
    'approve_link' => [
        'max' => 'The approval link may not be greater than 255 characters.',
    ],
    'approve_email' => [
        'email' => 'Please enter a valid email address.',
        'max' => 'The email address may not be greater than 255 characters.',
    ],
    'message' => [
        'required' => 'The message field is required.',
        'max' => 'The message may not be greater than 1000 characters.',
    ],

];
