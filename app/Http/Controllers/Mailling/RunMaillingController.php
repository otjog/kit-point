<?php

namespace App\Http\Controllers\Mailling;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Site\Mailling;
use App\Events\MaillingForRegister;
use Illuminate\Support\Facades\Storage;

class RunMaillingController extends Controller
{
    protected $mailling;

    public function __construct(Mailling $mailling)
    {
        $this->mailling = $mailling;
    }

    public function runAll()
    {
        $maillings = $this->mailling->getActiveMaillings();

        $this->run($maillings);
    }

    public function runOne($id)
    {
        $mailling = $this->mailling->getActiveMaillingById($id);

        $this->run($mailling);
    }

    public function unsubscribe($email)
    {
        $email = urldecode($email);

        Storage::put('unsubscribes/' . $email, $email);

        return "Вы успешно отписались от рассылки. Извините за беспокойство.";
    }

    protected function run($maillings)
    {
        foreach ($maillings as $mailling) {
            event(new MaillingForRegister($mailling));
        }
    }
}
