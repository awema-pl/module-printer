<?php
namespace AwemaPL\Printer\Sections\Nodeprinters\Policies;

use AwemaPL\Printer\Sections\Nodeprinters\Models\Nodeprinter;
use Illuminate\Foundation\Auth\User;

class NodeprinterPolicy
{

    /**
     * Determine if the given post can be updated by the user.
     *
     * @param  User $user
     * @param  Nodeprinter $printer
     * @return bool
     */
    public function isOwner(User $user, Nodeprinter $printer)
    {
        return $user->id === $printer->user_id;
    }


}
