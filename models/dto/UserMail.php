<?php

namespace app\models\dto;

use app\models\Persona;

class UserMail
{
    public string $fullName;
    public string $email;
    public string $plainPassword;
    public string $username;

    /**
     * Use this method for instantiate an UserMail with plain-password to use into the recovery mail's
     */
    public static function instantiateFromPerson(Persona $person, string $plainPassword): self
    {
        $userMail = new self();
        $userMail->email = $person->mail;
        $userMail->fullName = $person->apellidoNombre;
        $userMail->username = $person->idUsuario0->nombreUsuario;
        $userMail->plainPassword= $plainPassword;

        return $userMail;
    }
}
