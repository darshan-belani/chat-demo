<?php

use App\Models\User;

function getAdminUser()
{
    return User::where('role','=', "1")->first();
}