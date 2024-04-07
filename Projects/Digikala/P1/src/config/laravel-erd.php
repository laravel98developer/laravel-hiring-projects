<?php

return [
    'url' => 'erd',
    'middlewares' => [
        //Example
        //\App\Http\Middleware\NotFoundWhenProduction::class,
    ],
    'models_path'      => base_path('app/Models'),
    'docs_path'        => base_path('docs/erd/'),

    "display" => [
        "show_data_type" => false,

        /**
         * Controls how the lines between models are drawn.
         *
         * Valid values are: Normal, Orthogonal, or AvoidsNodes.
         *
         * AvoidsNodes can be very slow in larger diagrams!
         */
        "routing" => 'AvoidsNodes',
    ],

    "from_text" => [
        "BelongsTo"     => "1..1\nBelongs To",
        "BelongsToMany" => "1..*\nBelongs To Many",
        "HasMany"       => "1..*\nHas Many",
        "HasOne"        => "1..1\nHas One",
        "ManyToMany"    => "*..*\nMany To Many",
        "ManyToOne"     => "*..1\nMany To One",
        "OneToMany"     => "1..*\nOne To Many",
        "OneToOne"      => "1..1\nOne To One",
        "MorphTo"       => "1..1\n",
        "MorphToMany"   => "1..*\n",
    ],
    "to_text" => [
        "BelongsTo"     => "",
        "BelongsToMany" => "",
        "HasMany"       => "",
        "HasOne"        => "",
        "ManyToMany"    => "",
        "ManyToOne"     => "",
        "OneToMany"     => "",
        "OneToOne"      => "",
        "MorphTo"       => "",
        "MorphToMany"   => "",
    ],
];
