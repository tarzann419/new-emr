<?php

function getUserRole($user)
{
    if ($user->hasRole('admin')) {
        return 'admin';
    } elseif ($user->hasRole('doctor')) {
        return 'doctor';
    } elseif ($user->hasRole('patient')) {
        return 'patient';
    } else {
        return 'guest';
    }
}

function tenant_id()
{
    return auth()->user()->tenant_id ?? '';
}

function patient_id()
{
    if (auth()->user()->hasRole('patient')) {
        // return the patient ID of the authenticated user
        return auth()->user()->patient->id;
    }
}

function username()
{
    return auth()->user()->username ?? '';
}
