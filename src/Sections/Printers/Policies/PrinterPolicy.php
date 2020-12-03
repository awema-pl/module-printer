<?php
namespace AwemaPL\Printer\Sections\Printers\Policies;

use AwemaPL\Printer\Sections\Printers\Models\Printer;
use Illuminate\Foundation\Auth\User;

class PrinterPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User $user
     * @param  Printer $printer
     * @return bool
     */
    public function isOwner(User $user, Printer $printer)
    {
        return $user->id === $printer->user_id;
    }


}
