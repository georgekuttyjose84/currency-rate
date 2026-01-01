<?php

return [
    'up' => "
        CREATE TABLE currency_rates (
            id INT AUTO_INCREMENT PRIMARY KEY,
            base_currency VARCHAR(3) NOT NULL,
            target_currency VARCHAR(3) NOT NULL,
            rate DECIMAL(10,6) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ",
    'down' => "
        DROP TABLE IF EXISTS currency_rates;
    "
];

