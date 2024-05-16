<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SampleMail extends Mailable implements ShouldQueue
{
  use Queueable, SerializesModels;

  public $fullname;

  public function __construct($fullname)
  {
    $this->fullname = $fullname;
  }

  public function build()
  {
    return $this->view('WBS_content.Mail')->with(['fullname' => $this->fullname]);
  }
}
