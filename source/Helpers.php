<?php

/**
 * ####################
 * ###   VALIDATE   ###
 * ####################
 */

function is_email(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}